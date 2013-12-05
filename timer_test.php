<?php
/*
 * Created by JetBrains PhpStorm.
 * User: skraft
 * Date: 12/05/13
 * Time: 3:12 PM
 * Create by Sean Kraft for CSCI-E15 Fall 2013
 */
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
        <h2>Sean Kraft CSCI E-15: Project #3</h2>
    </header>


    <h2>jQuery UI Timer plugin demo</h2>
    <p>Turns an HTML canvas into a handsome countdown clock!
    <ul>
        <li>Uses jQuery UI widget factory, code in jquery.ui.timer.js</li>
        <li>Supports HTML5 canvas for a fancy clock with progress bar, and div tags for a simple readout</li>
        <li>Optionally ties back to server using Ajax, PHP, and mySQL</li>
        <li>Raises timeup and initServerTimer events to allow client to react</li>
        <li>Supports timer persistence across posts with serialize function (i.e. keeps on ticking). To test, create a timer and post the form.</li>
        <li>Plan is to use this timer on my project #4 which is an online testing site</li>
    </ul>
    </p>
    <section id="timerCreateSection">
        <fieldset>
            <legend>Create Your Own Timer</legend>
            <p>Minutes Allowed: <input type="text" id="txtMinutesAllowed" value="1"/> | Use HTML5 Canvas: <input type="checkbox" id="chkUseCanvas" checked/> | Synch with Server: <input type="checkbox" id="chkSynchWithServer"/></p>
            <p>Text Color: <input class="color-picker" type="hidden" id="txtTextColor" value="#F0F72E"/> | Background Color: <input type="hidden" id="txtBackgroundColor" class="color-picker" value="#040008"/> | Time Taken Color: <input class="color-picker" type="hidden" id="txtTimeTakenColor" value="#FF0220"/> | Time Left Color: <input type="hidden" id="txtTimeLeftColor" class="color-picker" value="#3C9336"/></p>

            <input type="button" id="cmdCreateTimer" value="Create Timer"/>
        </fieldset>

    </section>
    <section id="timerSection">
        <canvas id="canTimerDisplay" width="100" height="75"></canvas>
        <div id="divTimerDisplay" class="timer" classname="timer"></div>
        <?php
        //Go through the posted timer states and set the timers back up again in the HTML
        if (isset($_POST["txtTimerState"])) {
            $timerState = $_POST["txtTimerState"];
            //echo $timerState;
            $j = json_decode($timerState, true);
            //echo(var_dump($j));

            //each item is a timer waiting to be reborn!
            foreach($j as $item) {
                $elementId = $item['elementId'];
                $elementType = $item['elementType'];
                $textColor = $item['textColor'];
                $backgroundColor = $item['backgroundColor'];
                $timeLeftColor = $item['timeLeftColor'];
                $timeTakenColor = $item['timeTakenColor'];
                $secondsEt = $item['secondsEt'];
                $minutesAllowed = $item['minutesAllowed'];
                $synchWithServer = $item['synchWithServer'];
                $serverTimerId = $item['serverTimerId'];
                $ajaxUrlRoot = $item['ajaxUrlRoot'];
                $percentComplete = $item['percentComplete'];
                $timeup = $item['timeup'];

                if ($elementId != 'canTimerDisplay' && $elementId != 'divTimerDisplay') {//these are hardcoded on the page
                    if ($elementType == "CANVAS") {
                        echo "<canvas id='".$elementId."' width='100' height='75' class='canvastimer'></canvas>";
                    } else {
                        echo "<div id='".$elementId."' class='timer' style='border:1px solid black;width: 65px;height: 30px;color:".$textColor.";background-color:".$backgroundColor."'></div>";
                    }
                }
            }
        }
        ?>
    </section>
    <hr>
    <form id="mainForm" method="post">
        <input type="hidden" id="txtTimerState" name="txtTimerState"/>
        <input type="submit" value="Post the form >>"/>
    </form>
    <footer>
        <p>Posted by: Sean Kraft</p>
        <p><time datetime="2013-12-05"></time></p>
    </footer>

</article>

