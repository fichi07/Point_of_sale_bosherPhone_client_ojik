<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
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
        $data['title'] = "Pelanggan";
        $data['pelanggan'] = $this->admin->get('pelanggan');
        $data['pengaturan'] = $this->admin->get('pengaturan');
        $this->template->load('templates/dashboard', 'pelanggan/data', $data);
    }

    private function _validasi()
    {
         $this->form_validation->set_rules('id_pelanggan', 'ID Pelanggan', 'required|trim|numeric');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pelanggan";
            $data['pengaturan'] = $this->admin->get('pengaturan');
            $this->template->load('templates/dashboard', 'pelanggan/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $save = $this->admin->insert('pelanggan', $input);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('pelanggan');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('pelanggan/add');
            }
        }
    }


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Pelanggan";
            $data['pengaturan'] = $this->admin->get('pengaturan');
            $data['pelanggan'] = $this->admin->get('pelanggan', ['id_pelanggan' => $id]);
            $this->template->load('templates/dashboard', 'pelanggan/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('pelanggan', 'id_pelanggan', $id, $input);

            if ($update) {
                set_pesan('data berhasil diedit.');
                redirect('pelanggan');
            } else {
                set_pesan('data gagal diedit.');
                redirect('pelanggan/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('pelanggan', 'id_pelanggan', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('pelanggan');
    }
}
