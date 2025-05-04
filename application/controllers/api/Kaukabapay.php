<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Kaukabapay extends RESTController {

    public function __construct() {
        parent::__construct();
    }

    public function index_get() {
        $this->response([
            'status' => true,
            'message' => 'Test Rest API Successfuly'
        ], RESTController::HTTP_OK);
    }
}
