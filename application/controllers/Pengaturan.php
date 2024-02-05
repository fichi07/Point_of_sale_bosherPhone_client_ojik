<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
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
        $data['title'] = "Pengaturan Toko";
         $data['pengaturan'] = $this->admin->get('pengaturan');
        $this->template->load('templates/dashboard', 'pengaturan/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_toko', 'Nama Toko', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
       
    }

    
    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengaturan";
           
            $data['pengaturan'] = $this->admin->get('pengaturan', ['id_pengaturan' => $id]);
            $this->template->load('templates/dashboard', 'pengaturan/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('pengaturan', 'id_pengaturan', $id, $input);

            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('pengaturan');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('pengaturan/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('pengaturan', 'id_pengaturan', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barang');
    }

}
