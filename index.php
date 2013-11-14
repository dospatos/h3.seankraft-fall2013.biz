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
<script src="jquery-1.10.2.js"> </script>


</head>

<body>

<article style="width:700px">
    <header>
        <h2>Sean Kraft CSCI E-15</h2>
    </header>


    <h2>Javascript Timer</h2>
    <section>
        <input type='hidden' id='txtMinAllowed' name='txtMinAllowed' value='1000'/>
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
        <canvas id="TimerDisplay" width="100" height="65"></canvas>
    </section>

    <footer>
        <p>Posted by: Sean Kraft</p>
        <p><time datetime="2013-09-15"></time></p>
    </footer>

</article>

</body>
<script language="javascript">

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
        var c=document.getElementById("TimerDisplay");
        var fontSize = c.height * .3;

        var fontY = fontSize * 1.15;
        var xPos = c.width * .1;
        var totalBarWidth = xPos * 8;
        var spacingWidth = c.height / 20;
        var ctx=c.getContext("2d");
        ctx.font=fontSize + "px Arial";
        ctx.fillStyle="#FF0000";
        ctx.fillRect(0,0, c.width, c.height);
        ctx.fillStyle="black";
        ctx.fillText("00:" + Mins + "0:" + Secs, xPos, fontY);
        ctx.fillStyle="green";
        //Fill the status bar
        var totalSecondsElapsed = (Mins * 60) + Secs;
        var totalSecondsAllowed = Allowed * 60;
        var percentComplete = totalSecondsElapsed / totalSecondsAllowed;
        ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth, spacingWidth * 4);
        ctx.fillStyle="Yellow";
        ctx.fillRect(xPos, fontY + spacingWidth, totalBarWidth * percentComplete, spacingWidth * 4);



        //If we are up to the time we are allowed, it's time to finish
        if (Mins == Allowed) {
            alert("Your time is up, click OK to complete the test.")
            <!--<%#GetTimeoutJavascript()%>-->
        }

        //set the timeout again
        setTimeout("DisplayTimer()",1000);

    }

    $( document ).ready(function() {
        DisplayTimer();
    });

</script>
</html>