<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Tagihan extends RestController {

    private $decoded_token;

    public function __construct() {
        parent::__construct();
        ini_set('display_errors', 0);
        error_reporting(0);
        $this->load->model('Siswa_model');
        $this->load->model('Tagihan_model');

        $this->load->helper('jwt');
        $this->decoded_token = authorize_request($this, ['siswa']);
    }

    public function index_get() {
        $id_tagihan = $this->get('id_tagihan');
        $nis = $this->decoded_token->nis;

        if ($id_tagihan) {
            $tagihan = $this->Tagihan_model->detailTagihan($id_tagihan);
            if ($tagihan) {
                return $this->response([
                    'status' => true,
                    'message' => 'Detail tagihan ditemukan',
                    'data' => $tagihan
                ], RESTController::HTTP_OK);
            } else {
                return $this->response([
                    'status' => false,
                    'message' => 'Tagihan tidak ditemukan atau bukan milik siswa ini'
                ], RESTController::HTTP_NOT_FOUND);
            }
        } else {
            $tagihan = $this->Siswa_model->get_tagihan_siswa($nis);
            if ($tagihan) {
                return $this->response([
                    'status' => true,
                    'message' => 'Tagihan siswa ditemukan',
                    'data' => $tagihan
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
