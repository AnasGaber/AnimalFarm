<?php
 require_once('config.php');
 $DBConnection = mysqli_connect($DBSERVER, $DBUSER, $DBPASSWORD, $DBNAME);
 mysqli_select_db($DBConnection, $DBNAME);
 mysqli_query($DBConnection, "SET NAMES utf8");
 $AnimalCheckSQL = "SELECT * FROM Birth";
 $AnimalCheck = mysqli_query($DBConnection, $AnimalCheckSQL) ;
 ?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Display Birth Table</title>
  </head>
  <body>

      <table align="center" border="1px">
        <tr>
          <th colspan="4"><h2>Birth Table</h2></th>
        </tr>
        <tr>
          <th>Animal Number </th>
          <th>Date Of Birth</th>
          <th>Number of Newborns </th>
          <th>Number of Dead Newborns </th>
        </tr>
     <?php
      if (mysqli_affected_rows($DBConnection) > 0)
      {
          while ($row = mysqli_fetch_assoc($AnimalCheck))
          {
      ?>
              <tr>
              <td><?php echo $row['AnimalNumber'];?></td>
              <td><?php echo $row['DateOfBirth'];?></td>
              <td><?php echo $row['NumberOfNewborns'];?></td>
              <td><?php echo $row['NumberOfDeadNewborn'];?></td>
            </tr>
            <?php
            }
      }
      ?>
    </table>
  </body>
  </html>
