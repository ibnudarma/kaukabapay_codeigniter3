<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController {

    private $decoded_token;

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');

        $this->decoded_token = authorize_request($this, ['kepala_sekolah', 'bendahara']);
    }

    public function index_get() {
        $id = $this->get('id');

        if ($id === NULL) {
            $data = $this->User_model->get_all_users();
        } else {
            $data = $this->User_model->get_user_by_id($id);
        }

        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data,
                'akses_oleh' => $this->decoded_token->role
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    // POST: Tambah user
    public function index_post() {
        $data = [
            'email' => $this->post('email'),
            'password' => password_hash($this->post('password'), PASSWORD_BCRYPT),
            'role' => $this->post('role')
        ];

        if ($this->User_model->insert_user($data)) {
            $this->response([
                'status' => true,
                'message' => 'User berhasil ditambahkan'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan user'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    // PUT: Update user
    public function index_put() {
        $id = $this->put('id');

        $data = [
            'email' => $this->put('email'),
            'role' => $this->put('role')
        ];

        if ($this->put('password')) {
            $data['password'] = password_hash($this->put('password'), PASSWORD_BCRYPT);
        }

        if ($this->User_model->update_user($id, $data)) {
            $this->response([
                'status' => true,
                'message' => 'User berhasil diperbarui'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal memperbarui user'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    // DELETE: Hapus user
    public function index_delete() {
        $id = $this->delete('id');

        if ($this->User_model->delete_user($id)) {
            $this->response([
                'status' => true,
                'message' => 'User berhasil dihapus'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menghapus user'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}
