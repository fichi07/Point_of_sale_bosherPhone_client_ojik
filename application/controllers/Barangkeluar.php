<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Penjualan";
        $data['barangkeluar'] = $this->admin->getBarangkeluar();
        $data['pengaturan'] = $this->admin->get('pengaturan');
        $data['id_barang_penjualan'] = "";
        $this->template->load('templates/dashboard', 'barang_keluar/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'required|trim');

        $this->form_validation->set_rules('diskon', 'Diskon', "trim|less_than_equal_to[{$this->input->post('total_nominal')}]");
    }

    private function _validasi_cart()
    {
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        $input = $this->input->post('barang_id', true);
        $stok = $this->admin->get('barang', ['id_barang' => $input])['stok'];
        $stok_valid = $stok + 0.1;

        $this->form_validation->set_rules(
            'jumlah_keluar',
            'Jumlah Keluar',
            "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
            [
                'less_than' => "Jumlah Keluar tidak boleh lebih dari {$stok}"
            ]
        );
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Penjualan";
            $data['barang'] = $this->admin->get('barang', null, ['stok >' => 0]);
            $data['pelanggan'] = $this->admin->get('pelanggan');
            $data['pengaturan'] = $this->admin->get('pengaturan');

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'T-BK-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_penjualan', 'id_barang_penjualan', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_penjualan'] = $kode . $number;


            $this->template->load('templates/dashboard', 'barang_keluar/add', $data);
        } else {
            $data['pelanggan'] = $this->admin->get('pelanggan');
            $data['pengaturan'] = $this->admin->get('pengaturan');
            // $input = $this->input->post(null, true);
            $input = array(
                'id_barang_penjualan' => $this->input->post('id_barang_penjualan'),
                'user_id' => $this->input->post('user_id'),
                'tanggal_keluar' => $this->input->post('tanggal_keluar'),
                'pelanggan_id' => $this->input->post('pelanggan_id'),
                'u_pelanggan' => $this->input->post('u_pelanggan'),
                'kembalian' => $this->input->post('diskon'),
                'diskon' => $this->input->post('kembalian'),
                'total_nominal' => $this->input->post('total_nominal'),
            );
            if ($this->input->post('grand_total') == "") {
                $input['grand_total'] = $this->input->post('grand_total_hidden');
            } else {
                $input['grand_total'] = $this->input->post('grand_total');
            }
            $insert = $this->admin->insert('barang_penjualan', $input);

            $id_barang_penjualan = $this->input->post('id_barang_penjualan');
            $this->admin->simpan_cart($id_barang_penjualan);
            $this->cart->destroy();

            // var_dump($input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangkeluar');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangkeluar/add');
            }
        }
    }

    public function add_to_cart()
    {
        $this->_validasi_cart();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Penjualan";
            $data['barang'] = $this->admin->get('barang', null, ['stok >' => 0]);
            $data['pengaturan'] = $this->admin->get('pengaturan');
            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'T-BK-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_penjualan', 'id_barang_penjualan', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_penjualan'] = $kode . $number;

            $this->template->load('templates/dashboard', 'barang_keluar/add', $data);
        } else {
            $barang_id = $this->input->post('barang_id');
            $barang = $this->admin->get_barang($barang_id);
            $i = $barang->row_array();
            $data = array(
                'id'       => $i['id_barang'],
                'name'     => $i['nama_barang'],
                'price'    => str_replace(",", "", $this->input->post('harga')),
                'qty'      => $this->input->post('jumlah_keluar'),
                'amount'   => str_replace(",", "", $this->input->post('harga'))
            );
            // var_dump($data);
            $this->cart->insert($data);
            redirect('Barangkeluar/add');
        }
    }

    public function remove()
    {
        $row_id = $this->uri->segment(3);
        $this->cart->update(array(
            'rowid'      => $row_id,
            'qty'     => 0
        ));
        redirect('Barangkeluar/add');
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        //Tambah stok jika hit hapus data
        if ($id) {
            $get = $this->admin->getIDBarangKeluar2($id)->result_array();
            foreach ($get as $i) {
                $data['stok'] = $i['jumlah_keluar'] + $i['stok'];
                $this->admin->update_stok($i['barang_id'], $data);
                // var_dump($data);
            }
        }

        if ($this->admin->delete('barang_penjualan', 'id_barang_penjualan', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangkeluar');
    }

    public function faktur_surat_jalan($id)
    {
        $x['title'] = "Faktur Surat Jalan";
        $x['data'] = $this->admin->getIDBarangKeluar2($id);
        $this->load->view('faktur/surat_jalan', $x);
    }

    public function faktur_surat_tagihan($id)
    {
        $x['title'] = "Faktur Surat Tagihan";
        $x['pengaturan'] = $this->admin->get('pengaturan');
        $x['data'] = $this->admin->getIDBarangKeluar2($id);
        $this->load->view('faktur/surat_tagihan', $x);
    }

    public function surat_jalan($id)
    {
        $x['title'] = "Faktur Surat Jalan";
        $x['data'] = $this->admin->getIDBarangKeluar($id);
        $this->load->view('faktur/surat_jalan', $x);
    }
}
