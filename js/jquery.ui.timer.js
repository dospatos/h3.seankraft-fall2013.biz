(function($) {
    $.widget("ui.timer",{
            options: {
                textColor: "#000000",
                backgroundColor: "#FFFFFF",
                timeLeftColor: "#007F0E",
                timeTakenColor: "#FF0000",
                secondsEt: 0,
                minutesAllowed: 1,
                synchWithServer: true,
                serverTimerId: null,
                ajaxUrlRoot: "index/",
                percentComplete: 0

            },
            _create: function() {
                var self = this,
                    o = self.options,
                    el = self.element,
                    mins = 0, secs = 0,
                    localId = el[0].id;

                //thanks to eyelidlessness on stackOF for this alert override technique
                window.nativeAlert = window.alert;
                window.alert = function(alertText) {
                    window.console.log(alertText);
                }

                $(window).resize(function(){
                    console.log("resize");
                        });

                //setup the server timer if required
                if (o.synchWithServer) {
                    $serverTimerID = null;
                    $.ajax({
                        type: "GET",
                        url: o.ajaxUrlRoot + "increment/",//Calling increment with a blank returns a new timerId for us
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        async: false,
                        success : function(data) {
                            $serverTimerID = data;
                        }
                    });
                    o.serverTimerId = $serverTimerID;//Keep the timerId for the client
                }

                //Let the client know we've got a timer going (or not in the case the timerId is null)
                self._trigger("initServerTimer", null, {serverTimerId: o.serverTimerId});

                //Get this thing ticking
                this.tick();

            },
            tick: function () {//this gets fired every second
                var totalSecondsAllowed = this.options.minutesAllowed * 60;

                //calculate all the times from the elapsed time
                this.options.secs = this.options.secondsEt % 60;
                this.options.mins = Math.floor(this.options.secondsEt/60);
                this.options.hours = Math.floor(this.options.mins/60);

                //window.console.log("hours" + this.options.hours + ", mins: " + this.options.mins + ", Secs:" + this.options.secs);

                if (this.options.percentComplete >= 1) {
                    this._trigger("timeup", null, {serverTimerId: this.options.serverTimerId});
                    if (this.options.synchWithServer) {
                        //stop the counter on the server
                        $.ajax({
                            type: "GET",
                            url: this.options.ajaxUrlRoot + "stop/" + this.options.serverTimerId,
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            async: true
                        });
                    }
                } else {
                    //figure out what % complete we are
                    this.options.percentComplete = this.options.secondsEt / totalSecondsAllowed;

                    //count off a second here and on the server if required
                    this.options.secondsEt++;
                    if (this.options.synchWithServer) {
                        $ajaxUrl = this.options.ajaxUrlRoot + "increment/" + this.options.serverTimerId
                        $.ajax({
                            type: "GET",
                            url: $ajaxUrl,
                            async: true,//note: we're using async and we don't care about the return (better for speed)
                            contentType: "application/json; charset=utf-8",
                            dataType: "json"
                        });
                    }

                    //present the timer to the user
                    this.displayTimer();

                    //keep the ticker going
                    localId = this.element[0].id;
                    setTimeout("$('#" + localId + "').timer('tick','')",1000);
                }

            },
            displayTimer: function(){//displays on a div or a panel
                var ClockText = this.formatTimePart(this.options.hours) + ":" + this.formatTimePart(this.options.mins) + ":" + this.formatTimePart(this.options.secs);
                if (!this.isDiv()) {
                    var canvas = this.element[0];
                    var ctx = canvas.getContext("2d");
                    var fontSize = canvas.height * .3;

                    //calculate the width of the font with respect to the width of the panel
                    fontSize = 75;
                    do {
                        ctx.font = fontSize + 'px Arial';
                        var TextWidth = ctx.measureText(ClockText);
                        fontSize--;
                    } while ((TextWidth.width + (canvas.width * .2)) > canvas.width)//the width with a 10% margin on each side


                    var fontY = canvas.height * .5;//half the height
                    var xPos = canvas.width * .1;//start at %10 of the width
                    var totalBarWidth = TextWidth.width;
                    var spacingWidth = canvas.height / 20;

                    ctx.fillStyle = this.options.backgroundColor;//timer's background color
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    ctx.fillStyle = this.options.textColor; //font color
                    ctx.fillText(ClockText, xPos, fontY);

                    //Fill the status bar
                    ctx.fillStyle = this.options.timeLeftColor; //time left bar color
                    ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth, spacingWidth * 4);
                    ctx.fillStyle = this.options.timeTakenColor; //time taken color
                    ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth * this.options.percentComplete, spacingWidth * 4);
                } else {
                    this.element.html(ClockText);
                }
            },
            serialize: function() {//get a jSon representation of the object to post back to the server
                return '{'
                    +'"textColor" : ' + this.options.textColor + ','
                    +'"backgroundColor" : ' + this.options.backgroundColor + ','
                    +'"timeLeftColor" : ' + this.options.timeLeftColor + ','
                    +'"timeTakenColor" : ' + this.options.timeTakenColor + ','
                    +'"secondsEt" : ' + this.options.secondsEt + ','
                    +'"minutesAllowed" : ' + this.options.minutesAllowed + ','
                    +'"synchWithServer" : ' + this.options.synchWithServer + ','
                    +'"serverTimerId" : ' + this.options.serverTimerId + ','
                    +'"ajaxUrlRoot" : ' + this.options.ajaxUrlRoot + ','
                    +'"percentComplete" : ' + this.options.percentComplete + ','
                    +'}';

            },
            isCanvasSupported: function(){//returns true if the browser supports an HTML5 canvas
                return !!window.CanvasRenderingContext2D;
            },
            isDiv: function(){return this.element.is("div");},
            formatTimePart: function(timePart) {
                    return timePart > 9 ? "" + timePart: "0" + timePart;
            },
            destroy: function() {
                this.element.next().remove();
                $(window).unbind("resize");
            },
            _setOption: function(option, val) {
                $.Widget.prototype._setOption.apply(this, arguments);

                var el = this.element,
                    cap = el.next(),
                    capHeight = cap.outerHeight() - parseInt(cap.css("paddingTop")) + parseInt(cap.css("paddingBottom"));
                switch (option) {
                    case "location":
                        (value === "top") ? cap.css("top", el.offset().top) : cap.css("top", el.offset().top + el.height() - capHeight);
                        break;
                    case "color":
                        el.next().css("color", value);
                        break;
                    case "backgroundColor":
                        el.next().css("backgroundColor", value);
                        break;
                }
            },
            _setOptions: function( options ) {
                var that = this,
                    resize = false;

                $.each( options, function( key, value ) {
                    that._setOption( key, value );
                    if ( key === "height" || key === "width" ) {
                        resize = true;
                    }
                });

                if ( resize ) {
                    this.resize();
                }
            }
        }

    );
})(jQuery);