<?php
class Pengeluaran_model extends CI_Model {

    private $table = 'pengeluaran';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate ID pengeluaran dengan format EXP + 10 digit angka unik
     */
    private function generate_id_pengeluaran()
    {
        $unique = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT); // 10 digit
        return 'EXP' . $unique;
    }

    /**
     * Tambahkan data pengeluaran ke database
     * @param array $data ['tanggal_pengeluaran', 'jumlah', 'deskripsi']
     * @return bool
     */
    public function pengeluaran_add($data)
    {
        $data['id_pengeluaran'] = $this->generate_id_pengeluaran();

        return $this->db->insert($this->table, $data);
    }

    public function get_all()
    {
       return $this->db->select('*')->from('pengeluaran')->get()->result_array();
    }

    /**
     * Ambil total pengeluaran
     */
    public function get_total_pengeluaran()
    {
        $this->db->select_sum('jumlah');
        $query = $this->db->get($this->table);
        return $query->row()->jumlah;
    }

    /**
     * Ambil data pengeluaran berdasarkan rentang tanggal
     */
    public function get_pengeluaran_by_date($start_date, $end_date)
    {
        $this->db->where('tanggal_pengeluaran >=', $start_date);
        $this->db->where('tanggal_pengeluaran <=', $end_date);
        return $this->db->get($this->table)->result();
    }

}
