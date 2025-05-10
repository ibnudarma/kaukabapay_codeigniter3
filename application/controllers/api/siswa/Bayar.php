<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Bayar extends RestController {

    private $decoded_token;

    public function __construct() {
        parent::__construct();
        ini_set('display_errors', 0);
        error_reporting(0);

        $this->load->model('Pembayaran_model');
        $this->load->model('Tagihan_model');
        $this->load->helper('jwt');

        // Autentikasi token JWT
        $this->decoded_token = authorize_request($this, ['siswa']);
        if (!$this->decoded_token) {
            // authorize_request sudah menangani response jika token invalid
            exit;
        }
    }

    public function index_post()
    {
        // Ambil input dari body JSON
        $input = json_decode(trim(file_get_contents("php://input")), true);
        $id_tagihan = isset($input['id_tagihan']) ? $input['id_tagihan'] : null;

        if (!$id_tagihan) {
            return $this->response([
                'status' => false,
                'message' => 'ID tagihan tidak valid.'
            ], RestController::HTTP_BAD_REQUEST);
        }

        // Cek apakah tagihan ada
        $tagihan = $this->db->get_where('tagihan', ['id_tagihan' => $id_tagihan])->row();

        if (!$tagihan) {
            return $this->response([
                'status' => false,
                'message' => 'Tagihan tidak ditemukan.'
            ], RestController::HTTP_NOT_FOUND);
        }

        // Cek apakah sudah dibayar
        if ($tagihan->status == 'lunas') {
            return $this->response([
                'status' => false,
                'message' => 'Tagihan sudah dibayar.'
            ], RestController::HTTP_OK);
        }

        // Simulasi proses pembayaran
        $this->db->where('id_tagihan', $id_tagihan);
        $this->db->update('tagihan', [
            'dibayar' => $tagihan->jumlah,
        ]);

        return $this->response([
            'status' => true,
            'message' => 'Pembayaran berhasil.'
        ], RestController::HTTP_OK);
    }
}
