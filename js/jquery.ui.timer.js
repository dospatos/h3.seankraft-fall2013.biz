(function($) {
    $.widget("ui.timer",{
            options: {
                height: "100px",
                width: "200px",
                textColor: "#000000",
                backgroundColor: "#FFFFFF",
                timeLeftColor: "#007F0E",
                timeTakenColor: "#FF0000",
                secondsEt: 0,
                minutesAllowed: 30,
                serverTimerId: null,
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
                self._trigger("added", null, "");

                //Get this thing ticking
                this.tick();

            },
            tick: function () {

                var totalSecondsAllowed = this.options.minutesAllowed * 60;

                //calculate all the times from the elapsed time in seconds
                this.options.secs = this.options.secondsEt % 60;
                this.options.mins = Math.floor(this.options.secondsEt/60);
                this.options.hours = Math.floor(this.options.mins/60);

                window.console.log("hours" + this.options.hours + ", mins: " + this.options.mins + ", Secs:" + this.options.secs);

                alert(this.isDiv());
                alert(this.isCanvasSupported());
                if (this.options.percentComplete >= 1) {
                    this._trigger("timeup", null, "");
                } else {
                    //figure out what % complete we are
                    this.options.percentComplete = this.options.secondsEt / totalSecondsAllowed;

                    this.displayTimer();
                    localId = this.element[0].id;
                    this.options.secondsEt++;//count off a second
                    setTimeout("$('#" + localId + "').timer('tick','')",1000);
                }

            },
            displayTimer: function(){
                var ClockText = this.formatTimePart(this.options.hours) + ":" + this.formatTimePart(this.options.mins) + ":" + this.formatTimePart(this.options.secs);
                if (this.isDiv()) {
                    alert('paint the div');
                    this.element.html(ClockText);
                } else {
                    var canvas=this.element[0];
                    var ctx=canvas.getContext("2d");
                    var fontSize = canvas.height * .3;

                    //calculate the width of the font with respect to the width of the panel
                    fontSize = 75;
                    do {
                        ctx.font = fontSize + 'px Arial';
                        var TextWidth = ctx.measureText(ClockText);
                        fontSize--;
                    } while ((TextWidth.width + (canvas.width *.2)) > canvas.width)//the width with a 10% margin on each side


                    var fontY = canvas.height * .5;//half the height
                    var xPos = canvas.width * .1;//start at %10 of the width
                    var totalBarWidth = TextWidth.width;
                    var spacingWidth = canvas.height / 20;

                    ctx.fillStyle="#FF0000";//timer's background color
                    ctx.fillRect(0,0, canvas.width, canvas.height);

                    ctx.fillStyle="black"; //font color
                    ctx.fillText(ClockText, xPos, fontY);

                    //Fill the status bar
                    ctx.fillStyle="green"; //time left bar color
                    ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth, spacingWidth * 4);
                    ctx.fillStyle="Yellow"; //time taken color
                    ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth * this.options.percentComplete, spacingWidth * 4);
                }
            },
            isCanvasSupported: function(){
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
            }
        }

    );
})(jQuery);

/*
 options: {
 location: "bottom",
 color: "#fff",
 backgroundColor: "#000"
 }
 , _create:function() {

 var self = this,
 o = self.options,
 el = self.element,
 cap = $("<span></span>").text(el.attr("alt")).addClass("ui-widget ui-caption").css({
 backgroundColor: o.backgroundColor,
 color: o.color,
 width: el.width()
 }).insertAfter(el),
 capWidth = el.width() - parseInt(cap.css("paddingLeft")) - parseInt(cap.css("paddingRight")),
 capHeight = cap.outerHeight() - parseInt(cap.css("paddingTop")) + parseInt(cap.css("paddingBottom"));

 cap.css({
 width: capWidth,
 top: (o.location === "top") ? el.offset().top : el.offset().top + el.height() - capHeight,
 left: el.offset().left,
 display: "block"
 });

 $(window).resize(function(){
 cap.css({
 top: (o.location === "top") ? el.offset().top : el.offset().top + el.height() - capHeight,
 left: el.offset().left
 });
 self._trigger("added", null, cap);

 });
 }, destroy: function() {
 this.element.next().remove();
 $(window).unbind("resize");
 },_setOption: function(option, val) {
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







 */