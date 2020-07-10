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
   $AnimalCheckSQL = "SELECT * FROM Animals WHERE AnimalNumber='". $_POST["animalnumber"] ."'";
   $AnimalCheck = mysqli_query($DBConnection, $AnimalCheckSQL) ;

        if (mysqli_affected_rows($DBConnection) > 0)
        {
            while ($row = mysqli_fetch_assoc($AnimalCheck))
              {
                $ResultJSON = $ResultJSON = '{"AnimalNumber": "' . $row['AnimalNumber'] . '"  , "LocalAnimalNumber" : "'.$row['LocalAnimalNumber'].'" , "Owner" : "'.$row['Owner'].'", "Gender" : "'.$row['Gender'].'", "StatusDate" : "'.$row['StatusDate'].'", "Status" : "'.$row['Status'].'","Result":"1"}';

              }
            }
        else {
          $ResultJSON = $ResultJSON = '{"AnimalNumber": "AnimalNumber not found","Result":"-1"}';
        }
      }
                        echo $ResultJSON;
      mysqli_close($DBConnection);
?>
