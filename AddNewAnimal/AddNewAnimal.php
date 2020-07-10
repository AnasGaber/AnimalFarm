<?php
      require_once('config.php');
      $GetDate=date('Y-m-d',time());
      $DBConnection = mysqli_connect($DBSERVER, $DBUSER, $DBPASSWORD, $DBNAME);
      mysqli_select_db($DBConnection, $DBNAME);
      mysqli_query($DBConnection, "SET NAMES utf8");
      $AnimalCheckSQL = "SELECT * FROM Animals WHERE AnimalNumber='".$_POST["animalnumber"]."'";
      $AnimalCheck = mysqli_query($DBConnection, $AnimalCheckSQL) ;
      if ($DBConnection->connect_error)
      {
        die('Connect Error:'.$DBConnection->connect_error);
        $ResultJSON = $ResultJSON = '{"Result":"-100"}';
      }
      else {
      if ($row=mysqli_affected_rows($DBConnection) > 0)
      {
          echo "Error AnimalNumber aleady exists";
          echo "<br>";
          $ResultJSON = $ResultJSON = '{"AnimalNumber": ' . $_REQUEST["animalnumber"] . '  ,"Result":"-1"}';
      }
      else
      {
          $InsertAnimalDetailsSQL = "Insert into Animals (AnimalNumber, LocalAnimalNumber, Status, StatusDate, Gender, Owner) values ('" . $_REQUEST["animalnumber"] . "', '" . $_REQUEST["localanimalnumber"] . "','" . $_REQUEST["status"] . "', '" . $GetDate . "', '" . $_REQUEST["gender"] . "','" . $_REQUEST["owner"] . "')";
          $InsertAnimalDetails = mysqli_query($DBConnection, $InsertAnimalDetailsSQL);
          echo "Animal added";
          echo "<br>";
          $ResultJSON = $ResultJSON = '{"AnimalNumber": ' . $_REQUEST["animalnumber"] . '  , "LocalAnimalNumber" : '.$_REQUEST["localanimalnumber"].' , "Owner" : '.$_REQUEST["owner"].', "Gender" : '.$_REQUEST["gender"].', "StatusDate" : ' . $GetDate . ', "Status" : '.$_REQUEST["status"].',"Result":"1"}';
      }
      }
      echo $ResultJSON;

     ?>
