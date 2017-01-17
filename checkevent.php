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
          <h1>Ticket(s) überprüfen</h1>
      </div>
      <div class="alert alert-info" role="alert"><b>HINWEIS:</b> Bitte überprüfen sie ihre Reservierung, falls sie Fehler entdecken sollten, drücken sie bitte auf "ZURÜCK", sonst auf "WEITER"</div>

      <form action="datainput.php" method="post">
      <?php
        include("zugriff.inc.php");
        if(isset($_POST['ticketsselected'])){
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Ausgewählte Tickets:</h3>
  </div>
  <div class="panel-body">
      <ul class="list-group">

    <?php
    $sqltemp="SELECT * FROM `times`";
    $resulttemp=mysqli_query($db,$sqltemp);
    $aticket=0;

    while($row=mysqli_fetch_assoc($resulttemp)){
        $id=$row['id'];
        if(!empty($_POST[$id])){
            $_SESSION["booked".$id]=1;
            $aticket=1;
            $timestart=$row['timestart'];
            $timeend=$row['timeend'];
            $booked=intval($row['booked']);
            $sqltemp2="SELECT * FROM `dates` WHERE `id`=".$row["date"];
            $resulttemp2=mysqli_query($db,$sqltemp2);
            while($row=mysqli_fetch_assoc($resulttemp2)){
                $datum=$row['datum'];
                $wochentag=$row['wochentag'];
            }
            echo "<li class='list-group-item'>".$wochentag.", den ".$datum." von ".$timestart." bis ".$timeend." Uhr</li>";
        }else{
            if(isset($_SESSION["booked".$id])){
                $_SESSION["booked".$id]=0;
            }
        }
    }

    if(!$aticket){
        echo '<div class="alert alert-danger" role="alert"><b>Sie haben leider kein Ticket ausgewählt! Drücken sie auf "ZURÜCK"!</div>';
    }
    ?>
    </ul>
  </div>
</div>
<button type="button" onclick="location.href='selectevent.php'" style="float: left;" class="btn btn-lg btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> ZURÜCK</button>
<?php
    if($aticket){ ?>
<button type="submit" name="ticketsselected" style="float: right;" class="btn btn-lg btn-success">WEITER <span class="glyphicon glyphicon-chevron-right"></span></button>
<?php
    }
        }else{
            echo '<div class="alert alert-danger" role="alert"><b>Sie haben leider kein Ticket ausgewählt! Drücken sie auf "ZURÜCK"!</div>';
            echo '<button type="button" onclick="location.href=\'selectevent.php\'" style="float: left;" class="btn btn-lg btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> ZURÜCK</button>';
        }
       ?>

   </form>
    <script src="javascript.js"></script>
    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
