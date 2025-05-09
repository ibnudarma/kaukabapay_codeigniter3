<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use \Firebase\JWT\JWT;

class Auth extends RestController {

    private $key;

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->key = 'Kaukabapay_Secret_Key';
    }

    public function index_post() {
        $email = $this->post('email');
        $password = $this->post('password');

        $user = $this->User_model->get_user_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            $payload = [
                'id_user' => $user->id_user,
                'email' => $user->email,
                'role' => $user->role,
                'iat' => time(),
                'exp' => time() + (60 * 60) // Token berlaku 1 jam
            ];

            $token = JWT::encode($payload, $this->key, 'HS256');

            $this->response([
                'status' => true,
                'message' => 'Login berhasil',
                'token' => $token
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Email atau password salah'
            ], RestController::HTTP_UNAUTHORIZED);
        }
    }

}
