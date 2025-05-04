<?php

class Siswa_model extends CI_Model {
    public function authSiswa($user_id){
        $query = "SELECT * FROM siswa WHERE user_id = ?";
        $result = $this->db->query($query, array($user_id));
        return $result->row();
    }
}

