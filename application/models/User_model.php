<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        $bendahara = $this->db->get_where('users', ['role' => 'bendahara'])->row();

        if (!$bendahara) {
            $user_data = [
                'email' => 'bendahara@example.com',
                'password' => password_hash('rahasia123', PASSWORD_DEFAULT),
                'role' => 'bendahara'
            ];
            $this->db->insert('users', $user_data);
        }


    }

    public function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id_user' => $id])->row();
    }

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data) {
        $this->db->where('id_user', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        return $this->db->delete('users', ['id_user' => $id]);
    }
}
