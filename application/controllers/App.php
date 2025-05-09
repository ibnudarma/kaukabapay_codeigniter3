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

    public function signin()
    {
        if ($this->session->userdata('sign_in') == TRUE) {
            redirect('app/dashboard');
        }
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

                // var_dump($this->session->userdata());

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

    public function lupa_password()
    {
        $this->load->view('lupa_password');
    }

    public function signout()
    {
        $this->session->sess_destroy();

        redirect('app/signin');
    }

    public function dashboard()
    {
        auth_check();
        
        if ($this->session->userdata('user')->role == 'bendahara' || $this->session->userdata('user')->role == 'kepala sekolah' ){

            $data['content'] = "dashboard";
            $data['jumlah_siswa'] = $this->Siswa_model->countSiswa();
            $data['tagihan_belum_lunas'] = $this->Tagihan_model->tagihanBelumLunas();
            $data['tagihan_lunas'] = $this->Tagihan_model->tagihanLunas();
            $this->load->view('template', $data);
        
        } elseif ($this->session->userdata('user')->role == 'siswa') {

            $data['content'] = "dashboard_siswa";
            $data['jumlah_tagihan'] = $this->Tagihan_model->countTagihan($this->session->userdata('siswa')->user_id, 'user_id');
            $data['tagihan_belum_lunas'] = $this->Tagihan_model->tagihanBelumLunas();
            $data['tagihan_lunas'] = $this->Tagihan_model->tagihanLunas();
            $this->load->view('template', $data);
        }
    }

    public function profile()
    {
        auth_check();
        
        if ($this->session->userdata('user')->role == 'bendahara' || $this->session->userdata('user')->role == 'kepala sekolah' ){
            $data["user"] = $this->Pegawai_model->authPegawai($this->session->userdata('user')->id_user);
            $data['content'] = "profile";
            $this->load->view('template', $data);
        } elseif ($this->session->userdata('user')->role == 'siswa') {
            $data["user"] = $this->Siswa_model->authSiswa($this->session->userdata('user')->id_user);
            $data['content'] = "profile_siswa";
            $this->load->view('template', $data);
        }else {
            redirect('app/dashboard');
        }
    }
    
}