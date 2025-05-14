<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model');
        auth_check();
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

    public function edit($nis)
    {
        $data['title'] = 'Siswa Add';
        $data['content'] = 'siswa_edit';
        $data['siswa'] = $this->Siswa_model->get_by_nis($nis);

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

    public function update()
    {
        $nis = $this->input->get('nis');
        $siswa = $this->Siswa_model->get_by_nis($nis);

        if (!$siswa) {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Data siswa tidak ditemukan.</div>');
            redirect('siswa');
            return;
        }

        $email_input = $this->input->post('email');
        $email_lama = $siswa['email'];

        // Cek apakah email berubah
        if ($email_input !== $email_lama) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        }

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
            redirect('siswa/edit?nis=' . $nis);
        } else {
            // Upload foto baru jika ada
            $foto_name = $siswa['foto']; // default foto lama

            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/foto/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = 'foto_' . time(); // nama unik

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    // Hapus foto lama jika ada
                    if ($foto_name && file_exists('./uploads/foto/' . $foto_name)) {
                        unlink('./uploads/foto/' . $foto_name);
                    }
                    $upload_data = $this->upload->data();
                    $foto_name = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('alert', '<div class="alert alert-danger">Upload foto gagal: ' . $this->upload->display_errors('', '') . '</div>');
                    redirect('siswa/edit?nis=' . $nis);
                    return;
                }
            }

            // Jika password diisi, hash
            $password_input = $this->input->post('password');
            $password_hashed = null;
            if (!empty($password_input)) {
                $password_hashed = password_hash($password_input, PASSWORD_DEFAULT);
            }

            // Data akun
            $account_data = [
                'email' => $email_input
            ];
            if ($password_hashed) {
                $account_data['password'] = $password_hashed;
            }

            // Data siswa
            $siswa_data = [
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

            $update = $this->Siswa_model->update($nis, $siswa_data, $account_data);

            if ($update) {
                $this->session->set_flashdata('alert', '<div class="alert alert-success">Data siswa berhasil diperbarui.</div>');
            } else {
                $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal memperbarui data siswa.</div>');
            }

            redirect('siswa/edit/' . $nis);
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

    public function delete($nis)
    {
        $siswa = $this->Siswa_model->get_by_nis($nis);

        if (!$siswa) {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Data siswa tidak ditemukan.</div>');
            redirect('siswa');
            return;
        }

        $this->db->trans_start();

        // Ambil semua tagihan milik siswa ini (berdasarkan NIS)
        $tagihan = $this->db->get_where('tagihan', ['nis' => $nis])->result();

        foreach ($tagihan as $t) {
            // Hapus pembayaran terkait tagihan
            $this->db->where('tagihan_id', $t->id_tagihan)->delete('pembayaran');
        }

        // Hapus semua tagihan siswa
        $this->db->where('nis', $nis)->delete('tagihan');

        // Hapus data siswa
        $this->db->where('nis', $nis)->delete('siswa');

        // Hapus user jika data siswa menyimpan user_id (opsional)
        if (!empty($siswa['user_id'])) {
            $this->db->where('id_user', $siswa['user_id'])->delete('users');
        }

        // Hapus foto jika ada
        if (!empty($siswa['foto']) && file_exists('./uploads/foto/' . $siswa['foto'])) {
            unlink('./uploads/foto/' . $siswa['foto']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('alert_swal', 'Data siswa berhasil dihapus');
        } else {
            $this->session->set_flashdata('alert_swal', 'Gagal menghapus data siswa');
        }

        redirect('siswa');
    }

}