<?php
class User_model extends CI_Model {

    public function authCheck($email, $password){
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $result = $this->db->query($query, array($email, $password));
        return $result->row();
    }    

}

