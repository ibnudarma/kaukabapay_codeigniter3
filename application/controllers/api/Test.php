<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Test extends RESTController {

    public function __construct() {
        parent::__construct();
    }

    public function index_get() {
        $this->response([
            'status' => true,
            'message' => 'The method get'
        ], RESTController::HTTP_OK);
    }

    public function index_post() {
        $this->response([
            'status' => true,
            'message' => 'The method post'
        ], RESTController::HTTP_OK);
    }

    public function index_put() {
        $this->response([
            'status' => true,
            'message' => 'The method put'
        ], RESTController::HTTP_OK);
    }

    public function index_patch() {
        $this->response([
            'status' => true,
            'message' => 'The method patch'
        ], RESTController::HTTP_OK);
    }

    public function index_delete() {
        $this->response([
            'status' => true,
            'message' => 'The method delete'
        ], RESTController::HTTP_OK);
    }
}
