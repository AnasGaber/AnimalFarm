<?php
error_reporting(-1);
ini_set('display_errors', 'On');
session_start();

if (isset($_REQUEST["Lang"])) {
    if ($_REQUEST["Lang"] == 'TR') {
        $LangID = 1;
    } else if (($_REQUEST["Lang"] == 'GR') || ($_REQUEST["Lang"] == 'EL')) {
        $LangID = 3;
    } else {
        $LangID = 2;
    }
} else if (isset($_SESSION["Language"])) {
    $LangID = $_SESSION["Language"];
} else {
    $LangID = 2;
}

$post = curl_init();
// $fields = "Operation=GetAdminTranslations&LangID=" . $LangID;
curl_setopt($post, CURLOPT_URL, $url);
curl_setopt($post, CURLOPT_POST, "2");
curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($post);
curl_close($post);
$PageTranslations = json_decode($result, true);
?>

<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #5 for basic bootstrap tables with various options and styles" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN LAYOUT FIRST STYLES -->
        <link href="//fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css" />
        <!-- END LAYOUT FIRST STYLES -->
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../assets/layouts/layout5/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout5/css/custom.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/custom/css/style.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->
    <?php
    if (1) {
        ?>
        <body class="page-header-fixed page-sidebar-closed-hide-logo">
            <!-- BEGIN CONTAINER -->
            <div class="wrapper">
                <!-- BEGIN HEADER -->
                <header class="page-header">
                    <nav class="navbar mega-menu" role="navigation">
                        <div class="container-fluid">
                            <?php
                            require_once 'pagetop.php';
                            ?>

                            <?php
                            require_once 'mainmenu.php';
                            ?>
                        </div>
                        <!--/container-->
                    </nav>
                </header>
                <!-- END HEADER -->
                <div class="container-fluid">
                    <div class="page-content">
                        <!-- BEGIN BREADCRUMBS -->
                         <!--
                        <div class="breadcrumbs">
                            <h1>Basic Bootstrap Tables</h1>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li class="active">Tables</li>
                            </ol>
                        </div>
                          BEGIN BREADCRUMBS -->
                        <!-- END BREADCRUMBS -->
                        <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
                        <div class="page-content-container">
                            <div class="page-content-row">
                                <!-- BEGIN PAGE SIDEBAR -->
                                <?php
                                //require_once 'sidebar.php';
                                ?>
                                <!-- END PAGE SIDEBAR -->
                                <div class="page-content-col">
                                    <!-- BEGIN PAGE BASE CONTENT -->
                                    <div class="page-content-inner">
                                        <div class="row widget-row">
                                            <div class="col-md-3">
                                                <!-- BEGIN WIDGET THUMB -->
                                                <a href="http://farmapp.ar-ni.com/webServers/DisplayAnimalI.php" class="btn btn-lg blue">
                                                <i class="fa fa-list"></i> Animals List  </a>
                                                <!-- END WIDGET THUMB -->
                                            </div>
                                            <div class="col-md-3">
                                                <!-- BEGIN WIDGET THUMB -->
                                                <button type="button" class="btn default btn-lg">Large button</button>

                                                <!-- END WIDGET THUMB -->
                                            </div>
                                            <div class="col-md-3">
                                                <!-- BEGIN WIDGET THUMB -->
                                                <button type="button" class="btn default btn-lg">Large button</button>

                                                <!-- END WIDGET THUMB -->
                                            </div>
                                            <div class="col-md-3">
                                                <!-- BEGIN WIDGET THUMB -->
                                                <button type="button" class="btn default btn-lg">Large button</button>

                                    <!-- END PAGE BASE CONTENT -->
                                </div>
                            </div>
                        </div>
                        <!-- END SIDEBAR CONTENT LAYOUT -->
                    </div>
                    <!-- BEGIN FOOTER -->
                    <p class="copyright"><?php echo $PageTranslations["General"]["Copyright"]; ?></p>
                    <a href="#index" class="go2top">
                        <i class="icon-arrow-up"></i>
                    </a>
                    <!-- END FOOTER -->
                </div>
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN QUICK SIDEBAR -->
            <?php
            require_once 'quicksidebar.php';
            ?>
            <!-- END QUICK SIDEBAR -->
            <!-- BEGIN QUICK NAV -->
            <?php
            //require_once 'quicknav.php';
            ?>
            <!-- END QUICK NAV -->
            <!--[if lt IE 9]>
    <script src="../assets/global/plugins/respond.min.js"></script>
    <script src="../assets/global/plugins/excanvas.min.js"></script>
    <script src="../assets/global/plugins/ie8.fix.min.js"></script>
    <![endif]-->
            <!-- BEGIN CORE PLUGINS -->
            <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="../assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="../assets/pages/scripts/ui-bootbox.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="../assets/layouts/layout5/scripts/layout.min.js" type="text/javascript"></script>
            <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
            <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
            <!-- END THEME LAYOUT SCRIPTS -->
            <?php
        } else {
            ?>
            <!-- BEGIN CORE PLUGINS -->
            <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="../assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="../assets/pages/scripts/ui-bootbox.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="../assets/layouts/layout5/scripts/layout.min.js" type="text/javascript"></script>
            <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
            <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
            <!-- END THEME LAYOUT SCRIPTS -->
            <script type="text/javascript">
                bootbox.alert("<?php echo $PageTranslations["General"]["SessionProblem"]; ?>", function () {
                    window.location.assign('index.php');
                });
            </script>
            <?php
        }
        ?>
    </body>

</html>
