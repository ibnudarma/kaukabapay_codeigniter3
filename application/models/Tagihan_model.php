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

    public function myTotalTagihan($user_id)
    {
        // Ambil NIS berdasarkan user_id
        $siswa = $this->db->select('nis')->from('siswa')->where('user_id', $user_id)->get()->row();

        // Jika siswa tidak ditemukan, return 0
        if (!$siswa) {
            return 0;
        }

        // Hitung semua tagihan berdasarkan NIS siswa
        return $this->db->from('tagihan')
            ->where('nis', $siswa->nis)
            ->count_all_results();
    }

    public function myTagihanBelumLunas($user_id)
    {
    // Ambil NIS berdasarkan user_id
    $siswa = $this->db->select('nis')->from('siswa')->where('user_id', $user_id)->get()->row();

    // Jika siswa tidak ditemukan, return array kosong
    if (!$siswa) {
        return [];
    }
        return $this->db->from('tagihan')
            ->where('status', 'belum lunas')
            ->where('nis', $siswa->nis)
            ->count_all_results();
    }

    public function myTagihanLunas($user_id)
    {
    // Ambil NIS berdasarkan user_id
    $siswa = $this->db->select('nis')->from('siswa')->where('user_id', $user_id)->get()->row();

    // Jika siswa tidak ditemukan, return array kosong
    if (!$siswa) {
        return [];
    }
        return $this->db->from('tagihan')
            ->where('status', 'lunas')
            ->where('nis', $siswa->nis)
            ->count_all_results();
    }


    public function total_tagihan_dibayar()
    {
        $this->db->select_sum('dibayar');
        $query = $this->db->get('tagihan');
        $result = $query->row();

        return $result->dibayar ?? 0; // kembalikan 0 jika null
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

    public function get_all_tagihan()
    {
        return $this->db->select('*')->from('tagihan')->get()->result_array();
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

  public function get_my_tagihan($user_id)
    {
        // Ambil NIS berdasarkan user_id
        $siswa = $this->db->select('nis')->from('siswa')->where('user_id', $user_id)->get()->row();

        // Jika siswa tidak ditemukan, return array kosong
        if (!$siswa) {
            return [];
        }

        // Ambil tagihan berdasarkan NIS siswa, join dengan tabel pembayaran
        return $this->db->select('
                tagihan.*,
                pembayaran.id_pembayaran,
                pembayaran.tanggal_pembayaran,
                pembayaran.jumlah_bayar,
                pembayaran.metode_pembayaran
            ')
            ->from('tagihan')
            ->where('tagihan.nis', $siswa->nis)
            ->join('pembayaran', 'pembayaran.tagihan_id = tagihan.id_tagihan', 'left')
            ->order_by('tagihan.created_at', 'DESC')
            ->get()
            ->result();
    }


}