<?php
      require_once('config.php');
      $GetDate=date('Y-m-d',time());
      $DBConnection = mysqli_connect($DBSERVER, $DBUSER, $DBPASSWORD, $DBNAME);
      if ($DBConnection->connect_error)
      {
        die('Connect Error:'.$DBConnection->connect_error);
        $ResultJSON = $ResultJSON = '{"Result":"-100"}';
      }
      else {
      mysqli_select_db($DBConnection, $DBNAME);
      mysqli_query($DBConnection, "SET NAMES utf8");
      $SellingCheckSQL = "SELECT * FROM SellingLamb WHERE AnimalNumber='".$_REQUEST["animalnumber"]."'";
      $SellingCheck = mysqli_query($DBConnection, $SellingCheckSQL) ;
      if (mysqli_affected_rows($DBConnection) > 0)
      {
          $ResultJSON = $ResultJSON = '{"Result":"-1"}';
          echo "Error AnimalNumber aleady exists";
      }
      else
      {
          $InsertAnimalDetailsSQL = "Insert into SellingLamb (AnimalNumber, DateOfSale, Kilo, Price, Genus, Buyer) values ('" . $_REQUEST["animalnumber"] . "', '" . $GetDate . "','" . $_REQUEST["kilo"] . "', '" . $_REQUEST["price"] . "', '" . $_REQUEST["genus"] . "','" . $_REQUEST["buyer"] . "')";
          $InsertAnimalDetails = mysqli_query($DBConnection, $InsertAnimalDetailsSQL);
          echo "Animal added";
          $ResultJSON = $ResultJSON = '{"AnimalNumber": ' . $_REQUEST["animalnumber"] . '  , "DateOfSale" : ' . $GetDate . ' , "Kilo" : '.$_REQUEST["kilo"].', "Price" : '.$_REQUEST["Price"].',"genus" : '.$_REQUEST["genus"].',"buyer" : '.$_REQUEST["buyer"].',"Result":"1"}';
      }
    }
    echo $ResultJSON;
     ?>
