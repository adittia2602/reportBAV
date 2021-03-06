<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembiayaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');
        $this->load->model('Umi_mods', 'umi');
    }

    public function akad()
    {
        $data['title'] = 'Akad-Pencairan';
        $data['subtitle'] = 'Akad dan Pencairan Pembiayaan Ultra Mikro';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['time'] = $this->umi->lastupdate();

        $data['akad'] = $this->umi->akadPembiayaan();

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pembiayaan/akad', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tagihan()
    {
        $data['title'] = 'Data Tagihan Bulan ini';
        $data['subtitle'] = 'Data Tagihan BAV';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['time'] = $this->umi->lastupdate();

        $data['tagihan'] = $this->umi->tagihanPembiayaan();

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pembiayaan/tagihan', $data);
        $this->load->view('templates/footer', $data);
    }

}
