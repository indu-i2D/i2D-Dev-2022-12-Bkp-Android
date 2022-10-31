<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>i2Donate - <?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>skins/images/icon/favicon.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/slicknav.min.css">
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/responsive.css">
    <!--  <link rel="stylesheet" href="<?php echo base_url(); ?>skins/css/jquery.treeSelector.css"> -->
   <!--    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css"> -->
   <style type="text/css">
    .comboTreeWrapper{
    position: relative;
    text-align: left !important;
}

.comboTreeInputWrapper{
    position: relative;
}

.comboTreeArrowBtn {
    position: absolute;
    right: 1px;
    bottom: 1px;
    top: 1px;
    box-sizing: border-box;
    border: none;
    border-left: 1px solid #c7c7c7;
    border-radius: 0 3px 3px 0;
}

.comboTreeDropDownContainer {
    display: none;
    background: #fff;
    border: 1px solid #aaa;
    max-height: 250px;
    overflow-y: auto;
    position: absolute;
    width: 100%;
    box-sizing: border-box;
    z-index: 999;
}

.comboTreeDropDownContainer ul{
    padding: 0px;
    margin: 0;
}

.comboTreeDropDownContainer li{
    list-style-type: none;
    padding-left: 15px;
    cursor: pointer;
}

.comboTreeDropDownContainer li:hover{
    background-color: #ddd;}
.comboTreeDropDownContainer li:hover ul{
    background-color: #fff;}
.comboTreeDropDownContainer li span.comboTreeItemTitle.comboTreeItemHover{
    background-color: #418EFF;
    color: #fff;}

span.comboTreeItemTitle{
    display: block;
    padding: 2px 4px;
}
.comboTreeDropDownContainer label{
    cursor: pointer;
    width: 100%;
    display: block;
}
.comboTreeDropDownContainer .comboTreeItemTitle input {
    position: relative;
    top: 2px;
    margin: 0px 4px 0px 0px;
}
.comboTreeParentPlus{
    position: relative;
    left: -12px;
    top: 4px;
    width: 4px;
    float: left;
}


.comboTreeInputBox {
    padding: 5px;
    border-radius: 3px;
    border: 1px solid #999;
    width: 100%;
    box-sizing: border-box;
    padding-right: 24px;
}

.comboTreeArrowBtnImg{
    font-size: 10px;
}

.multiplesFilter{
    width: 100%;
    padding: 5px;
    box-sizing: border-box;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: 1px solid #999;
}
   </style>
    <!-- modernizr css -->
    <script src="<?php echo base_url(); ?>skins/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body class="body-bg">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- main wrapper start -->
    <div class="horizontal-main-wrapper">
        <!-- main header area start -->
        <div class="mainheader-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>skins/images/icon/idonatelogo.png" alt="logo"></a>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-9 clearfix text-right">                        
                        <div class="clearfix d-md-inline-block d-block">
                            <div class="user-profile m-0">
                                <img class="avatar user-thumb" src="<?php echo base_url(); ?>skins/images/icon/favicon.png" alt="avatar">
                                <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('name'); ?> <i class="fa fa-angle-down"></i></h4>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url().'user/change_password'; ?>">Change Password</a>
                                    <a class="dropdown-item" href="<?php echo base_url().'user/logout'; ?>">Log Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main header area end -->
        <!-- header area start -->
        <div class="header-area header-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-9  d-none d-lg-block">
                        <div class="horizontal-menu">
                            <nav>
                                <ul id="nav_menu">
                                    <!--<li>
                                        <a href="javascript:void(0)"><i class="ti-dashboard"></i><span>dashboard</span></a>
                                        <ul class="submenu">
                                            <li><a href="index.html">ICO dashboard</a></li>
                                            <li><a href="index2.html">Ecommerce dashboard</a></li>
                                            <li><a href="index3.html">SEO dashboard</a></li>
                                        </ul>
                                    </li>-->
                                    <li><a href="<?php echo base_url().'user/dashboard'; ?>"><i class="ti-dashboard"></i> <span>Dashboard</span></a></li>
                                    <li><a href="<?php echo base_url().'user/view'; ?>"><i class="ti-user"></i> <span>Users</span></a></li>
                                    <li><a href="<?php echo base_url().'user/admin_users'; ?>"><i class="ti-user"></i> <span>Admin Users</span></a></li>
                                    <li><a href="<?php echo base_url().'nonprofit/view'; ?>"><i class="ti-user"></i> <span>Non Profit List</span></a></li>
                                    <li><a href="<?php echo base_url().'nonprofit/category_list'; ?>"><i class="ti-user"></i> <span>Category</span></a></li>
                                    <li><a href="<?php echo base_url().'user/payment_list'; ?>"><i class="ti-user"></i> <span>Payment</span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- nav and search button -->
                    <!--<div class="col-lg-3 clearfix">
                        <div class="search-box">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div>
                    </div>-->
                    <!-- mobile_menu -->
                    <div class="col-12 d-block d-lg-none">
                        <div id="mobile_menu"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header area end -->
        <!-- page title area start -->
        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="breadcrumbs-area clearfix">
                        <ul class="breadcrumbs pull-left">
                            <li><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li><span><?php echo $title; ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- page title area end -->