<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pembayaran extends RestController {

    private $decoded_token;

    public function __construct() {
        parent::__construct();
        ini_set('display_errors', 0);
        error_reporting(0);
        $this->load->model('Siswa_model');
        $this->load->model('Pembayaran_model');

        $this->load->helper('jwt');
        $this->decoded_token = authorize_request($this, ['siswa']);
    }

    public function index_get() {
        $id_pembayaran = $this->get('id_pembayaran');
        $nis = $this->decoded_token->nis;

        if ($id_pembayaran) {
            $pembayaran = $this->Pembayaran_model->get_pembayaran_by_id($id_pembayaran);
            if ($pembayaran) {
                return $this->response([
                    'status' => true,
                    'message' => 'Detail tagihan ditemukan',
                    'data' => $pembayaran
                ], RESTController::HTTP_OK);
            } else {
                return $this->response([
                    'status' => false,
                    'message' => 'Tagihan tidak ditemukan atau bukan milik siswa ini'
                ], RESTController::HTTP_NOT_FOUND);
            }
        } else {
            $pembayaran = $this->Pembayaran_model->get_all_pembayaran_siswa($nis);
            if ($pembayaran) {
                return $this->response([
                    'status' => true,
                    'message' => 'Tagihan siswa ditemukan',
                    'data' => $pembayaran
                ], RESTController::HTTP_OK);
            } else {
                return $this->response([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], RESTController::HTTP_NOT_FOUND);
            }
        }
    }

}
