<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Tagihan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tagihan_model');
        auth_check();
    }

    public function index()
    {

        $filter = $this->input->get('filter', true);
        $jenis_filter = $this->input->get('jenis_filter', true);
        
        if ($filter && $jenis_filter) {
            $config['base_url'] = base_url('tagihan/index?filter=' . urlencode($filter) . '&jenis_filter=' . urlencode($jenis_filter));
            $config['total_rows'] = $this->Tagihan_model->countTagihan($filter, $jenis_filter);
        } else {
            $config['base_url'] = base_url('tagihan/index');
            $config['total_rows'] = $this->Tagihan_model->countTagihan();
        }
        
        $config['per_page'] = 8;
        
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        
        // Mengambil data tagihan dengan filter jika ada, atau seluruh data jika tidak ada filter
        $start = intval($this->uri->segment(3, 0));
        $tagihan = $this->Tagihan_model->getTagihan($filter, $jenis_filter, $config['per_page'], $start);
        
        $data['tagihan'] = $tagihan;
        $data['title'] = 'Tagihan';
        $data['content'] = "tagihan";
        $this->load->view('template', $data);
        
    }

    public function tambah()
    {
        $data['title'] = 'Tagihan';
        $data['content'] = "tagihan_tambah";
        $this->load->view('template', $data);
    }

    public function simpan()
    {
        $jenis_tagihan  = $this->input->post('jenis_tagihan');
        $jumlah_tagihan = $this->input->post('jumlah_tagihan');
        var_dump($jumlah_tagihan);
    
        if (empty($jenis_tagihan) || empty($jumlah_tagihan)) {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Jenis dan jumlah tagihan wajib diisi!</div>');
            redirect('tagihan/tambah');
            return;
        }

        $simpan = $this->Tagihan_model->tambah($jenis_tagihan,$jumlah_tagihan);

        if($simpan) {
            $this->session->set_flashdata('alert', '<div class="alert alert-success">Berhasil menambahkan tagihan ke semua siswa.</div>');
        }else {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal menambahkan tagihan.</div>');
        }

        redirect('tagihan/tambah');
    }

    public function detail($id_tagihan)
    {
        $tagihan = $this->Tagihan_model->detailTagihan($id_tagihan);
        
        $data["tagihan"] = $tagihan;
        $data['title'] = 'Tagihan Detail';
        $data["content"] = "tagihan_detail";

        $this->load->view('template', $data);
    }

 
    public function siswa()
    {
        $tagihan = $this->Tagihan_model->get_my_tagihan($this->session->userdata('user_id'));
        
        $data["tagihan"] = $tagihan;
        $data['title'] = 'Tagihan Saya';
        $data["content"] = "tagihan_siswa";
        
        $this->load->view('template', $data);
    }

    public function bayar($id_tagihan)
    {
        $tagihan = $this->Tagihan_model->detailTagihan($id_tagihan);

        $apiKey = 'xnd_development';
        $payload = [
            'external_id' => $tagihan->id_tagihan,
            'amount' => $tagihan->jumlah,
            'description' => $tagihan->jenis_tagihan,
            'invoice_duration' => 86400,
            'currency' => 'IDR'
        ];

        $client = new Client();

        try {
            $response = $client->request('POST', 'https://api.xendit.co/v2/invoices', [
                'auth' => [$apiKey, ''], // Basic Auth
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = $response->getBody();
            $result = json_decode($body, true);
            header('location: '.$result['invoice_url']);
            exit;

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Tangani error
            echo 'Request failed: ' . $e->getMessage();
            if ($e->hasResponse()) {
                echo '<pre>';
                print_r(json_decode($e->getResponse()->getBody(), true));
                echo '</pre>';
            }
        }
    }

    public function laporan()
    {
       $tagihan = $this->Tagihan_model->get_all_tagihan();
        
        $data["tagihan"] = $tagihan;
        $data['title'] = 'Tagihan Siswa';
        $data["content"] = "tagihan_siswa_kepsek";
        
        $this->load->view('template', $data); 
    }

}