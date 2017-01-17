<?php
session_start();
include("config.inc.php")
 ?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket(s) auswählen</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }
    </style>
    <!--<link href="css/bootstrap-theme.min.css" rel="stylesheet">-->

  </head>



  <body style="margin: 5px;">
      <div class="page-header" style="text-align: center;">
          <h1>Ticket(s) auswählen</h1>
      </div>
      <div class="alert alert-info" role="alert"><b>HINWEIS:</b> Bitte wähle unten die Zeiten aus, für die du Tickets reservieren möchtest und klicke dann auf "WEITER"</div>

      <form action="checkevent.php" method="post">
      <?php
        function checkit ($id,$timestart,$timeend,$hinweistext){
            $yes=0;
            if(!empty($_SESSION["booked".$id])){
                if($_SESSION["booked".$id]==1){
                    $yes=1;
                }
            }
            if($yes){
                echo '<li class="list-group-item list-group-item-success">'.$timestart.' - '.$timeend.' Uhr ';
                echo '<span class="glyphicon glyphicon-arrow-right"></span>&nbsp <b>Frei</B> <span class="glyphicon glyphicon-arrow-right"></span> ';
                echo '&nbsp<span id="selectinfo'.$id.'"><h1 class="label label-lg label-success"><span class="glyphicon glyphicon-ok"></span> Ausgewählt</h1> <span class="glyphicon glyphicon-arrow-right"></span>&nbsp</span>';
                echo '<button id="select'.$id.'" type="button" class="btn btn-danger" name="'.$id.'" onclick="toggle(\''.$id.'\')">';
                echo '<span class="glyphicon glyphicon-minus-sign"></span> Auswahl aufheben</button>';
                echo '<input type="hidden" name="'.$id.'" id="input'.$id.'" value="1"></input>';
                echo '&nbsp <b>WICHTIG:</b> '.$hinweistext;
                echo '</li>';
            }else{
                echo '<li class="list-group-item list-group-item-success">'.$timestart.' - '.$timeend.' Uhr ';
                echo '<span class="glyphicon glyphicon-arrow-right"></span>&nbsp <b>Frei</B> <span class="glyphicon glyphicon-arrow-right"></span> ';
                echo '&nbsp<span id="selectinfo'.$id.'"></span>';
                echo '<button id="select'.$id.'" type="button" class="btn btn-success" name="'.$id.'" onclick="toggle(\''.$id.'\')">';
                echo '<span class="glyphicon glyphicon-plus-sign"></span> Auswählen </button>';
                echo '<input type="hidden" name="'.$id.'" id="input'.$id.'" value="0"></input>';
                echo '&nbsp <b>WICHTIG:</b> '.$hinweistext;
                echo '</li>';
            }
        }
        include("zugriff.inc.php");
        $sqltogetdates="SELECT * FROM `dates`";
        $resultdates=mysqli_query($db,$sqltogetdates);
        while($row=mysqli_fetch_assoc($resultdates)){
            echo '<div class="panel panel-default"><div class="panel-heading"><h2 class="panel-title">';
            $datum=$row['datum'];
            $wochentag=$row['wochentag'];
            echo $wochentag.', den '.$datum;
            echo '</h2></div><div class="panel-body">';


            $sqltemp="SELECT * FROM `times` WHERE `date`=".$row["id"];
            $resulttemp=mysqli_query($db,$sqltemp);
            echo '<ul class="list-group">';


            while($row=mysqli_fetch_assoc($resulttemp)){

                $timestart=$row['timestart'];
                $timeend=$row['timeend'];
                $booked=intval($row['booked']);
                $id=$row['id'];

                if($booked==1){
                    echo '<li class="list-group-item list-group-item-danger">'.$timestart.' - '.$timeend.' Uhr ';
                    echo '<span class="glyphicon glyphicon-arrow-right"></span>&nbsp <b>Belegt</b></li>';
                }else{
                    checkit($id,$timestart,$timeend,$hinweistext);
                    // echo '<li class="list-group-item list-group-item-success">'.$timestart.' - '.$timeend.' Uhr ';
                    // echo '<span class="glyphicon glyphicon-arrow-right"></span>&nbsp <b>Frei</B> <span class="glyphicon glyphicon-arrow-right"></span> ';
                    // echo '&nbsp<span id="selectinfo'.$id.'"></span>';
                    // echo '<button id="select'.$id.'" type="button" class="btn btn-success" name="'.$id.'" onclick="toggle(\''.$id.'\')">';
                    // echo '<span class="glyphicon glyphicon-plus-sign"></span> Auswählen </button>';
                    // echo '<input type="hidden" name="'.$id.'" id="input'.$id.'" value="0"></input>';
                    // echo '&nbsp <b>WICHTIG:</b> '.$hinweistext;
                    // echo '</li>';
                }

            }


            echo '</ul>';
            echo '</div></div>';
        }
       ?>
       <button type="submit" name="ticketsselected" style="float: right;" class="btn btn-lg btn-success">WEITER <span class="glyphicon glyphicon-chevron-right"></span></button>
   </form>
    <script src="javascript.js"></script>
    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
