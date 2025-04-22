<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function loginView()
    {
        $this->load->view('login');
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login_view');
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->Auth_model->get_user($username);

            if ($user && password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'logged_in' => TRUE
                ]);
                redirect('dashboard'); // Ubah sesuai halaman setelah login
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('auth');
            }
        }
    }

    public function dashboard()
    {
        $this->load->view('pages/dashboard');
    }
}