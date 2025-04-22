<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model yang dibutuhkan
        $this->load->model('Dashboard_model');
    }

    public function index()
    {
        // Ambil data dari model
        $data['user_count'] = $this->Dashboard_model->get_user_count();
        $data['transaction_count'] = $this->Dashboard_model->get_transaction_count();
        $data['product_count'] = $this->Dashboard_model->get_product_count();

        // Load view dashboard
        $this->load->view('admin/dashboard', $data);
    }
}