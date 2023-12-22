<?php defined('__ROOT__') or exit('No direct script access allowed');
class Pre_Asiatech_Bitstream_Emkansanji extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {   
        $this->view->pagename = 'pre_asiatech_bitstream_emkansanji';
        $this->view->render('pre_asiatech_bitstream_emkansanji', 'blankdashboard', '/public/js/pre_asiatech_bitstream_emkansanji.js', false);
    }
}
