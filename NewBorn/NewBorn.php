<!DOCTYPE html>
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
      $NewBornCheckSQL = "SELECT * FROM Birth WHERE AnimalNumber='".$_REQUEST["animalnumber"]."'";
      $NewBornCheck = mysqli_query($DBConnection, $NewBornCheckSQL) ;
      if (mysqli_affected_rows($DBConnection) > 0)
      {
          $ResultJSON = $ResultJSON = '{"Result":"-1"}';
          echo "Error AnimalNumber aleady exists";
      }
      else
      {
          $InsertNewBornDetailsSQL = "Insert into Birth (AnimalNumber, DateOfBirth, NumberOfNewborns, NumberOfDeadNewborn) values ('" . $_REQUEST["animalnumber"] . "', '" . $GetDate . "', '" . $_REQUEST["numbeofnewborns"] . "','" . $_REQUEST["numbeofdeadnewborns"] . "')";
          $InsertNewBornDetails = mysqli_query($DBConnection, $InsertNewBornDetailsSQL);
          $ResultJSON = $ResultJSON = '{"AnimalNumber": ' . $_REQUEST["animalnumber"] . '  , "DateOfBirth" : ' . $GetDate . ' , "NumberOfNewborns" : '.$_REQUEST["numbeofnewborns"].', "NumberOfDeadNewborn" : '.$_REQUEST["numbeofdeadnewborns"].',"Result":"1"}';
          echo "Animal added";
      }
    }
    echo $ResultJSON;
     ?>
