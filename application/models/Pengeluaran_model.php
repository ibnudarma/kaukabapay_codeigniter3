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

    public function get_all($start_date = null, $end_date = null)
    {
        $this->db->select('*')->from('pengeluaran');

        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('tanggal_pengeluaran >=', $start_date . ' 00:00:00');
            $this->db->where('tanggal_pengeluaran <=', $end_date . ' 23:59:59');
        }

        return $this->db->order_by('tanggal_pengeluaran', 'DESC')->get()->result_array();
    }

    public function pengeluaran_add($data)
    {
        $data['id_pengeluaran'] = $this->generate_id_pengeluaran();

        return $this->db->insert($this->table, $data);
    }

    /**
     * Ambil total pengeluaran
     */
    public function get_total_pengeluaran()
    {
        $this->db->select_sum('jumlah');
        $query = $this->db->get('pengeluaran');
        $result = $query->row();

        return $result->jumlah ?? 0;
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

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_pengeluaran' => $id])->row_array();
    }

    public function update($id, $data)
    {
        $this->db->where('id_pengeluaran', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id_pengeluaran', $id);
        return $this->db->delete($this->table);
    }


}
