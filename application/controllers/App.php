<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Tagihan_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Siswa_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper('url');
        $this->load->helper('auth');
    }

    public function test_db() {
        $this->load->database(); // Memastikan koneksi ke database
        if ($this->db->conn_id) {
            echo "Koneksi berhasil!";
        } else {
            echo "Koneksi gagal!";
        }
    }

    public function signin()
    {
        
        $this->load->view('signin');
    }

    public function authenticate() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('', '');
   
        if ($this->form_validation->run() == FALSE) {
                $this->load->view('signin');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->authCheck($email,$password);
            if($user->role == "bendahara" || $user->role == "kepala sekolah"){
                $pegawai = $this->Pegawai_model->authPegawai($user->id_user);
                $this->session->set_userdata([
                    'user' => $user,
                    'pegawai' => $pegawai,
                    'sign_in' => TRUE
                ]);

                var_dump($this->session->userdata());

                redirect('app/dashboard');
            }elseif ($user->role == "siswa"){
                $siswa = $this->Siswa_model->authSiswa($user->id_user);
                $this->session->set_userdata([
                    'user' => $user,
                    'siswa' => $siswa,
                    'sign_in' => TRUE
                ]);

                // var_dump($this->session->userdata());

                redirect('app/dashboard');
            }
        }
    }

    public function signout()
    {
        $this->session->sess_destroy();

        redirect('app/signin');
    }

    public function dashboard()
    {
        auth_check();
        // var_dump($data);
        $data['content'] = "dashboard";
        $data['jumlah_siswa'] = $this->Siswa_model->countSiswa();
        $data['tagihan_belum_lunas'] = $this->Tagihan_model->tagihanBelumLunas();
        $data['tagihan_lunas'] = $this->Tagihan_model->tagihanLunas();
        $this->load->view('template', $data);
    }
}