</body>
<script language="javascript">
    $( document ).ready(function() {
        //thanks to miniColors for the sweet color picker
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

            var allTimers = $('.timer, .canvastimer');
            var allTimerSerialized ="[";
            for (x=0; x<allTimers.length; x++) {
                currentTimer = $("#" + allTimers[x].id);
                allTimerSerialized+=currentTimer.timer("serialize");
                if (x +1 < allTimers.length) allTimerSerialized+= ",";//no trailing comma
                alert(currentTimer.timer("serialize"));
            }
            allTimerSerialized+= "]";
            $("#txtTimerState").val(allTimerSerialized);
        });

        //wire up the button that allows a user to create their own timer
        $("#cmdCreateTimer").click(function () {
            var json = $("#TimerDisplay3").timer('serialize');
            alert(json);

            //Create a new HTMLElement and append it to the timerSection
            var container = $("#timerSection"), newTimer;
            var timerCount = $('.timer, .canvastimer').length;
            timerCount++;
            var newTimerId = 'newTimer_' + timerCount;//create a unique ID

            if ($('#chkUseCanvas').prop('checked')) {
                newTimer = document.createElement("canvas")
                newTimer.id = newTimerId;
                newTimer.className = "canvastimer";
            } else {
                newTimer = $('<div/>', {
                    id: newTimerId,
                    class: 'timer',
                    style: 'color:'
                        + $('#txtTextColor').val()
                        + ';background-color:' + $('#txtBackgroundColor').val()
                });

            }

            var minutesAllowed = $('#txtMinutesAllowed').val();
            if ($.isNumeric(minutesAllowed)) {
                if (minutesAllowed.indexOf('.') == 0) {
                    minutesAllowed = "0" + minutesAllowed;//json for serialize requires leading zeros
                }
            } else {
                minutesAllowed = 1;
            }
            $('#txtMinutesAllowed').val(minutesAllowed);

            container.append(newTimer);//add the new timer to the proper section
            //not sure why but jQuery needs us to retrieve the new div from jQuery for it to work
            $("#" + newTimerId).timer({ added: function(e, ui){}
               ,minutesAllowed:minutesAllowed, synchWithServer:$('#chkSynchWithServer').prop('checked')
               ,backgroundColor: $('#txtBackgroundColor').val(), textColor: $('#txtTextColor').val()
               ,timeTakenColor: $('#txtTimeTakenColor').val(), timeLeftColor: $('#txtTimeLeftColor').val()
               ,timeup: function(e,ui){alert('timeup ' + newTimerId + ' serverTimerId:' + ui.serverTimerId);}});

        });

        <?php
        //Go through the posted timer states and set the timers back up again, look up top for the matching HTML
        if (isset($_POST["txtTimerState"])) {
            $timerState = $_POST["txtTimerState"];
            //echo $timerState;
            $j = json_decode($timerState, true);

            //each item is a timer waiting to be reborn
            foreach($j as $item) {
                $elementId = $item['elementId'];
                $textColor = $item['textColor'];
                $backgroundColor = $item['backgroundColor'];
                $timeLeftColor = $item['timeLeftColor'];
                $timeTakenColor = $item['timeTakenColor'];
                $secondsEt = $item['secondsEt'];
                $minutesAllowed = $item['minutesAllowed'];
                $synchWithServer = $item['synchWithServer'] != "" ? $item['synchWithServer'] : 'false';
                $serverTimerId = $item['serverTimerId'] !=null ? $item['serverTimerId'] : 'null';
                $ajaxUrlRoot = $item['ajaxUrlRoot'];
                $percentComplete = $item['percentComplete'];
                $timeup = $item['timeup'];
                if ($elementId != 'canTimerDisplay' && $elementId != 'divTimerDisplay') {//these are hardcoded on the page
                    //write out the jQuery code to initiate the timers
                    echo "$('#".$elementId."').timer({minutesAllowed:".$minutesAllowed.",secondsEt:".$secondsEt.",textColor:'".$textColor."',backgroundColor:'".$backgroundColor."',timeLeftColor:'".$timeLeftColor."',timeTakenColor:'".$timeTakenColor."',synchWithServer:".$synchWithServer.",serverTimerId:".$serverTimerId.",ajaxUrlRoot:'".$ajaxUrlRoot."',percentComplete:".$percentComplete."});\r\n";
                }


            }

        }
        ?>
    });

</script>
</html>