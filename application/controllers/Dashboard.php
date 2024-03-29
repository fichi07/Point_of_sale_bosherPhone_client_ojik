<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['barang'] = $this->admin->count('barang');
        $data['barang_masuk'] = $this->admin->count('barang_masuk');
        $data['barang_penjualan'] = $this->admin->count('barang_penjualan_dtl');
        $data['supplier'] = $this->admin->count('supplier');
        $data['user'] = $this->admin->count('user');
        $data['pelanggan'] = $this->admin->count('pelanggan');
        $data['pengaturan'] = $this->admin->get('pengaturan');
        
        $data['stok'] = $this->admin->sum('barang', 'stok');
        $data['barang_min'] = $this->admin->min('barang', 'stok', 10);
        $data['transaksi'] = [
            'barang_masuk' => $this->admin->getBarangMasuk(5),
            'barang_penjualan' => $this->admin->getBarangKeluarDashboard(5)
        ];

       
        $this->template->load('templates/dashboard', 'dashboard', $data);
    }
}
