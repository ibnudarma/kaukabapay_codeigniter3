<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Cetak extends CI_Controller 
{
    public function __construct() {
        parent::__construct();

        $this->load->model('Tagihan_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Siswa_model');

    }

    public function index() {
        // HTML untuk bukti pembayaran
        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
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
                        <label>No. Pembayaran:</label> <span>1234567890</span>
                    </div>
                    <div class="row">
                        <label>Tanggal:</label> <span>2025-05-11</span>
                    </div>
                    <div class="row">
                        <label>Nama:</label> <span>John Doe</span>
                    </div>
                    <div class="row">
                        <label>Jumlah Pembayaran:</label> <span>Rp 500.000</span>
                    </div>
                    <div class="row">
                        <label>Metode Pembayaran:</label> <span>Transfer Bank</span>
                    </div>
                </div>
                <div class="footer">
                    <p>Terima kasih atas pembayaran Anda.</p>
                </div>
            </div>
        </body>
        </html>
        ';

        // Mengonfigurasi DOMPDF
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);
        
        // Memuat HTML
        $dompdf->loadHtml($html);
        
        // Menetapkan ukuran kertas dan orientasi
        $dompdf->setPaper('A5', 'portrait');
        
        // Merender PDF
        $dompdf->render();
        
        // Men-stream PDF ke browser
        $dompdf->stream("bukti_pembayaran.pdf", array("Attachment" => 0)); // 0 untuk preview di browser
    }

}