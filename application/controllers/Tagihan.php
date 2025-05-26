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

  public function kepsek()
{
    // Ambil input tanggal dari query string
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');

    // Panggil model dan ambil data tagihan berdasarkan filter tanggal
    $this->load->model('Tagihan_model');
    $tagihan = $this->Tagihan_model->get_all($start_date, $end_date);

    // Kirim data ke view
    $data['tagihan'] = $tagihan;
    $data['title'] = 'Tagihan';
    $data['content'] = "tagihan_kepsek"; // ini nama file view: views/tagihan.php

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

        $apiKey = 'xnd_development_';
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
        $this->load->helper('date');

        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        if (!$start_date || !$end_date) {
            show_error('Tanggal awal dan akhir harus diisi.');
            return;
        }

        $start_datetime = $start_date . ' 00:00:00';
        $end_datetime   = $end_date . ' 23:59:59';

        $this->db->where('created_at >=', $start_datetime);
        $this->db->where('created_at <=', $end_datetime);
        $tagihan = $this->db->get('tagihan')->result_array();

        ob_start();

        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2 { text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .text-right { text-align: right; }
            </style>
        </head>
        <body>
            <h2>Laporan Tagihan</h2>
            <p>Periode: ' . date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date)) . '</p>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>ID Tagihan</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';

        $total = 0;
        foreach ($tagihan as $row) {
            $tgl        = date('d-m-Y H:i', strtotime($row['created_at']));
            $id_tagihan = htmlspecialchars($row['id_tagihan']);
            $jenis      = htmlspecialchars($row['jenis_tagihan']);
            $jumlah     = number_format($row['jumlah'], 0, ',', '.');
            $status     = ucfirst($row['status']);

            $html .= "
                <tr>
                    <td>{$tgl}</td>
                    <td>{$id_tagihan}</td>
                    <td>{$jenis}</td>
                    <td class='text-right'>Rp {$jumlah}</td>
                    <td>{$status}</td>
                </tr>";
            $total += $row['jumlah'];
        }

        $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th class="text-right">Rp ' . number_format($total, 0, ',', '.') . '</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </body>
        </html>';

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        ob_end_clean();

        $filename = "laporan_tagihan_{$start_date}_sd_{$end_date}.pdf";
        $dompdf->stream($filename, ['Attachment' => 0]);
    }

}