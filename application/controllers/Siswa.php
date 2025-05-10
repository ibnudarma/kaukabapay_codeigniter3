<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Siswa';
        $data['content'] = 'siswa';
        $data['siswa'] = $this->Siswa_model->get_all_with_account();

        $this->load->view('template', $data);
    }

    public function create()
    {
        $data['title'] = 'Siswa Add';
        $data['content'] = 'siswa_add';

        $this->load->view('template', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('nama_orang_tua', 'Nama Orang Tua', 'required');
        $this->form_validation->set_rules('kontak_orang_tua', 'Kontak Orang Tua', 'required');
        $this->form_validation->set_rules('pekerjaan_orang_tua', 'Pekerjaan Orang Tua', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Form tidak valid!</div>');
            redirect('siswa/create');
        } else {
            // Upload foto
            $foto_name = null;
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/foto/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = 'foto_' . time(); // nama unik

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $foto_name = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('alert', '<div class="alert alert-danger">Upload foto gagal: ' . $this->upload->display_errors('', '') . '</div>');
                    redirect('siswa/create');
                    return;
                }
            }
        // Simpan akun dan siswa lewat model agar bisa rollback
        $account_data = [
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => 'siswa'
        ];

        $nis = $this->Siswa_model->generate_nis();

        $siswa_data = [
            'nis' => $nis,
            'nama' => $this->input->post('nama'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat' => $this->input->post('alamat'),
            'nama_orang_tua' => $this->input->post('nama_orang_tua'),
            'kontak_orang_tua' => $this->input->post('kontak_orang_tua'),
            'pekerjaan_orang_tua' => $this->input->post('pekerjaan_orang_tua'),
            'foto' => $foto_name
        ];

        $insert = $this->Siswa_model->insert($siswa_data, $account_data);

        if ($insert) {
            $this->session->set_flashdata('alert', '<div class="alert alert-success">Siswa berhasil ditambahkan!</div>');
        } else {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal menambahkan siswa!</div>');
        }

        redirect('siswa/create');

        }
    }

    public function detail()
    {
        $nis = $this->input->get('nis');

        if (!$nis) {
            show_404(); // atau redirect jika ingin
        }

        // Ambil data siswa berdasarkan NIS
        $this->load->model('Siswa_model');
        $siswa = $this->Siswa_model->get_by_nis($nis);

        if (!$siswa) {
            show_404(); // siswa tidak ditemukan
        }

        $data['siswa'] = $siswa;
        $data['title'] = 'Detail Siswa';
        $data['content'] = 'siswa_detail';

        $this->load->view('template', $data);
    }


}