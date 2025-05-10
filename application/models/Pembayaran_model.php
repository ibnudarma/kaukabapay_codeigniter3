<?php

class Pembayaran_model extends CI_Model {

    public function get_all_pembayaran_siswa($nis = null) {
        $this->db->select('
            pembayaran.id_pembayaran,
            pembayaran.tanggal_pembayaran,
            pembayaran.jumlah_bayar,
            pembayaran.metode_pembayaran,
            tagihan.nis,
            tagihan.jenis_tagihan,
            tagihan.jumlah,
            tagihan.status
        ');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'pembayaran.tagihan_id = tagihan.id_tagihan');

        if ($nis !== null) {
            $this->db->where('tagihan.nis', $nis);
        }

        $this->db->order_by('pembayaran.tanggal_pembayaran', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_pembayaran_by_id($id_pembayaran)
    {
        $this->db->select('*')
        ->from('pembayaran')
        ->where('id_pembayaran', $id_pembayaran);

        return $this->db->get()->row_array();
    }

}
