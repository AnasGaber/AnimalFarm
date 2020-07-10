<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Add New Animal</title>
  </head>
  <body>
    <form action="AddNewAnimal.php" method="get">
      AnimalNumber:<br><input type="text" name="animalnumber">
      <p>
      LocalAnimalNumber:<br><input type="number" name="localanimalnumber">
      <p>
      Status:<br><input type="text" name="status">
      <p>
      Gender:<br><input type="text" name="gender">
      <p>
      Owner:<br><input type="text" name="owner">
      <p>
      <input type="submit">
    </form>
    <?php
      require_once('config.php');
      $GetDate=date('Y-m-d',time());
      $DBConnection = mysqli_connect($DBSERVER, $DBUSER, $DBPASSWORD, $DBNAME);
      mysqli_select_db($DBConnection, $DBNAME);
      mysqli_query($DBConnection, "SET NAMES utf8");
      $AnimalCheckSQL = "SELECT * FROM Animals WHERE AnimalNumber='".$_GET["animalnumber"]."'";
      $AnimalCheck = mysqli_query($DBConnection, $AnimalCheckSQL) ;
      if (mysqli_affected_rows($DBConnection) > 0)
      {
          echo "Error AnimalNumber aleady exists";
      }
      else
      {
          $InsertAnimalDetailsSQL = "Insert into Animals (AnimalNumber, LocalAnimalNumber, Status, StatusDate, Gender, Owner) values ('" . $_GET["animalnumber"] . "', '" . $_GET["localanimalnumber"] . "','" . $_GET["status"] . "', '" . $GetDate . "', '" . $_GET["gender"] . "','" . $_GET["owner"] . "')";
          $InsertAnimalDetails = mysqli_query($DBConnection, $InsertAnimalDetailsSQL);
          echo "Animal added";
      }
     ?>
  </body>
  </html>
