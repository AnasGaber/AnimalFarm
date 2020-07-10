
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
      $AnimalNoteCheckSQL = "SELECT * FROM Notes WHERE AnimalNumber='".$_REQUEST["animalnumber"]."'";
      $AnimalNoteCheck = mysqli_query($DBConnection, $AnimalNoteCheckSQL) ;
      if (mysqli_num_rows($AnimalNoteCheck) > 0)
      {
        switch ($_REQUEST["Operation"]) {
          case "Update":
            $UpdateNoteSQL="UPDATE Notes WHERE AnimalNumber=".$_REQUEST["animalnumber"]."'(Date, Notes) values( '" . $GetDate . "', '" . $_REQUEST["animalnote"] . "')";
            $ResultJSON = '{"AnimalNumber": ' . $_REQUEST["animalnumber"] . '  , "Date" : ' . $GetDate . ', "Notes" : '.$_REQUEST["animalnote"].',"Result":"1"}';
            break;
          case "New":
          $InsertNewNotesSQL = "Insert into Notes (AnimalNumber, Date, Notes) values ('" . $_REQUEST["animalnumber"] . "', '" . $GetDate . "', '" . $_REQUEST["animalnote"] . "')";
          $InsertNewNote = mysqli_query($DBConnection, $InsertNewNotesSQL);
          $ResultJSON = '{"AnimalNumber": ' . $_REQUEST["animalnumber"] . '  , "Date" : ' . $GetDate . ', "Notes" : '.$_REQUEST["animalnote"].',"Result":"1"}';
          echo "Animal note added";
            break;
          default:
              echo "Wrong operation";
              $ResultJSON = $ResultJSON = '{"Result":"-50"}';
            break;
        }
      }
      else {
        $InsertNewNotesSQL = "INSERT INTO Notes (AnimalNumber, Date, Notes) values ('" . $_REQUEST["animalnumber"] . "', '" . $GetDate . "', '" . $_REQUEST["animalnote"] . "')";
        $InsertNewNote = mysqli_query($DBConnection, $InsertNewNotesSQL);
        $ResultJSON = '{"AnimalNumber": ' . $_REQUEST["animalnumber"] . '  , "Date" : ' . $GetDate . ', "Notes" : '.$_REQUEST["animalnote"].',"Result":"1"}';
        echo "Animal note added";
        }
        echo "<br>";
        echo $ResultJSON;
      }
     ?>
