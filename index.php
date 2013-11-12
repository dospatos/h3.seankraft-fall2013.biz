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


</head>

<body>

<article style="width:700px">
    <header>
        <h2>Sean Kraft CSCI E-15</h2>
    </header>


    <h2>Javascript Timer</h2>
    <section>
        <input type='hidden' id='txtMinAllowed' name='txtMinAllowed' value='30'/>
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
    function StartClock() {
        DisplayTimer();
        alert('here 2');
    }

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

        //If we are up to the time we are allowed, it's time to finish
        if (Mins == Allowed) {
            alert("Your time is up, click OK to complete the test.")
            <!--<%#GetTimeoutJavascript()%>-->
        }

        //set the timeout again
        setTimeout("DisplayTimer()",1000);

    }

    alert('here');
    StartClock();
</script>
</html>