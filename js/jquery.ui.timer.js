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
                serverTimerId: null

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
                alert('here');

                var ctx=el[0].getContext("2d");
                //alert(ctx);


                $(window).resize(function(){
                    console.log("resize");
                        });
                self._trigger("added", null, "");
               // window.setInterval(function() {this.tick();}, 1000)
                this.tick();//start the timer

            },
            tick: function () {
                //set the timeout for one second
                var totalSecondsAllowed = this.options.minutesAllowed * 60;
                var ET = this.options.secondsEt;
                var Mins = ET/60;
                if (Mins < 1){Mins=0;}
                var Secs = ET - (Mins*60);
                window.console.log("mins: " + Mins + ", Secs:" + Secs);
                var percentComplete = ET / totalSecondsAllowed;

                if (percentComplete >= 1) {
                    this._trigger("timeup", null, "");
                } else {
                    window.console.log("tick: " + percentComplete);
                    localId = this.element[0].id;

                    //********
                    var canvas=this.element[0];
                    var ctx=canvas.getContext("2d");
                    var fontSize = canvas.height * .3;

                    //calculate the width of the font with respect to the width of the panel
                    var ClockText = "00:" + Mins + "0:" + Secs;
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
                    ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth * percentComplete, spacingWidth * 4);

                    //*****
                    this.options.secondsEt++;
                    setTimeout("$('#" + localId + "').timer('tick','')",1000);
                }
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