<?php

class Siswa_model extends CI_Model {

    public function authSiswa($user_id){
        $query = "SELECT * FROM siswa WHERE user_id = ?";
        $result = $this->db->query($query, array($user_id));
        return $result->row();
    }

    public function countSiswa()
    {
        $this->db->from('siswa'); 
        return $this->db->count_all_results();
    }
}

