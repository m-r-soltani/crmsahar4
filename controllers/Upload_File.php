<?php defined('__ROOT__') or exit('No direct script access allowed');

class Upload_File extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========upload_file========*/
        if (isset($_POST['send_upload_file'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        if (isset($_FILES['file'])) {
                            $flag      = false;
                            $errors    = "";
                            $file_name = $_FILES['file']['name'];
                            $file_size = $_FILES['file']['size'];
                            $file_tmp  = $_FILES['file']['tmp_name'];
                            $file_type = $_FILES['file']['type'];
                            $ext       = pathinfo($file_name, PATHINFO_EXTENSION);
                            // $tmp       = explode('.', $_FILES['file']['name']);
                            // $file_ext  = end($tmp);
                            
                            $valid_extensions = array("jpeg", "jpg", "png", "pdf", "xlsx" , "xls" , "xlsb" , "xlsm" , "csv", "doc", "docx","ppt", "docx","xml");
                            if (in_array($ext, $valid_extensions)) {
                                $flag = true;
                            } else {
                                $msg=Helper::Messages('fenv');
                                $flag = false;
                            }
                            if ($file_size <= 100000000) {
                                $flag = true;
                            } else {
                                $msg=Helper::Messages('fse');
                                $flag = false;
                            }
                            switch ($_POST['file_usage_type']) {
                                case '1':
                                    //public files
                                    if ($flag) {
                                        if (!file_exists(__DIRECTORY__ .'\\uploads\\public'.'\\'.$file_name)) {
                                            if (move_uploaded_file($file_tmp, __DIRECTORY__ .'\\uploads\\public'.'\\'.$file_name)) {
                                                $arr                       = array();
                                                $arr['usage_type']         = $_POST['file_usage_type'];
                                                $arr['file_name']          = $file_name;
                                                $arr['file_type']          = $ext;
                                                $arr['file_path']          = __DIRECTORY__ .'\\uploads\\public'.'\\';
                                                $arr['file_subject']       = Helper::getor_string($_POST['file_subject'], 'بدون عنوان');
                                                $arr['tarikhe_upload']     = date("Y-m-d H:i:s");
                                                $arr['uploader_user_type'] = $_SESSION['user_type'];
                                                $arr['uploader_id']        = $_SESSION['id'];
                                                $arr['uploader_username']  = $_SESSION['username'];
                                                $sql                       = Helper::Insert_Generator($arr, 'bnm_upload_file');
                                                $res                       = Db::secure_insert_array($sql, $arr);
                                                echo Helper::Alert_Message('s');
                                            } else {
                                                echo Helper::Alert_Message('f');
                                            }
                                        }else {
                                            echo Helper::Alert_Custom_Message($msg);
                                        }
                                    } else {
                                        echo Helper::Alert_Custom_Message($msg);
                                    }
                                    break;
                                case '2':
                                    //private files
                                    if ($flag) {
                                        if (!file_exists(__DIRECTORY__ . '\\uploads\\private'. '\\' . $file_name . '\\' . $file_name)) {
                                            if (move_uploaded_file($file_tmp, __DIRECTORY__ . '\\uploads\\private'.'\\' . $file_name)) {
                                                $arr                       = array();
                                                $arr['usage_type']         = $_POST['file_usage_type'];
                                                $arr['file_name']          = $file_name;
                                                $arr['file_type']          = $ext;
                                                $arr['file_path']          = __DIRECTORY__ . '\\uploads\\private'.'\\';
                                                $arr['file_subject']       = Helper::getor_string($_POST['file_subject'], 'بدون عنوان');
                                                $arr['tarikhe_upload']     = date("Y-m-d H:i:s");
                                                $arr['uploader_user_type'] = $_SESSION['user_type'];
                                                $arr['uploader_id']        = $_SESSION['id'];
                                                $arr['uploader_username']  = $_SESSION['username'];
                                                $sql                       = Helper::Insert_Generator($arr, 'bnm_upload_file');
                                                $res                       = Db::secure_insert_array($sql, $arr);
                                                echo Helper::Alert_Message('s');
                                            } else {
                                                echo Helper::Alert_Message('f');
                                            }
                                        }else {
                                            echo Helper::Alert_Custom_Message($msg);
                                        }
                                    } else {
                                        echo Helper::Alert_Custom_Message($msg);
                                    }
                                    break;
                                default:
                                    echo Helper::Alert_Message('f');
                                    break;
                            }
                        }
                        break;
                    default:
                        echo Helper::Alert_Message('af');
                        break;
                }

            } else {
                Helper::Alert_Message('af');
            }

        }
        $this->view->pagename = 'upload_file';
        $this->view->render('upload_file', 'dashboard_template', '/public/js/upload_file.js', false);

    }
}
