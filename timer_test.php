<?php
/*
 * Created by JetBrains PhpStorm.
 * User: skraft
 * Date: 9/6/13
 * Time: 3:12 PM
 * Create by Sean Kraft for CSCI-E15 Fall 2013
 */
if (isset($_POST["txtTimerState"])) {
    echo($_POST["txtTimerState"]);
    $timerState = $_POST["txtTimerState"];
    $j = json_decode($timerState);
    echo(var_dump($j));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sean Kraft's CSCI E-15 Web Page</title>
<link type="text/css" rel="stylesheet" href="css/basic-minimal.css">
<script src="js/jquery-1.10.2.js"> </script>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery.ui.timer.js"></script>
<link href="css/jquery.miniColors.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.miniColors.js"></script>


</head>

<body>

<article style="width:700px">
    <header>
        <h2>Sean Kraft CSCI E-15</h2>
    </header>


    <h2>Javascript Timer</h2>
    <p>Behold the jQuery Timer plugin. Turns an HTML canvas into a handsome countdown clock!</p>
    <section id="timerCreateSection">
        <fieldset>
            <legend>Create Your Own Timer</legend>
            <p>Minutes Allowed: <input type="text" id="txtMinutesAllowed" value="1"/> | Use HTML5 Canvas: <input type="checkbox" id="chkUseCanvas"/> | Synch with Server: <input type="checkbox" id="chkSynchWithServer"/></p>
            <p>Text Color: <input class="color-picker" type="hidden" id="txtTextColor" value="#F0F72E"/> | Background Color: <input type="hidden" id="txtBackgroundColor" class="color-picker" value="#040008"/> | Time Taken Color: <input class="color-picker" type="hidden" id="txtTimeTakenColor" value="#FF0220"/> | Time Left Color: <input type="hidden" id="txtTimeLeftColor" class="color-picker" value="#3C9336"/></p>

            <input type="button" id="cmdCreateTimer" value="Create Timer"/>
        </fieldset>

    </section>
    <section id="timerSection">

        <canvas id="canTimerDisplay" width="100" height="75" class="timer"></canvas>
        <div id="divTimerDisplay" class="timer" style="width:100px;height:75px;background-color:red;color: black;font-family: Arial;font-size: 20px; text-align: center"/>

    </section>

    <hr>
    <form id="mainForm" method="post">
        <input type="hidden" id="txtTimerState" name="txtTimerState"/>
        <input type="submit" value="Post the form >>"/>
    </form>
    <footer>
        <p>Posted by: Sean Kraft</p>
        <p><time datetime="2013-09-15"></time></p>
    </footer>

</article>

</body>
<script language="javascript">

    $( document ).ready(function() {
        $(".color-picker").miniColors({
            letterCase: 'uppercase'
        });

        //Demo a panel used for a timer display
        $("#canTimerDisplay").timer({ added: function(e, ui){}
            , minutesAllowed:1.2
            , timeTakenColor: 'yellow', timeLeftColor: 'green', synchWithServer: true
            ,timeup: function(e,ui){alert('timeup - pnlTimerDisplay:' + ui.serverTimerId);}
            ,initServerTimer: function(e,ui){alert('pnlTimerDisplay serverTimerId: ' + ui.serverTimerId);}
        });

        //Demo a div used as a timer display - note: there is no server connection for this particular div also
        $("#divTimerDisplay").timer({ added: function(e, ui){}
            , minutesAllowed:1, synchWithServer:false
            ,timeup: function(e,ui){alert('timeup divTimerDisplay:' + ui.serverTimerId);}});


        //When we submit the form we want to capture all the timers so we can keep them going on the next page
        $( "form" ).submit(function( event ) {
            var json = $("#canTimerDisplay").timer('serialize');
            window.nativeAlert(json);
            //event.preventDefault();

            var allTimers = $('.timer');
            var allTimerSerialized ="";
            for (x=1; x<allTimers.length; x++) {
                currentTimer = $("#" + allTimers[x].id);
                allTimerSerialized+=currentTimer.timer("serialize");
                alert(currentTimer.timer("serialize"));
            }
            $("#txtTimerState").val(allTimerSerialized);
        });

        //wire up the button that allows a user to create their own timer
        $("#cmdCreateTimer").click(function () {
            var json = $("#TimerDisplay3").timer('serialize');
            alert(json);

            //Create a new HTMLElement and append it to the timerSection
            var container = $("#timerSection"), newTimer;
            var timerCount = $('.timer').length;
            timerCount++;
            var newTimerId = 'newTimer_' + timerCount;
            alert(timerCount);
            if ($('#chkUseCanvas').prop('checked')) {
                newTimer = document.createElement("canvas")
                newTimer.id = newTimerId;
                newTimer.className = "timer";
            } else {
                newTimer = $('<div/>', {
                    id: newTimerId,
                    class: 'timer',
                    style: 'border:1px solid black;width: 65px;height: 30px;color:'
                        + $('#txtTextColor').val()
                        + ';background-color:' + $('#txtBackgroundColor').val()
                });

            }

            container.append(newTimer);//add the new timer to the proper section
            newTimer = $("#" + newTimerId);//not sure why but jQuery needs us to retrieve the new div from jQuery for it to work
            newTimer.timer({ added: function(e, ui){}
               , minutesAllowed:$('#txtMinutesAllowed').val(), synchWithServer:$('#chkSynchWithServer').prop('checked')
               ,backgroundColor: $('#txtBackgroundColor').val(), textColor: $('#txtTextColor').val()
               ,timeTakenColor: $('#txtTimeTakenColor').val(), timeLeftColor: $('#txtTimeLeftColor').val()
               ,timeup: function(e,ui){alert('timeup ' + newTimerId + ' serverTimerId:' + ui.serverTimerId);}});

        });
    });

</script>
</html>