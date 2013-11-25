<?php
/*
 * Created by JetBrains PhpStorm.
 * User: skraft
 * Date: 9/6/13
 * Time: 3:12 PM
 * Create by Sean Kraft for CSCI-E15 Fall 2013
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sean Kraft's CSCI E-15 Web Page</title>
<link type="text/css" rel="stylesheet" href="basic-minimal.css">
<script src="js/jquery-1.10.2.js"> </script>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery.ui.timer.js"></script>


</head>

<body>

<article style="width:700px">
    <header>
        <h2>Sean Kraft CSCI E-15</h2>
    </header>


    <h2>Javascript Timer</h2>
    <section>
        <input type='hidden' id='txtMinAllowed' name='txtMinAllowed' value='1'/>
        <input type='hidden' id='txtMinElapsed' name='txtMinElapsed' value='0'/>
        <input type='hidden' id='txtSecondsElapsed' name='txtSecondsElapsed' value='0'/>
        <table>
            <tr>
                <td colspan="2">
                        You have 30 minutes to complete this test.
                        Time spent so far:&nbsp;
                        <span id="divTimeState"></span>
                </td>
            </tr>
        </table>
        <canvas id="TimerDisplay" width="150" height="200"></canvas>

        <img id="iceland_dog" src="iceland_dog.jpg" alt="This is some dog"/>
    </section>

    <footer>
        <p>Posted by: Sean Kraft</p>
        <p><time datetime="2013-09-15"></time></p>
    </footer>

</article>

</body>
<script language="javascript">

    window.console.log('test');
    //initialize the timer
    var bInitialized = false;

    //Called every second to incriment the timer
    function DisplayTimer() {
        //get the time values from the hidden fields
        var Allowed = document.all["txtMinAllowed"].value;
        var Mins = document.all["txtMinElapsed"].value;
        var Secs = document.all["txtSecondsElapsed"].value;

        if (bInitialized) {
            Secs++;
            //if we are past 60 seconds time to incriment the minutes
            if (Secs > 60) {
                Secs = 1;
                Mins++;
            }
        }
        //update the values
        document.all["txtMinElapsed"].value = Mins;
        document.all["txtSecondsElapsed"].value = Secs;
        bInitialized = true;

        //update the display
        document.all["divTimeState"].innerHTML = Mins + ":" + Secs;

        //var c = $( '#TimerDisplay' );
        //alert(c);
        var canvas=document.getElementById("TimerDisplay");
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

        document.all["divTimeState"].innerHTML = "Font:" + fontSize;

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
        var totalSecondsElapsed = (Mins * 60) + Secs;
        var totalSecondsAllowed = Allowed * 60;
        var percentComplete = totalSecondsElapsed / totalSecondsAllowed;
        ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth, spacingWidth * 4);
        ctx.fillStyle="Yellow"; //time taken color
        ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth * percentComplete, spacingWidth * 4);

        //alert(TextWidth);

        //If we are up to the time we are allowed, it's time to finish
        if (Mins == Allowed) {
            //alert("Your time is up, click OK to complete the test.")
            <!--<%#GetTimeoutJavascript()%>-->
            //Tie in an event handler here
        }

        //set the timeout for one second
        setTimeout("DisplayTimer()",1000);

    }

    $( document ).ready(function() {
        DisplayTimer();
        $("#TimerDisplay").timer({ added: function(e, ui){}
            , minutesAllowed:.5
            ,timeup: function(e,ui){alert('timeup');}});
        //$("#iceland_dog").timer({ added: function(e, ui){ });
    });

</script>
</html>