<?php
if (!function_exists('auth_check')) {
    function auth_check()
    {
        // Mendapatkan instance CodeIgniter
        $CI =& get_instance();

        // Memeriksa apakah user sudah login
        if (!$CI->session->userdata('sign_in')) {
            // Jika belum login, arahkan ke halaman login
            redirect('app/signin');
        }
    }
    
}
