<?php
 require_once('config.php');
 $DBConnection = mysqli_connect($DBSERVER, $DBUSER, $DBPASSWORD, $DBNAME);
 if ($DBConnection->connect_error)
 {
   die('Connect Error:'.$DBConnection->connect_error);
   $ResultJSON = $ResultJSON = '{"Result":"-100"}';
 }
 else {
 mysqli_select_db($DBConnection, $DBNAME);
 mysqli_query($DBConnection, "SET NAMES utf8");
 $AnimalCheckSQL = "SELECT * FROM SellingLamb";
 $AnimalCheck = mysqli_query($DBConnection, $AnimalCheckSQL) ;
 $count="0";
      if (mysqli_affected_rows($DBConnection) > 0)
      {
          while ($row = mysqli_fetch_assoc($AnimalCheck))
          {
            $Result[$count] = '{"AnimalNumber" : "' . $row['AnimalNumber'] . '"  , "Date of sale" : "'.$row['DateOfSale'].'" , "Number of kilos" : "'.$row['Kilo'].'", "Price" : "'.$row['Price'].'", "Genus" : "'.$row['Genus'].'", "Buyer" : "'.$row['Buyer'].'"}';
            $count++;
          }
        }
      }
      $ResultJSON=json_encode($Result);
      print_r($ResultJSON);
      ?>
