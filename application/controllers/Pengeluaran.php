<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        auth_check();
        $this->load->model('Pengeluaran_model');
    }

    public function index()
    {
        $data['title'] = 'Pengeluaran';
        $data['content'] = 'pengeluaran_add';
        $data['pengeluaran'] = $this->Pengeluaran_model->get_all();

        $this->load->view('template', $data);
    }

    public function simpan()
    {
        $jumlah  = $this->input->post('jumlah');
        $deskripsi = $this->input->post('deskripsi');
    
        if (empty($jumlah) || empty($deskripsi)) {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Jenis dan jumlah tagihan wajib diisi!</div>');
            redirect('pengeluaran');
            return;
        }

        $data = [
            'jumlah' => $jumlah,
            'deskripsi' => $deskripsi
        ];

        $simpan = $this->Pengeluaran_model->pengeluaran_add($data);

        if($simpan) {
            $this->session->set_flashdata('alert', '<div class="alert alert-success">Berhasil menambahkan pengeluaran</div>');
        }else {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal menambahkan pengeluaran.</div>');
        }

        redirect('pengeluaran');
    }

    public function laporan()
    {
        $laporan = "";
        $data["tagihan"] = $laporan;
        $data['title'] = 'Tagihan Siswa';
        $data["content"] = "pengeluaran_laporan";
        
        $this->load->view('template', $data); 
    }

}