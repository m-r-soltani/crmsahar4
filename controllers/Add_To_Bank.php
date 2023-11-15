<?php defined('__ROOT__') or exit('No direct script access allowed');
class Add_To_Bank extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_add_to_bank'])) {
            try {
                unset($_POST['send_add_to_bank']);
                $_POST = Helper::xss_check_array($_POST);
                ///read file content
                $sql      = "SELECT * FROM bnm_upload_file WHERE id = ?";
                $res_file = Db::secure_fetchall($sql, array($_POST['file_id']));

                $sql      = "SELECT * FROM bnm_banks WHERE id = ?";
                $res_bank = Db::secure_fetchall($sql, array($_POST['bank_id']));
                if ($res_file) {
                    if ($res_bank) {
                        $sql=Helper::Update_Generator(
                            array(
                                'id'        => $res_bank[0]['id'],
                                'name'      => $res_bank[0]['name'],
                                'file_id'   => $res_file[0]['id']
                            ),
                            'bnm_banks',
                            "WHERE id = :id"
                        
                        );
                        $res=Db::secure_update_array(
                            $sql,
                            array(
                                'id'        => $res_bank[0]['id'],
                                'name'      => $res_bank[0]['name'],
                                'file_id'   => $res_file[0]['id']
                            )
                        );
                        if($res){
                            echo Helper::Alert_Message('s');
                        }else{
                            echo Helper::Alert_Message('f');
                        }
                    } else {
                        echo Helper::Alert_Message('bank_nf');
                    }
                } else {
                    echo Helper::Alert_Message('file_nf');
                }

                // if ($_POST['id'] == "empty") {
                //     unset($_POST['id']);
                //     // $sql = Helper::Insert_Generator($_POST, 'bnm_bank_content');
                //     // Db::secure_insert_array($sql, $_POST);
                // } else {
                //     // $sql = Helper::Update_Generator($_POST, 'bnm_bank_content', "WHERE id = :id");
                //     // Db::secure_update_array($sql, $_POST);
                // }
            } catch (Throwable $e) {
                $res = Helper::Exc_Error_Debug($e, true, '', true);
                die();
            }
        }

        $this->view->pagename = 'add_to_bank';
        $this->view->render('add_to_bank', 'dashboard_template', '/public/js/add_to_bank.js', false);
    }
}
