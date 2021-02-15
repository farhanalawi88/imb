<?php
session_start();
include_once "config/inc.connection.php";
date_default_timezone_set('Asia/Jakarta');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING |E_DEPRECATED));

if(!isset($_SESSION['kode_user'])){
    $_SESSION['pesan'] = 'Session anda terhapus, silahkan login kembali';
    header("Location:index.php"); 
}

// USER CONFIGURATION
$userSql    = "SELECT * FROM ms_user a
                LEFT JOIN sys_group b ON a.user_group=b.group_id
                WHERE a.kode_user='".$_SESSION['kode_user']."'";
$userQry    = $koneksidb->prepare($userSql);
$userQry->execute();
$userRow    = $userQry->fetch(PDO::FETCH_ASSOC);

if($userRow['fotoUser'] =="") {
    $dataFoto   = "no_image.png";
}
else {
    $dataFoto   = $userRow['fotoUser'];
}

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

$dataMeta   = $settRow['sys_setting_nama'].' - '.$settRow['sys_setting_meta'];
    
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
        <link rel="shortcut icon" href="images/<?php echo $dataImage ?>">

        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
        <!-- Responsive datatable examples -->
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="plugins/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="plugins/switchery/switchery.min.css"/>

        <!-- Multi Item Selection examples -->
        <link href="plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <div class="slimscroll-menu" id="remove-scroll">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="?page=<?php echo base64_encode('home')?>" class="logo">
                            <span><img src="images/<?php echo $dataImage ?>" alt="" height="30"> <span><?php echo $settRow['sys_setting_nama'] ?></span></span>
                            <i>
                                <img src="images/<?php echo $dataImage ?>" alt="" height="38">
                            </i>
                        </a>
                    </div>

                    <!-- User box -->

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">
                            <div style="margin-top: 70px; border-bottom: 1px solid #eee; "></div>

                            <!--<li class="menu-title">Navigation</li>-->

                            <li>
                                <a href="?page=<?php echo base64_encode('home')?>">
                                    <i class="fi-air-play"></i><span> Dashboard </span>
                                </a>
                            </li>
                            <?php
                                $menuSql    = "SELECT * FROM sys_menu WHERE menu_id IN (SELECT c.menu_id FROM sys_akses a 
                                                                                        INNER JOIN sys_submenu b ON a.akses_submenu=b.submenu_id
                                                                                        INNER JOIN sys_menu c ON b.submenu_menu=c.menu_id
                                                                                        WHERE a.akses_group='".$userRow['user_group']."')
                                                ORDER BY menu_urutan ASC";
                                $menuQry    = $koneksidb->prepare($menuSql);
                                $menuQry->execute();
                                while ($menuShow    = $menuQry->fetch(PDO::FETCH_ASSOC)){
                                
                                    
                            ?>
                            <li>
                                <a href="javascript: void(0);"><i class="<?php echo $menuShow['menu_icon'] ?>"></i> <span> <?php echo $menuShow['menu_nama'] ?> </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <?php 

                                        $submenuSql    = "SELECT * FROM sys_submenu 
                                                        WHERE submenu_menu='$menuShow[menu_id]' AND submenu_id IN (SELECT b.submenu_id FROM sys_akses a 
                                                                                    INNER JOIN sys_submenu b ON a.akses_submenu=b.submenu_id
                                                                                    WHERE a.akses_group='".$userRow['user_group']."')
                                                        ORDER BY submenu_urutan ASC";
                                        $submenuQry    = $koneksidb->prepare($submenuSql);
                                        $submenuQry->execute();
                                        while ($submenuShow    = $submenuQry->fetch(PDO::FETCH_ASSOC)){
                                        $submenulink    =$submenuShow['submenu_link'];
                                        $submenunama    =$submenuShow['submenu_nama'];
                                    ?>
                                    <li><a href="?page=<?php echo base64_encode($submenulink)?>"><?php echo $submenunama ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            

                        </ul>

                    </div>
                    <!-- Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <nav class="navbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <i class="fi-bell noti-icon"></i>
                                    <span class="badge badge-danger badge-pill noti-icon-badge">4</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">

                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0"><span class="float-right"><a href="" class="text-dark"><small>Clear All</small></a> </span>Notification</h5>
                                    </div>

                                    <div class="slimscroll" style="max-height: 230px;">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-success"><i class="mdi mdi-comment-account-outline"></i></div>
                                            <p class="notify-details">Caleb Flakelar commented on Admin<small class="text-muted">1 min ago</small></p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-info"><i class="mdi mdi-account-plus"></i></div>
                                            <p class="notify-details">New user registered.<small class="text-muted">5 hours ago</small></p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-danger"><i class="mdi mdi-heart"></i></div>
                                            <p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">3 days ago</small></p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-warning"><i class="mdi mdi-comment-account-outline"></i></div>
                                            <p class="notify-details">Caleb Flakelar commented on Admin<small class="text-muted">4 days ago</small></p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-purple"><i class="mdi mdi-account-plus"></i></div>
                                            <p class="notify-details">New user registered.<small class="text-muted">7 days ago</small></p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-custom"><i class="mdi mdi-heart"></i></div>
                                            <p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">13 days ago</small></p>
                                        </a>
                                    </div>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View all <i class="fi-arrow-right"></i>
                                    </a>

                                </div>
                            </li>
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="images/<?php echo $dataFoto ?>" alt="user" class="rounded-circle"> <span class="ml-1"><?php echo $userRow['nama_user']; ?><i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <a href="?page=<?php echo base64_encode(confprofile)?>" class="dropdown-item notify-item">
                                        <i class="fi-cog"></i> <span>Your Profile</span>
                                    </a>
                                    <!-- item-->
                                    <a href="?page=<?php echo base64_encode(confpassword)?>" class="dropdown-item notify-item">
                                        <i class="fi-lock"></i> <span>Change Password</span>
                                    </a>

                                    <!-- item-->
                                    <a href="keluar.php" class="dropdown-item notify-item">
                                        <i class="fi-power"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="float-left">
                                <button class="button-menu-mobile open-left disable-btn">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </li>
                            <li>
                                <div class="page-title-box">
                                    <h4 class="page-title">Dashboard </h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">Welcome to Highdmin admin panel !</li>
                                    </ol>
                                </div>
                            </li>

                        </ul>

                    </nav>

                </div>
                <!-- Top Bar End -->



                <!-- Start Page content -->
                <div class="content">
                    <div class="container-fluid">

                        <?php
                            if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                              echo '<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button><i class="fa fa-check"></i> &nbsp;'.$_SESSION['pesan'].'
                                    </div>';
                            }
                            $_SESSION['pesan'] = '';
                          
                            if(isset($_GET['page'])){
                              include("pages.php");
                            }
                            else{
                              include("modul/home.php");
                            }
                          ?>  




                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
                    <?php echo $settRow['sys_setting_footer'] ?>
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->



        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>

        <!-- Flot chart -->
        <script src="plugins/flot-chart/jquery.flot.min.js"></script>
        <script src="plugins/flot-chart/jquery.flot.time.js"></script>
        <script src="plugins/flot-chart/jquery.flot.tooltip.min.js"></script>
        <script src="plugins/flot-chart/jquery.flot.resize.js"></script>
        <script src="plugins/flot-chart/jquery.flot.pie.js"></script>
        <script src="plugins/flot-chart/jquery.flot.crosshair.js"></script>
        <script src="plugins/flot-chart/curvedLines.js"></script>
        <script src="plugins/flot-chart/jquery.flot.axislabels.js"></script>
        <script src="plugins/datatables/dataTables.select.min.js"></script>
        <script src="plugins/datatables/dataTables.keyTable.min.js"></script>
        <script type="text/javascript" src="assets/pages/jquery.form-advanced.init.js"></script>
        <script src="assets/pages/jquery.form-pickers.init.js"></script>
        <script type="text/javascript" src="plugins/autocomplete/jquery.mockjax.js"></script>
        <script type="text/javascript" src="plugins/autocomplete/jquery.autocomplete.min.js"></script>
        <script type="text/javascript" src="plugins/autocomplete/countries.js"></script>
        <script type="text/javascript" src="assets/pages/jquery.autocomplete.init.js"></script>
        <script src="plugins/switchery/switchery.min.js"></script>
        <script src="plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
        <script src="plugins/select2/js/select2.min.js" type="text/javascript"></script>
        <script src="plugins/bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
        <script src="plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <script src="plugins/bootstrap-maxlength/bootstrap-maxlength.js" type="text/javascript"></script>

        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="plugins/datatables/jszip.min.js"></script>
        <script src="plugins/datatables/pdfmake.min.js"></script>
        <script src="plugins/datatables/vfs_fonts.js"></script>
        <script src="plugins/datatables/buttons.html5.min.js"></script>
        <script src="plugins/datatables/buttons.print.min.js"></script>
        <script src="plugins/moment/moment.js"></script>
        <script src="plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
        <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
        <script src="plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
        <script src="plugins/autoNumeric/autoNumeric.js" type="text/javascript"></script>

        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="plugins/jquery-knob/excanvas.js"></script>
        <![endif]-->
        <script src="plugins/jquery-knob/jquery.knob.js"></script>

        <!-- Dashboard Init -->
        <script src="assets/pages/jquery.dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {

                // Default Datatable
                $('#datatable').DataTable();

                //Buttons examples
                var table = $('#datatable-buttons').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf']
                });

                // Key Tables

                $('#key-table').DataTable({
                    keys: true
                });

                // Responsive Datatable
                $('#responsive-datatable').DataTable();

                // Multi Selection Datatable
                $('#selection-datatable').DataTable({
                    select: {
                        style: 'multi'
                    }
                });

                table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            } );

        </script>
        <script>
             $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('slow');}, 500);});
             setTimeout(function(){$(".alert").fadeOut('slow');}, 3000);
        </script>
        <script type="text/javascript">
          $(window).load(function() {
            $(".loader").fadeOut("slow");
          });
        </script>
        <script type="text/javascript" src="assets/scripts/my.js"></script>
        <script type="text/javascript" charset="utf-8">
          function fnHitung() {
          var angka = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('inputku').value)))); //input ke dalam angka tanpa titik
          if (document.getElementById('inputku').value == "") {
            alert("Jangan Dikosongi");
            document.getElementById('inputku').focus();
            return false;
          }
          else
            if (angka >= 1) {
            alert("angka aslinya : "+angka);
            document.getElementById('inputku').focus();
            document.getElementById('inputku').value = tandaPemisahTitik(angka) ;
            return false; 
            }
          }
        </script>
        <script>
             $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('slow');}, 500);});
             setTimeout(function(){$(".alert").fadeOut('slow');}, 3000);
        </script>

    </body>
</html>