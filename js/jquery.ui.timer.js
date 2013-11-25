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

                window.console.log(localId);
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
                var percentComplete = this.options.secondsEt / totalSecondsAllowed;

                if (percentComplete >= 1) {
                    this._trigger("timeup", null, "");
                } else {
                    window.console.log("tick: " + percentComplete);
                    this.options.secondsEt++;
                    localId = this.element[0].id;
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