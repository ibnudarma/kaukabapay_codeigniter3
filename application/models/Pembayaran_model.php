<?php

class Pembayaran_model extends CI_Model {

    public function get_all_pembayaran_siswa($nis = null) {
        $this->db->select('
            pembayaran.id_pembayaran,
            pembayaran.tanggal_pembayaran,
            pembayaran.jumlah_bayar,
            pembayaran.metode_pembayaran,
            tagihan.jenis_tagihan,
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

    public function proses_pembayaran_berhasil($external_id, $data) {
        // Cari tagihan berdasarkan external_id
        $tagihan = $this->db->get_where('tagihan', ['id_tagihan' => $external_id])->row();

        if (!$tagihan) {
            return false; // Tagihan tidak ditemukan
        }

        $jumlah_bayar = $data['paid_amount'] ?? $data['amount'];
        $new_dibayar = $tagihan->dibayar + $jumlah_bayar;

        // Transaksi database
        $this->db->trans_start();

        // Update tagihan
        $this->db->where('id_tagihan', $tagihan->id_tagihan);
        $this->db->update('tagihan', [
            'dibayar' => $new_dibayar,
        ]);

        // Insert data pembayaran baru
        $pembayaran_data = [
            'tagihan_id' => $tagihan->id_tagihan,
            'jumlah_bayar' => $jumlah_bayar,
            'metode_pembayaran' => $data['payment_method'] ?? null,
        ];
        $this->db->insert('pembayaran', $pembayaran_data);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}
