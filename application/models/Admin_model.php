<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function update_stok($id_barang, $data)
    {
        $this->db->where('id_barang', $id_barang);
        $this->db->update('barang', $data);
    }

    public function getUsers($id)
    {
        /**
         * ID disini adalah untuk data yang tidak ingin ditampilkan. 
         * Maksud saya disini adalah 
         * tidak ingin menampilkan data user yang digunakan, 
         * pada managemen data user
         */
        $this->db->where('id_user !=', $id);
        return $this->db->get('user')->result_array();
    }

    public function getBarang()
    {
        $this->db->join('jenis j', 'b.jenis_id = j.id_jenis');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_barang');
        return $this->db->get('barang b')->result_array();
    }

    public function getBarangMasuk($limit = null, $id_barang = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('user u', 'bm.user_id = u.id_user');
        $this->db->join('supplier sp', 'bm.supplier_id = sp.id_supplier');
        $this->db->join('barang b', 'bm.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        if ($limit != null) {
            $this->db->limit($limit);
        }

        if ($id_barang != null) {
            $this->db->where('id_barang', $id_barang);
        }

        if ($range != null) {
            $this->db->where('tanggal_masuk' . ' >=', $range['mulai']);
            $this->db->where('tanggal_masuk' . ' <=', $range['akhir']);
        }

        $this->db->order_by('id_barang_masuk', 'DESC');
        return $this->db->get('barang_masuk bm')->result_array();
    }

    public function getBarangKeluarDashboard($limit = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('barang_penjualan bk', 'bk.id_barang_penjualan = bkd.id_barang_penjualan');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('barang b', 'bkd.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        // if ($id_barang != null) {
        //     $this->db->where('id_barang', $id_barang);
        // }
        if ($range != null) {
            $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
            $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
        }
        $this->db->order_by('bkd.id_detail', 'DESC');
        return $this->db->get('barang_penjualan_dtl bkd')->result_array();
    }

    public function getBarangKeluar($limit = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('barang_penjualan bk', 'bk.id_barang_penjualan = bkd.id_barang_penjualan');
        // $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('barang b', 'bkd.barang_id = b.id_barang');
        $this->db->join('pelanggan p', 'bk.pelanggan_id = p.id_pelanggan');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        // if ($id_barang != null) {
        //     $this->db->where('id_barang', $id_barang);
        // }
        if ($range != null) {
            $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
            $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
        }
        // $this->db->group_by('bk.id_barang_keluar', 'DESC');
        $this->db->order_by('bk.id_barang_penjualan', 'DESC');
        return $this->db->get('barang_penjualan_dtl bkd')->result_array();
    }

    public function getIDBarangKeluar($id_barang_penjualan)
    {
        $this->db->select('*');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('barang b', 'bk.barang_id = b.id_barang');
        $this->db->join('jenis j', 'b.jenis_id = j.id_jenis');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->where('bk.id_barang_penjualan', $id_barang_penjualan);
        $this->db->order_by('id_barang_penjualan', 'DESC');
        return $this->db->get('barang_penjualan bk');
    }

    public function getIDBarangKeluar2($id_barang_penjualan)
    {
        $this->db->select('*');  
        $this->db->join('barang_penjualan bk', 'bk.id_barang_penjualan = bkd.id_barang_penjualan');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('pelanggan p', 'bk.pelanggan_id = p.id_pelanggan');
        $this->db->join('barang b', 'bkd.barang_id = b.id_barang');
        $this->db->join('jenis j', 'b.jenis_id = j.id_jenis');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->where('bk.id_barang_penjualan', $id_barang_penjualan);
        // $this->db->order_by('id_barang_keluar bk', 'DESC');
        return $this->db->get('barang_penjualan_dtl bkd');
    }

    public function findIDBarangKeluar($id)
    {
        $query = $this->db->where('id_barang_penjualan',$id)
       // ->limit(100)
        ->get('barang_penjualan');
        if($query->num_rows() > 0){
            return $query->row_array();
            //return $query;
        }else{
            return array();
            //return $query;
        }
    }

    public function simpan_cart($id_barang_penjualan){
        foreach ($this->cart->contents() as $item) {
            $data=array(
                'id_barang_penjualan'  =>  $id_barang_penjualan,
                'barang_id'       =>  $item['id'],
                'harga'           =>  $item['amount'],
                'jumlah_keluar'   =>  $item['qty'],
                'total_nominal_dtl'   =>  $item['subtotal']
            );
            $this->db->insert('barang_penjualan_dtl',$data);
            // $this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
        }
        return true;
    }

    public function get_barang($id_barang){
        $query=$this->db->query("SELECT * FROM barang where id_barang='$id_barang'");
        return $query;
    }

    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function sum($table, $field)
    {
        $this->db->select_sum($field);
        return $this->db->get($table)->row_array()[$field];
    }

    public function min($table, $field, $min)
    {
        $field = $field . ' <=';
        $this->db->where($field, $min);
        return $this->db->get($table)->result_array();
    }

    public function chartBarangMasuk($bulan)
    {
        $like = 'T-BM-' . date('y') . $bulan;
        $this->db->like('id_barang_masuk', $like, 'after');
        return count($this->db->get('barang_masuk')->result_array());
    }

    public function chartBarangKeluar($bulan)
    {
        $like = 'T-BK-' . date('y') . $bulan;
        $this->db->like('id_barang_penjualan', $like, 'after');
        return count($this->db->get('barang_penjualan_dtl')->result_array());
    }

    public function laporan($table, $mulai, $akhir)
    {
        $tgl = $table == 'barang_masuk' ? 'tanggal_masuk' : 'tanggal_keluar';
        $this->db->where($tgl . ' >=', $mulai);
        $this->db->where($tgl . ' <=', $akhir);
        return $this->db->get($table)->result_array();
    }

    public function cekStok($id)
    {
        $this->db->join('satuan s', 'b.satuan_id=s.id_satuan');
        return $this->db->get_where('barang b', ['id_barang' => $id])->row_array();
    }
}
