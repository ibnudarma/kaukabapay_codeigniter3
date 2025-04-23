<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper('url');
    }

    public function signin()
    {
        $this->load->view('signin');
    }

    public function authenticate() {
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('signin');
        } else {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->Auth_model->get_user($email);

            if ($user && password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'logged_in' => TRUE
                ]);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'email atau password salah!');
                redirect('auth');
            }
        }
    }

    public function dashboard()
    {
        $this->load->view('dashboard');
    }
}