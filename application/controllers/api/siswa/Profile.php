<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Profile extends RestController {

    private $decoded_token;

    public function __construct() {
        parent::__construct();
        $this->load->model('Siswa_model');

        $this->load->helper('jwt');
        $this->decoded_token = authorize_request($this, ['siswa']);
    }

    public function index_get() {
        $id_user = $this->decoded_token->id_user;

        $data = $this->Siswa_model->get_siswa_by_user_id($id_user);

        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Profil siswa ditemukan',
                'data' => $data
            ], RESTController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], RESTController::HTTP_NOT_FOUND);
        }
    }
}
