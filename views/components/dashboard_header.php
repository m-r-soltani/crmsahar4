<?php defined('__ROOT__') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>شبکه سحر ارتباط</title>
    <!-- Global stylesheets -->
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/icons/icomoon/styles.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/bootstrap.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/bootstrap_limitless.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/layout.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/components.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/colors.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/persian-datepicker.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/dataTables.bootstrap4.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/main.css' ?>"/>
    <!--<link rel="stylesheet" href="<?php /*echo __ROOT__ . '/public/css/bootstrap-select.min.css' */ ?>"/>-->
    <!-- /global stylesheets -->
</head>
<body>

<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="/dashboard" class="d-inline-block">
            <!-- <img src="global_assets/images/logo_light.png" alt=""> -->
            <img src="<?php echo __ROOT__ . '/public/images/logo2.jpg' ?>" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>

            <li class="nav-item dropdown">
                <!-- <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                    <i class="icon-git-compare"></i>
                    <span class="d-md-none ml-2">Git updates</span>
                    <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">9</span>
                </a> -->

                <div class="dropdown-menu dropdown-content wmin-md-350">
                    <div class="dropdown-content-header">
                        <span class="font-weight-semibold">Git updates</span>
                        <a href="#" class="text-default"><i class="icon-sync"></i></a>
                    </div>

                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                            <li class="media">
                                <div class="mr-3">
                                    <a href="#"
                                       class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i
                                                class="icon-git-pull-request"></i></a>
                                </div>

                                <div class="media-body">
                                    Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                    <div class="text-muted font-size-sm">4 minutes ago</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3">
                                    <a href="#"
                                       class="btn bg-transparent border-warning text-warning rounded-round border-2 btn-icon"><i
                                                class="icon-git-commit"></i></a>
                                </div>

                                <div class="media-body">
                                    Add full font overrides for popovers and tooltips
                                    <div class="text-muted font-size-sm">36 minutes ago</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3">
                                    <a href="#"
                                       class="btn bg-transparent border-info text-info rounded-round border-2 btn-icon"><i
                                                class="icon-git-branch"></i></a>
                                </div>

                                <div class="media-body">
                                    <a href="#">Chris Arney</a> created a new <span class="font-weight-semibold">Design</span>
                                    branch
                                    <div class="text-muted font-size-sm">2 hours ago</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3">
                                    <a href="#"
                                       class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i
                                                class="icon-git-merge"></i></a>
                                </div>

                                <div class="media-body">
                                    <a href="#">Eugene Kopyov</a> merged <span class="font-weight-semibold">Master</span> and
                                    <span class="font-weight-semibold">Dev</span> branches
                                    <div class="text-muted font-size-sm">Dec 18, 18:36</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3">
                                    <a href="#"
                                       class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i
                                                class="icon-git-pull-request"></i></a>
                                </div>

                                <div class="media-body">
                                    Have Carousel ignore keyboard events
                                    <div class="text-muted font-size-sm">Dec 12, 05:46</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown-content-footer bg-light">
                        <a href="#" class="text-grey mr-auto">All updates</a>
                        <div>
                            <a href="#" class="text-grey" data-popup="tooltip" title="Mark all as read"><i
                                        class="icon-radio-unchecked"></i></a>
                            <a href="#" class="text-grey ml-2" data-popup="tooltip" title="Bug tracker"><i class="icon-bug2"></i></a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <span class="navbar-text ml-md-3 mr-md-auto">
				<!-- <span class="badge bg-success">Online</span> -->
			</span>

        <ul class="navbar-nav">

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="">
                    <span><?php if (isset($_SESSION['login']) && $_SESSION['login'] == "true") {
                            echo $_SESSION['name'];
                        } ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item"><i class="icon-cog5"></i>تنظیمات شخصی</a>
                    <div class="dropdown-divider"></div>
                    <?php echo "<a class='dropdown-item' href='" . __ROOT__ . "logout'><i class='icon-exit2'></i>خروج</a>"; ?>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-right8"></i>
            </a>
            Navigation
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->


        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Main navigation -->
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item">
                        <a href="<?php echo __ROOT__ . 'dashboard'; ?>" class="nav-link active">
                            <i class="icon-home4"></i><span>داشبورد</span>
                        </a>
                    </li>
                    <?php
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case '1':
                                $dashboard_menu = "";
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $dashboard_menu .= "<li class='nav-item nav-item-submenu'>";
                                        $dashboard_menu .= "<a href='#' class='nav-link'><i class='" . Helper::getor_string($_SESSION['dashboard_menu_access_list'][$i]['icon'], 'icon-list2') . "'></i> <span>{$_SESSION['dashboard_menu_access_list'][$i]['name']}</span></a>";
                                        $dashboard_menu .= "<ul class='nav nav-group-sub' data-submenu-title={$_SESSION['dashboard_menu_access_list'][$i]['name']}>";
                                        for ($j = 0; $j < count($_SESSION['dashboard_menu_access_list'][$i]['sub_menu']); $j++) {
                                            if ($_SESSION['dashboard_menu_access_list'][$i]['id'] == $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['category_id']) {
                                                $dashboard_menu .= "<li class='nav-item'><a href='" . __ROOT__ . $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['en_name'] . "' class='nav-link'>{$_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['fa_name']}</a></li>";
                                            }
                                        }
                                        $dashboard_menu .= "</ul>";
                                        $dashboard_menu .= "</li>";
                                    }
                                    echo $dashboard_menu;
                                }
                                break;
                            case '2':
                                $dashboard_menu = "";
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $dashboard_menu .= "<li class='nav-item nav-item-submenu'>";
                                        $dashboard_menu .= "<a href='#' class='nav-link'><i class='" . Helper::getor_string($_SESSION['dashboard_menu_access_list'][$i]['icon'], 'icon-list2') . "'></i> <span>{$_SESSION['dashboard_menu_access_list'][$i]['name']}</span></a>";
                                        $dashboard_menu .= "<ul class='nav nav-group-sub' data-submenu-title={$_SESSION['dashboard_menu_access_list'][$i]['name']}>";
                                        for ($j = 0; $j < count($_SESSION['dashboard_menu_access_list'][$i]['sub_menu']); $j++) {
                                            if ($_SESSION['dashboard_menu_access_list'][$i]['id'] == $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['category_id']) {
                                                $dashboard_menu .= "<li class='nav-item'><a href='" . __ROOT__ . $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['en_name'] . "' class='nav-link'>{$_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['fa_name']}</a></li>";
                                            }
                                        }
                                        $dashboard_menu .= "</ul>";
                                        $dashboard_menu .= "</li>";
                                    }
                                    echo $dashboard_menu;
                                }
                                break;
                            case '3':
                                $dashboard_menu = "";
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $dashboard_menu .= "<li class='nav-item nav-item-submenu'>";
                                        $dashboard_menu .= "<a href='#' class='nav-link'><i class='" . Helper::getor_string($_SESSION['dashboard_menu_access_list'][$i]['icon'], 'icon-list2') . "'></i> <span>{$_SESSION['dashboard_menu_access_list'][$i]['name']}</span></a>";
                                        $dashboard_menu .= "<ul class='nav nav-group-sub' data-submenu-title={$_SESSION['dashboard_menu_access_list'][$i]['name']}>";
                                        for ($j = 0; $j < count($_SESSION['dashboard_menu_access_list'][$i]['sub_menu']); $j++) {
                                            if ($_SESSION['dashboard_menu_access_list'][$i]['id'] == $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['category_id']) {
                                                $dashboard_menu .= "<li class='nav-item'><a href='" . __ROOT__ . $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['en_name'] . "' class='nav-link'>{$_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['fa_name']}</a></li>";
                                            }
                                        }
                                        $dashboard_menu .= "</ul>";
                                        $dashboard_menu .= "</li>";
                                    }
                                    echo $dashboard_menu;
                                }
                                break;
                            case '4':
                                $dashboard_menu = "";
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $dashboard_menu .= "<li class='nav-item nav-item-submenu'>";
                                        $dashboard_menu .= "<a href='#' class='nav-link'><i class='" . Helper::getor_string($_SESSION['dashboard_menu_access_list'][$i]['icon'], 'icon-list2') . "'></i> <span>{$_SESSION['dashboard_menu_access_list'][$i]['name']}</span></a>";
                                        $dashboard_menu .= "<ul class='nav nav-group-sub' data-submenu-title={$_SESSION['dashboard_menu_access_list'][$i]['name']}>";
                                        for ($j = 0; $j < count($_SESSION['dashboard_menu_access_list'][$i]['sub_menu']); $j++) {
                                            if ($_SESSION['dashboard_menu_access_list'][$i]['id'] == $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['category_id']) {
                                                $dashboard_menu .= "<li class='nav-item'><a href='" . __ROOT__ . $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['en_name'] . "' class='nav-link'>{$_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['fa_name']}</a></li>";
                                            }
                                        }
                                        $dashboard_menu .= "</ul>";
                                        $dashboard_menu .= "</li>";
                                    }
                                    echo $dashboard_menu;
                                }
                                break;
                            case '5':
                                $dashboard_menu = "";
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $dashboard_menu .= "<li class='nav-item nav-item-submenu'>";
                                        $dashboard_menu .= "<a href='#' class='nav-link'><i class='" . Helper::getor_string($_SESSION['dashboard_menu_access_list'][$i]['icon'], 'icon-list2') . "'></i> <span>{$_SESSION['dashboard_menu_access_list'][$i]['name']}</span></a>";
                                        $dashboard_menu .= "<ul class='nav nav-group-sub' data-submenu-title={$_SESSION['dashboard_menu_access_list'][$i]['name']}>";
                                        for ($j = 0; $j < count($_SESSION['dashboard_menu_access_list'][$i]['sub_menu']); $j++) {
                                            if ($_SESSION['dashboard_menu_access_list'][$i]['id'] == $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['category_id']) {
                                                $dashboard_menu .= "<li class='nav-item'><a href='" . __ROOT__ . $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['en_name'] . "' class='nav-link'>{$_SESSION['dashboard_menu_access_list'][$i]['sub_menu'][$j]['fa_name']}</a></li>";
                                            }
                                        }
                                        $dashboard_menu .= "</ul>";
                                        $dashboard_menu .= "</li>";
                                    }
                                    echo $dashboard_menu;
                                }
                                break;
                        }
                    }
                    ?>

                    <!-- /main -->
                </ul>
            </div>
            <!-- /main navigation -->
        </div>
        <!-- /sidebar content -->
    </div>
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <!--<div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-right6 mr-2"></i> <span class="font-weight-semibold">Forms</span> - Basic Inputs</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-link btn-float text-default"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                        <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                        <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                    </div>
                </div>
            </div>-->

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <?php if (isset($this->home)) {
                            echo "<a href=" . __ROOT__ . 'dashboard' . " class='breadcrumb-item'><i class='icon-home2 mr-2'></i> $this->home </a>";
                        }
                        if (isset($this->page)) {
                            echo "<a href=" . __ROOT__ . $this->page_url . " class='breadcrumb-item'> $this->page </a>";

                        }
                        ?>
                        <!--<span class="breadcrumb-item active">Basic inputs</span>-->
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <!--<div class="header-elements d-none">
                    <div class="breadcrumb justify-content-center">
                        <a href="#" class="breadcrumb-elements-item">
                            <i class="icon-comment-discussion mr-2"></i>
                            Support
                        </a>

                        <div class="breadcrumb-elements-item dropdown p-0">
                            <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-gear mr-2"></i>
                                Settings
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
                                <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
                                <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
        <!-- /page header -->