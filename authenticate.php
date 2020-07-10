<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once('config.php');
$GetIP = getenv('HTTP_CLIENT_IP')?:
  getenv('HTTP_X_FORWARDED_FOR')?:
  getenv('HTTP_X_FORWARDED')?:
  getenv('HTTP_FORWARDED_FOR')?:
  getenv('HTTP_FORWARDED')?:
  getenv('REMOTE_ADDR');
$GetDate=date('Y-m-d',time());
$DBConnection = mysqli_connect($DBSERVER, $DBUSER, $DBPASSWORD, $DBNAME);
mysqli_select_db($DBConnection, $DBNAME);
mysqli_query($DBConnection, "SET NAMES utf8");

$AuthorityArray = array("Sistem Admin", "Rezervasyon", "Rapor");
$ResultJSON = $ResultJSON = '{"Operation" : "NoOP", "Result" : "-100" }';
switch ($_REQUEST["Operation"]) {
    case "Login":
        //Authority:
        // 0 : System Admin
        // 1 : Reservation
        // 2 : Report
        $ControlUserSQL = "SELECT * FROM Accounts WHERE Username='" . $_REQUEST["Username"] . "' and Password='" . $_REQUEST["Password"] . "'";
        $ControlUser = mysqli_query($DBConnection, $ControlUserSQL);

        if (mysqli_affected_rows($DBConnection) > 0) {
            $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $SessionToken = '';
            for ($i = 0; $i < 16; $i++) {
                $SessionToken = $SessionToken . $characters[rand(0, 60)];
            }

            $InsertSessionDetailsSQL = "Insert into Sessions (Username, SessionToken, IPAddress, SessionDate) values ('" . $_REQUEST["Username"] . "', '" . $SessionToken . "', '" . $GetIP . "', '" . $GetDate . "')";
            $InsertSessionDetails = mysqli_query($DBConnection, $InsertSessionDetailsSQL);

            if ($InsertSessionDetails) {
                $UserDetails = mysqli_fetch_array($ControlUser);
                $ResultJSON = '{"Operation" : "Login", "Result" : "1" , "SessionToken" : "' . $SessionToken . '" , "Name" : "' . $UserDetails["Name"] . '" , "Surname" : "' . $UserDetails["Surname"] . '"  , "ID" : "' . $UserDetails["ID"] . '"  }';
            } else {
                $ResultJSON = '{"Operation" : "Login", "Result" : "-1" }';
            }
        } else {
            $ResultJSON = '{"Operation" : "Login", "Result" : "-1" }';
        }
// Check result
        break;

    case "Logout":
        $CheckSessionDetailsSQL = "Select Count(*) as UserExists from Sessions where  Username='" . $_REQUEST["Username"] . "' and SessionToken='" . $_REQUEST["SessionToken"] . "' and IPAddress='" . $GetIP . "'";
        $CheckSessionDetails = mysqli_query($DBConnection, $CheckSessionDetailsSQL);
        $SessionDetails = mysqli_fetch_array($CheckSessionDetails);
        /*                             if($SessionDetails["UserExists"]>0)
          {
         */ $RemoveSessionDetailsSQL = "Delete from Sessions where SessionToken='" . $_REQUEST["SessionToken"] . "'";
        $RemoveSessionDetails = mysqli_query($DBConnection, $RemoveSessionDetailsSQL);
        $ResultJSON = '{"Operation" : "Logout", "Result" : "1" }';
        /*     					       }
          else
          {
          $ResultJSON = '{"Operation" : "Logout", "Result" : "-1" }';
          } */
// Check result


        break;

    case "ValidateSession":
        $CheckSessionDetailsSQL = "Select Count(*) as UserExists from Sessions where  Username='" . $_REQUEST["Username"] . "' and SessionToken='" . $_REQUEST["SessionToken"] . "' and IPAddress='" . $_REQUEST["IP"] . "'";
        $CheckSessionDetails = mysqli_query($DBConnection, $CheckSessionDetailsSQL);
        $SessionDetails = mysqli_fetch_array($CheckSessionDetails);

        if ($SessionDetails["UserExists"] > 0) {
            $GetUserAuthoritySQL = "Select * from Users where Username='" . $_REQUEST["Username"] . "'";
            $GetUserAuthority = mysqli_query($DBConnection, $GetUserAuthoritySQL);
            $UserAuthority = mysqli_fetch_array($GetUserAuthority);

            $GetPageSecurityLevelSQL = "Select Authority from PageAuthorities where PageID='" . $_REQUEST["PageID"] . "'";
            $GetPageSecurityLevel = mysqli_query($DBConnection, $GetPageSecurityLevelSQL);
            $PageSecurityLevel = mysqli_fetch_array($GetPageSecurityLevel);

            if ($PageSecurityLevel["Authority"] >= $UserAuthority["Authority"]) {
                $ResultJSON = '{"Operation" : "ValidateSession", "Result" : "1" }';
            } else {
                $ResultJSON = '{"Operation" : "ValidateSession", "Result" : "-1" }';
            }
        } else {
            $ResultJSON = '{"Operation" : "ValidateSession", "Result" : "-1" }';
        }
// Check result


        break;

    case "GetMenuDetails":
        $CheckSessionDetailsSQL = "Select Count(*) as UserExists from Sessions where  Username='" . $_REQUEST["Username"] . "' and SessionToken='" . $_REQUEST["SessionToken"] . "' and IPAddress='" . $_REQUEST["IP"] . "'";
        $CheckSessionDetails = mysqli_query($DBConnection, $CheckSessionDetailsSQL);
        $SessionDetails = mysqli_fetch_array($CheckSessionDetails);

        if ($SessionDetails["UserExists"] > 0) {

            $GetUserAuthoritySQL = "Select * from Users where Username='" . $_REQUEST["Username"] . "'";
            $GetUserAuthority = mysqli_query($DBConnection, $GetUserAuthoritySQL);
            $UserAuthority = mysqli_fetch_array($GetUserAuthority);

            $GetUserModuleListSQL = "Select * from UserAuthority where UserID=" . $UserAuthority["ID"];
            $GetUserModuleList = mysqli_query($DBConnection, $GetUserModuleListSQL);

            while ($CurrentModule = mysqli_fetch_array($GetUserModuleList)) {
                $UserRights[$CurrentModule["ModuleID"]] = $CurrentModule["Authority"];
            }

            $ResultJSON = '{"Operation" : "' . $_REQUEST["Operation"] . '", "Result" : "1" , "UserMenu" : [ ';

            $GetTopMenuItemsSQL = "Select * from MainMenu where Parent=0 Order By MenuOrder";
            $GetTopMenuItems = mysqli_query($DBConnection, $GetTopMenuItemsSQL);

            while ($CurrentItem = mysqli_fetch_array($GetTopMenuItems)) {
                if (($UserRights[$CurrentItem["ModuleID"]] != NULL) && ($CurrentItem["Authority"] >= $UserRights[$CurrentItem["ModuleID"]])) {
                    $ResultJSON = $ResultJSON . '{ "ID" : "' . $CurrentItem["ID"] . '" , "Descriptions" : "' . $CurrentItem["MenuDescription"] . '" , "FileName" : "' . $CurrentItem["FileName"] . '" , "Icon" : "' . $CurrentItem["Icon"] . '" , "SubMenuItems" : [ ';

                    $GetSubMenuItemsSQL = "Select * from MainMenu where Parent=" . $CurrentItem["ID"] . " Order By MenuOrder";
                    $GetSubMenuItems = mysqli_query($DBConnection, $GetSubMenuItemsSQL);

                    while ($CurrentSubItem = mysqli_fetch_array($GetSubMenuItems)) {
                        if (($UserRights[$CurrentSubItem["ModuleID"]] != NULL) && ($CurrentSubItem["Authority"] >= $UserRights[$CurrentSubItem["ModuleID"]])) {
                            $GetPageAccessSQL = "Select * from PageAuthorities where ModuleID=" . $CurrentSubItem["ModuleID"] . " and PageID='" . $CurrentSubItem["PageID"] . "'";
                            $GetPageAccess = mysqli_query($DBConnection, $GetPageAccessSQL);
                            $PageAccess = mysqli_fetch_array($GetPageAccess);

                            if ($PageAccess["Authority"] >= $UserRights[$CurrentSubItem["ModuleID"]]) {

                                $ResultJSON = $ResultJSON . '{ "ID" : "' . $CurrentSubItem["ID"] . '" , "Descriptions" : "' . $CurrentSubItem["MenuDescription"] . '" , "FileName" : "' . $CurrentSubItem["FileName"] . '" , "Icon" : "' . $CurrentSubItem["Icon"] . '" } ,';
                            }
                        }
                    }

                    $ResultJSON = rtrim($ResultJSON, ",") . ' ] } ,';
                }
            }
            $ResultJSON = rtrim($ResultJSON, ",") . ' ] }';
        } else {
            $ResultJSON = '{"Operation" : "' . $_REQUEST["Operation"] . '", "Result" : "-1" }';
        }
// Check result


        break;
}
mysqli_close($DBConnection);

echo $ResultJSON;
?>
