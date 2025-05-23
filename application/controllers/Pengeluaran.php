<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pengeluaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        auth_check();
        $this->load->model('Pengeluaran_model');
    }

    public function index()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $data['title'] = 'Pengeluaran';
        $data['content'] = 'pengeluaran';
        $data['pengeluaran'] = $this->Pengeluaran_model->get_all($start_date, $end_date);

        $this->load->view('template', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Pengeluaran';
        $data['content'] = 'pengeluaran_add';

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

    public function detail()
    {
        $id = $this->input->get('id_pengeluaran');
        if (!$id) {
            show_404();
            return;
        }

        $data['pengeluaran'] = $this->db->get_where('pengeluaran', ['id_pengeluaran' => $id])->row_array();
        if (!$data['pengeluaran']) {
            show_404();
            return;
        }

        $data['title'] = 'Pengeluaran';
        $data['content'] = 'pengeluaran_detail';

        $this->load->view('template', $data);
    }


    public function update()
    {
        $id = $this->input->post('id_pengeluaran');
        $jumlah = $this->input->post('jumlah');
        $deskripsi = $this->input->post('deskripsi');

        if (empty($jumlah) || empty($deskripsi)) {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Jumlah dan deskripsi wajib diisi!</div>');
            redirect('pengeluaran/edit/' . $id);
            return;
        }

        $data = [
            'jumlah' => $jumlah,
            'deskripsi' => $deskripsi
        ];

        $update = $this->Pengeluaran_model->update($id, $data);

        if ($update) {
            $this->session->set_flashdata('alert', '<div class="alert alert-success">Berhasil mengupdate pengeluaran</div>');
        } else {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal mengupdate pengeluaran.</div>');
        }

        redirect('pengeluaran');
    }

    public function delete($id)
    {

        // Panggil model untuk hapus data berdasarkan ID
        $hapus = $this->Pengeluaran_model->delete($id);

        if ($hapus) {
            $this->session->set_flashdata('alert', '<div class="alert alert-success">Pengeluaran berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal menghapus pengeluaran.</div>');
        }

        redirect('pengeluaran');
    }



    public function laporan()
    {

        $this->load->helper('date');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Validasi tanggal
        if (!$start_date || !$end_date) {
            show_error('Tanggal awal dan akhir harus diisi.');
            return;
        }

        $start_datetime = $start_date . ' 00:00:00';
        $end_datetime = $end_date . ' 23:59:59';

        $this->db->where('tanggal_pengeluaran >=', $start_datetime);
        $this->db->where('tanggal_pengeluaran <=', $end_datetime);
        $pengeluaran = $this->db->get('pengeluaran')->result_array();

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
            <h2>Laporan Pengeluaran</h2>
            <p>Periode: '.date('d-m-Y', strtotime($start_date)).' s/d '.date('d-m-Y', strtotime($end_date)).'</p>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Pengeluaran</th>
                        <th>Jumlah</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>';

        $total = 0;
        foreach ($pengeluaran as $row) {
            $tgl = date('d-m-Y H:i', strtotime($row['tanggal_pengeluaran']));
            $jumlah = number_format($row['jumlah'], 0, ',', '.');
            $deskripsi = htmlspecialchars($row['deskripsi']);

            $html .= "
            <tr>
                <td>{$tgl}</td>
                <td class='text-right'>Rp {$jumlah}</td>
                <td>{$deskripsi}</td>
            </tr>";
            $total += $row['jumlah'];
        }

        $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th class="text-right">Rp '.number_format($total, 0, ',', '.').'</th>
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

        $filename = "laporan_pengeluaran_{$start_date}_sd_{$end_date}.pdf";
        $dompdf->stream($filename, ['Attachment' => 0]);
    }

}