<?php

class Siswa_model extends CI_Model {

    public function generate_nis()
    {
        $this->db->select('nis');
        $this->db->order_by('nis', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('siswa');

        if ($query->num_rows() > 0) {
            $last_nis = $query->row()->nis;
            $number = (int) substr($last_nis, 3); // ambil angka setelah "NIS"
            $new_number = $number + 1;
            return 'NIS' . str_pad($new_number, 3, '0', STR_PAD_LEFT);
        } else {
            return 'NIS001';
        }
    }

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

    public function get_by_nis($nis)
    {
        $this->db->select('siswa.*, users.email, users.role')
                ->from('siswa')
                ->join('users', 'siswa.user_id = users.id_user')
                ->where('nis',$nis);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_siswa_by_user_id($user_id) {
        return $this->db->get_where('siswa', ['user_id' => $user_id])->row();
    }

    public function get_all_with_account()
    {
        $this->db->select('siswa.*, users.email, users.role');
        $this->db->from('siswa');
        $this->db->join('users', 'siswa.user_id = users.id_user');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert($siswa_data, $account_data)
    {
        $this->db->trans_begin();

        // Generate UUID secara manual
        $uuid = $this->db->query("SELECT UUID() AS uuid")->row()->uuid;

        $account_data['id_user'] = $uuid; // Tambahkan UUID ke akun
        $siswa_data['user_id'] = $uuid;   // Masukkan UUID ke siswa

        // 1. Insert ke tabel users
        $this->db->insert('users', $account_data);

        if (!$this->db->affected_rows()) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal menyimpan akun pengguna.</div>');
            redirect('siswa/create');
            return;
        }

        // 2. Insert ke tabel siswa
        $this->db->insert('siswa', $siswa_data);

        if (!$this->db->affected_rows()) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

}

