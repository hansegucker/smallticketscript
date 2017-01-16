<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Die 3 Meta-Tags oben *müssen* zuerst im head stehen; jeglicher sonstiger head-Inhalt muss *nach* diesen Tags kommen -->
    <title>Ticket(s) auswählen</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="css/bootstrap-theme.min.css" rel="stylesheet">-->


    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="margin: 5px;">
      <div class="page-header" style="text-align: center;">
          <h1>Ticket(s) auswählen</h1>
      </div>
      <div class="alert alert-info" role="alert"><b>HINWEIS:</b> Bitte wähle unten die Zeiten aus, für die du Tickets kaufen möchtest!</div>


      <?php
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
                    echo '<li class="list-group-item list-group-item-danger">'.$timestart.' - '.$timeend.' Uhr <span class="glyphicon glyphicon-arrow-right"></span>&nbsp <b>Belegt</b></li>';
                }else{
                    echo '<li class="list-group-item list-group-item-success">'.$timestart.' - '.$timeend.' Uhr <span class="glyphicon glyphicon-arrow-right"></span>&nbsp <b>Frei</B> <span class="glyphicon glyphicon-arrow-right"></span> ';
                    echo '&nbsp<div id="selectinfo"></div><button id="select" type="button" class="btn btn-success" name="'.$id.'"><span class="glyphicon glyphicon-plus-sign"></span> Auswählen</button>';
                    echo '</li>';
                }

            }
            echo '</ul>';

            echo '</div></div>';
        }
       ?>

    <script src="javascript.js"></script>
    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
