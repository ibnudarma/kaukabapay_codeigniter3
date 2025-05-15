<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tagihan_model');
        $this->load->model('Pembayaran_model');
    }

    public function index()
    {
        // Bisa untuk list pembayaran
    }

    public function webhook()
    {
          $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Logging payload ke file log CodeIgniter
        log_message('debug', 'Xendit webhook payload: ' . $json);

        if (!$data) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid payload']);
            return;
        }

        // Pastikan data ada dan status valid
        if (isset($data['status']) && isset($data['external_id'])) {
            // http_response_code(200);
            // echo json_encode($data);
            // exit;
            $status = strtoupper($data['status']);
            $external_id = $data['external_id'];

            if ($status == 'PAID' || $status == 'SUCCESS') {
                // Update data pembayaran di database
                $update = $this->Pembayaran_model->proses_pembayaran_berhasil($external_id, $data);

                if ($update) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Webhook berhasil diterima']);
                    return;
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Gagal update database']);
                    return;
                }
            }
        }

        http_response_code(400);
        echo json_encode(['message' => 'Status pembayaran tidak valid atau data kurang lengkap']);
    }

    public function cetak($id_pembayaran)
    {
        // Mulai output buffering untuk mencegah headers already sent
        ob_start();

        // Ambil data pembayaran + join tagihan
        $this->db->select('pembayaran.*, tagihan.jenis_tagihan, tagihan.jumlah AS total_tagihan');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'pembayaran.tagihan_id = tagihan.id_tagihan');
        $this->db->where('pembayaran.id_pembayaran', $id_pembayaran);
        $pembayaran = $this->db->get()->row();

        if (!$pembayaran) {
            show_404();
            return;
        }

        // Format tanggal dan nominal
        $tanggal = date('d-m-Y', strtotime($pembayaran->tanggal_pembayaran));
        $jumlah_bayar = 'Rp ' . number_format($pembayaran->jumlah_bayar, 0, ',', '.');

        // HTML untuk bukti pembayaran
        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    width: 100%;
                    padding: 20px;
                    background-color: #ffffff;
                    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header h1 {
                    font-size: 24px;
                    color: #333;
                }
                .details {
                    font-size: 14px;
                    color: #555;
                    margin-bottom: 20px;
                }
                .details .row {
                    margin: 10px 0;
                }
                .details .row label {
                    font-weight: bold;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 12px;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Bukti Pembayaran</h1>
                </div>
                <div class="details">
                    <div class="row">
                        <label>No. Pembayaran:</label> <span>' . $pembayaran->id_pembayaran . '</span>
                    </div>
                    <div class="row">
                        <label>Tanggal:</label> <span>' . $tanggal . '</span>
                    </div>
                    <div class="row">
                        <label>Nama Tagihan:</label> <span>' . $pembayaran->jenis_tagihan . '</span>
                    </div>
                    <div class="row">
                        <label>Jumlah Pembayaran:</label> <span>' . $jumlah_bayar . '</span>
                    </div>
                    <div class="row">
                        <label>Metode Pembayaran:</label> <span>' . $pembayaran->metode_pembayaran . '</span>
                    </div>
                </div>
                <div class="footer">
                    <p>Terima kasih atas pembayaran Anda.</p>
                </div>
            </div>
        </body>
        </html>
        ';

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait');
        $dompdf->render();

        // Bersihkan buffer dan kirim PDF
        ob_end_clean(); // WAJIB sebelum stream()
        $dompdf->stream($pembayaran->id_pembayaran.".pdf", array("Attachment" => 0));
    }

}
