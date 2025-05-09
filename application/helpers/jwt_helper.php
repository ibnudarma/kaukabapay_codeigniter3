<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if (!function_exists('authorize_request')) {
    function authorize_request($CI, $allowed_roles = [], $secret_key = 'Kaukabapay_Secret_Key') {
        $authHeader = $CI->input->get_request_header('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $CI->response([
                'status' => false,
                'message' => 'Token tidak ditemukan'
            ], \chriskacerguis\RestServer\RestController::HTTP_UNAUTHORIZED);
            exit;
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
            if (!in_array($decoded->role, $allowed_roles)) {
                $CI->response([
                    'status' => false,
                    'message' => 'Akses ditolak'
                ], \chriskacerguis\RestServer\RestController::HTTP_FORBIDDEN);
                exit;
            }

            return $decoded;

        } catch (Exception $e) {
            $CI->response([
                'status' => false,
                'message' => 'Token tidak valid: ' . $e->getMessage()
            ], \chriskacerguis\RestServer\RestController::HTTP_UNAUTHORIZED);
            exit;
        }
    }
}
