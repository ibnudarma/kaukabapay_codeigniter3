<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper('url');
        $this->load->helper('auth');
    }

    public function index()
    {
        auth_check();
        // var_dump($data);
        $data['content'] = "tagihan";
        $this->load->view('template', $data);
    }

}