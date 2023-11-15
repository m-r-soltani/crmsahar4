<?php defined('__ROOT__') or exit('No direct script access allowed');

class Dashboard_Menu_Group_Access extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/

        if (isset($_POST['send_dashboard_menu_group_access'])) {
            unset($_POST['send_dashboard_menu_group_access']);
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                    switch ($_POST['user_type']) {
                        case '1':
                            //admin
                            ///update bnm_dashboard_menu admin_display
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                if (!in_array(__GROUPACCESSID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __GROUPACCESSID__);
                                }

                                $sql            = "UPDATE bnm_dashboard_menu set admin_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set admin_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;
                        case '4':
                            //admin operator
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                $sql            = "UPDATE bnm_dashboard_menu set admin_operator_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set admin_operator_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;
                        case '2':
                            //namayandegi(modir)
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                $sql            = "UPDATE bnm_dashboard_menu set branch_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set branch_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;
                        case '3':
                            //namayandegi sathe2(modir)
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                $sql            = "UPDATE bnm_dashboard_menu set branch2_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set branch2_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;
                        case '5':
                            //subscriber
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                $sql            = "UPDATE bnm_dashboard_menu set subscriber_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set subscriber_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;

                        default:

                            break;
                    }
                    break;
                case __ADMINOPERATORUSERTYPE__:
                    switch ($_POST['user_type']) {
                        case '1':
                            //admin
                            echo "<script>alert('خطا در سیستم.');</script>";
                            break;
                        case '4':
                            //admin operator
                            echo "<script>alert('خطا در سیستم.');</script>";
                            break;
                        case '2':
                            //namayandegi(modir)
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                $sql            = "UPDATE bnm_dashboard_menu set branch_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set branch_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;
                        case '3':
                            //namayandegi sathe2(modir)
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                $sql            = "UPDATE bnm_dashboard_menu set branch2_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set branch2_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;
                        case '5':
                            //subscriber
                            if (count($_POST['dashboard_menu']) > 0) {
                                if (!in_array(__DASHBOARDID__, $_POST['dashboard_menu'])) {
                                    array_push($_POST['dashboard_menu'], __DASHBOARDID__);
                                }
                                $sql            = "UPDATE bnm_dashboard_menu set subscriber_display = 0";
                                $res            = Db::justexecute($sql);
                                $where_menu_ids = "";
                                if ($res) {
                                    for ($i = 0; $i < count($_POST['dashboard_menu']); $i++) {
                                        if ($i == count($_POST['dashboard_menu']) - 1) {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i];
                                        } else {
                                            $where_menu_ids .= $_POST['dashboard_menu'][$i] . ',';
                                        }
                                    }
                                    $sql    = "UPDATE bnm_dashboard_menu set subscriber_display = 1 WHERE id IN ($where_menu_ids)";
                                    $result = Db::justexecute($sql);
                                    if ($result) {
                                        echo "<script>alert('دسترسی ها اختصاص داده شد');</script>";
                                    } else {
                                        echo "<script>alert('خطا در سیستم.');</script>";
                                    }
                                } else {
                                    echo "<script>alert('خطا در سیستم.');</script>";
                                }
                            } else {
                                echo "<script>alert('لطفا منوهای مورد نظر را انتخاب نمایید.');</script>";
                            }
                            break;

                        default:

                            break;
                    }

                    break;

                default:
                    echo "<script>alert('گروه کاربری نا معتبر');</script>";
                    break;
            }
            //update bnm_dashboard_menu

        }
        $this->view->pagename = 'dashboard_menu_group_access';
        $this->view->render('dashboard_menu_group_access', 'dashboard_template', '/public/js/dashboard_menu_group_access.js', false);
    }
}
