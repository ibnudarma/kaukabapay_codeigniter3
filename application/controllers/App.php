<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller 
{
    public function __construct() {
        parent::__construct();

        $this->load->model('Tagihan_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Siswa_model');

    }

    public function index()
    {
        if(!$this->session->userdata('sign_in')){
            redirect('app/sign_in');
        }else{
            redirect('app/dashboard');
        }
    }

    public function sign_in()
    {
        if($this->input->method() == 'get') {

            $this->load->view('sign_in');

        }elseif ($this->input->method() == 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_error_delimiters('', '');
       
            if ($this->form_validation->run() == FALSE) {

                $this->load->view('sign_in');

            }else{

                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $user = $this->User->get_user_by_email($email);
                if ($user && password_verify($password, $user->password)){
                    $this->session->set_userdata([
                        'user_id' => $user->id_user,
                        'email'   => $user->email,
                        'role'    => $user->role,
                        'sign_in' => true
                    ]);

                    redirect('app');

                }else{
                    $this->session->set_flashdata('error','Periksa kembali username dan password anda');
                    $this->load->view('sign_in');
                }
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
        
        if ($this->session->userdata('role') == 'bendahara' || $this->session->userdata('role') == 'kepala sekolah' ){

            $data['jumlah_siswa'] = $this->Siswa_model->countSiswa();
            $data['tagihan_belum_lunas'] = $this->Tagihan_model->tagihanBelumLunas();
            $data['tagihan_lunas'] = $this->Tagihan_model->tagihanLunas();

            $data['content'] = "dashboard";
            $this->load->view('template', $data);
        
        } elseif ($this->session->userdata('role') == 'siswa') {

            $data['jumlah_tagihan'] = $this->Tagihan_model->countTagihan($this->session->userdata('siswa')->user_id, 'user_id');
            $data['tagihan_belum_lunas'] = $this->Tagihan_model->tagihanBelumLunas();
            $data['tagihan_lunas'] = $this->Tagihan_model->tagihanLunas();

            $data['content'] = "dashboard_siswa";
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