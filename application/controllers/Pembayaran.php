<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        auth_check();
    }

    public function index()
    {
        // Bisa untuk list pembayaran
    }

}
