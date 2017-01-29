<?php
session_start();
include("config.inc.php");
include("zugriff.inc.php");
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
        .input-group{
            padding: 5px;
        }
    </style>
    <!--<link href="css/bootstrap-theme.min.css" rel="stylesheet">-->

  </head>



  <body style="margin: 5px;">
      <div class="page-header" style="text-align: center;">
          <h1>Daten eingeben</h1>
      </div>

      <form action="datainput.php" method="post">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">E-Mail</h3>
  </div>
  <div class="panel-body">
      <div class="alert alert-info" role="alert">An diese E-Mail-Adresse wird ihre Reservierungsbestätigung geschickt, die sie am Einlass benötigen!</div>
      <div class="input-group">
        <span class="input-group-addon" id="einfaches-addon1"><span class="glyphicon glyphicon-envelope"></span></span>
        <input type="text" class="form-control" placeholder="E-Mail*" aria-describedby="einfaches-addon1" name="email">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="einfaches-addon1"><span class="glyphicon glyphicon-envelope"></span></span>
        <input type="text" class="form-control" placeholder="E-Mail wiederholen*" aria-describedby="einfaches-addon1" name="emailagain">
      </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Kontaktdaten</h3>
  </div>
  <div class="panel-body">
      <div class="alert alert-info" role="alert">Bitte bringen sie zu ihrem Besuch einen gültigen Personalausweis mit, um ihre in der Buchung angegebene Indentität zu verifizieren.</div>
      <div class="input-group">
        <span class="input-group-addon" id="einfaches-addon1"><span class="glyphicon glyphicon-user"></span></span>
        <input type="text" class="form-control" placeholder="Vor- und Nachname*" aria-describedby="einfaches-addon1" name="name">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="einfaches-addon1"><span class="glyphicon glyphicon-home"></span></span>
        <input type="text" class="form-control" placeholder="Straße und Nr.*" aria-describedby="einfaches-addon1" name="street">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="einfaches-addon1">PLZ</span>
        <input type="text" class="form-control" placeholder="PLZ*" aria-describedby="einfaches-addon1" name="plz">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="einfaches-addon1">Ort</span>
        <input type="text" class="form-control" placeholder="Ort*" aria-describedby="einfaches-addon1" name="place">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="einfaches-addon1"><span class="glyphicon glyphicon-earphone"></span></span>
        <input type="text" class="form-control" placeholder="Telefon*" aria-describedby="einfaches-addon1" name="phone">
      </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Überprüfung der Reservierung</h3>
  </div>
  <div class="panel-body">
      Sie wollen für folgende Zeiten reservieren:<br><br>
      <?php
      $sqltemp="SELECT * FROM `times`";
      $resulttemp=mysqli_query($db,$sqltemp);

      while($row=mysqli_fetch_assoc($resulttemp)){
          $id=$row['id'];
          if(!empty($_SESSION["booked".$id])){
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
          }
      }
      ?>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Abschluss</h3>
  </div>
  <div class="panel-body">

          <?php
            //Datacheck
                function check_email($email){
                     if(preg_match('/^[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+$/i', $email)) {
                        return true;
                     }
                     return false;
                 }
        $status="";
        if(!empty($_POST['email'])){
            if(!check_email($_POST['email'])){
                $status=$status."Bitte geben sie eine <b>gültige</b> E-Mail-Adresse ein!<br>";
            }
            if(empty($_POST['emailagain'])){
                $status=$status."Bitte wiederholen sie die E-Mail-Adresse!<br>";
            }else{
                if($_POST["email"]!=$_POST["emailagain"]){
                    $status=$status."Die E-Mail-Adressen stimmen nicht überein!<br>";
                }else{
                    $_SESSION["email"]=$_POST["email"];
                }
            }
        }else{
            $status=$status."Bitte geben sie eine E-Mail-Adresse ein!<br>";
        }



        if(!empty($_POST["name"])){
            if(str_word_count($_POST["name"])<2){
                $status=$status."Haben sie vielleicht den Vor- oder den Nachnamen vergessen?";
            }else{
                $_SESSION['name']=$_POST['name'];
            }
        }else{
            $status=$status."Bitte geben sie einen Vor- und einen Nachnamen ein!";
        }

        if($status==""){
            echo '<div class="alert alert-success" role="alert">Super! Alle Eingaben sind vorhanden und korrekt!</div>';
        }else{
            echo '<div class="alert alert-danger" role="alert">'.$status.'</div>';
        }



           ?>
           <label>
      <input type="checkbox" name="agb" value="yes">
      Hiermit erkläre ich mich mit den Datenschutzbedingungen einverstanden!
  </label><br>
      <button type="submit" class="btn btn-lg btn-success">Jetzt verbindlich reservieren</button>
  </div>
</div>


   </form>
    <script src="javascript.js"></script>
    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
