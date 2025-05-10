<?php

class Tagihan_model extends CI_Model {

    public function countTagihan($filter = null, $jenis_filter = null)
    {
        if ($filter && $jenis_filter) {
            $this->db->like($jenis_filter, $filter);
        }
        $this->db->from('tagihan t');
        $this->db->join('siswa s', 's.nis = t.nis');
        return $this->db->count_all_results();
    }

    public function tagihanBelumLunas(){
        $this->db->from('tagihan');
        $this->db->where('status', 'belum lunas');
        return $this->db->count_all_results();
    }

    public function tagihanLunas(){
        $this->db->from('tagihan');
        $this->db->where('status', 'lunas');
        return $this->db->count_all_results();
    }

    public function getTagihan($filter = null, $jenis_filter = null, $limit = 10, $start = 0)
    {
        if ($filter && $jenis_filter) {
            $this->db->like($jenis_filter, $filter);
        }
        $this->db->select('t.*, s.nama');
        $this->db->from('tagihan t');
        $this->db->join('siswa s', 's.nis = t.nis');
        
        $this->db->limit($limit, $start);
    
        $this->db->order_by('t.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    private function generate_id_tagihan()
    {
        $prefix = 'TG';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomPart = '';
        for ($i = 0; $i < 8; $i++) {
            $randomPart .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $prefix . $randomPart;
    }

    public function tambah($jenis_tagihan, $jumlah_tagihan)
    {
        $query = "INSERT INTO tagihan (nis, jenis_tagihan, jumlah)
            SELECT nis, ?, ?
            FROM siswa";

        $result = $this->db->query($query,array($jenis_tagihan,$jumlah_tagihan));

        return $result;
    }

    public function detailTagihan($id_tagihan)
    {
        $this->db->select('t.*, s.nama');
        $this->db->from('tagihan t');
        $this->db->join('siswa s', 's.nis = t.nis');
        $this->db->where('t.id_tagihan', $id_tagihan);
        $result = $this->db->get();
        return $result->row();
    }

}