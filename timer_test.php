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
<link type="text/css" rel="stylesheet" href="css/basic-minimal.css">
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
    <p>Behold the jQuery Timer plugin. Turns an HTML canvas into a handsome countdown clock!</p>
    <section id="timerCreateSection">
        <fieldset>
            <legend>Create Your Own Timer</legend>
            <p>Minutes Allowed: <input type="text" id="txtMinutesAllowed"/> | Use HTML5 Canvas: <input type="checkbox" id="chkUseCanvas"/> | Synch with Server: <input type="checkbox" id="chkSynchWithServer"/></p>
            <p>Text Color: <input type="text" id="txtTextColor" value="black"/> | Background Color: <input type="text" id="txtBackgroundColor" value="red"/></p>

            <input type="button" id="cmdCreateTimer" value="Create Timer"/>
        </fieldset>

    </section>
    <section id="timerSection">

        <canvas id="TimerDisplay2" width="100" height="300"></canvas>
        <canvas id="TimerDisplay3" width="150" height="100"></canvas>
        <div id="TimerDisplay4" style="width:150px;height:200px;background-color:red;color: black;font-family: Arial;font-size: 20px;"/>

    </section>

    <hr>
    <form id="mainForm">
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

        $("#TimerDisplay2").timer({ added: function(e, ui){}
            , minutesAllowed:1.2
            , timeTakenColor: 'yellow', serverTimerId: 2
            ,timeup: function(e,ui){alert('timeup - serverTimerId:' + ui.serverTimerId);}
            ,initServerTimer: function(e,ui){alert('initServerTimer serverTimerId: ' + ui.serverTimerId);}
        });

        $("#TimerDisplay3").timer({ added: function(e, ui){}
            , minutesAllowed:1, synchWithServer:false
            ,timeup: function(e,ui){alert('timeup 3 serverTimerId:' + ui.serverTimerId);}});

        $("#TimerDisplay4").timer({ added: function(e, ui){}
            , minutesAllowed:.2, serverTimerId:3
            ,timeup: function(e,ui){alert('timeup 4 serverTimerId: ' + ui.serverTimerId);}
            ,initServerTimer: function(e,ui){alert('initServerTimer 4 serverTimerId: ' + ui.serverTimerId);}
        });

        $( "form" ).submit(function( event ) {
            var json = $("#TimerDisplay3").timer('serialize');
            window.nativeAlert(json);
            event.preventDefault();
        });

        $("#cmdCreateTimer").click(function () {
            var json = $("#TimerDisplay3").timer('serialize');
            alert(json);

            var container = $("#timerSection");

            var newTimer
            if ($('#chkUseCanvas').prop('checked')) {
                newTimer = document.createElement("canvas")
                newTimer.id = "newTimer";
            } else {
                var newTimer = $('<div/>', {
                    id: 'newTimer',
                    className: 'timer',
                    style: 'border:1px solid black;width: 65px;height: 30px;color:'
                        + $('#txtTextColor').val()
                        + ';background-color:' + $('#txtBackgroundColor').val()
                });

            }

            $("#timerSection").append(newTimer);
            newTimer = $("#newTimer");//not sure why but jQuery needs us to retrieve the new div from jQuery for it to work
            newTimer.timer({ added: function(e, ui){}
               , minutesAllowed:$('#txtMinutesAllowed').val(), synchWithServer:$('#chkSynchWithServer').prop('checked')
               ,backgroundColor: $('#txtBackgroundColor').val(), textColor: $('#txtTextColor').val()
               ,timeup: function(e,ui){alert('timeup 5 serverTimerId:' + ui.serverTimerId);}});

            //var y = $("").length();
        });
    });

</script>
</html>