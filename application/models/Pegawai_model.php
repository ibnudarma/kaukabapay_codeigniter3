<?php
class Pegawai_model extends CI_Model {
    public function authPegawai($user_id){
        $query = "SELECT * FROM pegawai WHERE user_id = ?";
        $result = $this->db->query($query, array($user_id));
        return $result->row();
    }

}

