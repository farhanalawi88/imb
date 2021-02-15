<?php
session_start();
include_once "config/inc.connection.php";
include_once "config/inc.library.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
// GLOBAL CONFIGURATION
$settSql    = "SELECT * FROM sys_setting";
$settQry    = $koneksidb->prepare($settSql);
$settQry->execute();
$settRow    = $settQry->fetch(PDO::FETCH_ASSOC);

if($settRow['sys_setting_logo'] =="") {
    $dataImage   = "no_image.png";
}
else {
    $dataImage   = $settRow['sys_setting_logo'];
}

$dataMeta   = $settRow['sys_setting_nama'].' - '.$settRow['sys_setting_meta']
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $dataMeta ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.png">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>

    </head>

    <body>

        <!-- Begin page -->
        <div class="accountbg" style="background: url('assets/images/bg-2.jpg');"></div>

        <div class="wrapper-page account-page-full">

            <div class="card">
                <div class="card-block">

                    <div class="account-box">

                        <div class="card-box p-5">
                            <h2 class="text-uppercase text-center pb-4">
                                <span class="text-info">
                                    <span><img src="images/<?php echo $dataImage ?>" alt="" height="40"> <?php echo $settRow['sys_setting_nama'] ?></span>
                                </span>
                            </h2>

                            <form class="" action="masuk.php" method="post">
                                <?php
                                  if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                                    echo '<div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        <i class="icon-close"></i>&nbsp;'.$_SESSION['pesan'].'</div>';
                                    }
                                      $_SESSION['pesan'] = '';
                                              
                                            
                                ?>
                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="emailaddress">Username</label>
                                        <input class="form-control" type="text" required="" placeholder="Enter your Username" name="username">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <label for="password">Password</label>
                                        <input class="form-control"  name="password" type="password" required="" id="password" placeholder="Enter your password">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">

                                        <div class="checkbox checkbox-custom">
                                            <input id="remember" type="checkbox" checked="">
                                            <label for="remember">
                                                Remember me
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Sign In</button>
                                    </div>
                                </div>

                            </form>

                           
                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright"><?php echo $settRow['sys_setting_footer'] ?></p>
            </div>

        </div>


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
