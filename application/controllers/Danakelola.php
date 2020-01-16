<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Danakelola extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');
        $this->load->model('WS_mods', 'ws');
    }

    public function akad()
    {
        $data['title'] = 'Akad-Pencairan';
        $data['subtitle'] = 'Akad dan Pencairan Pembiayaan Penyalur';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $data['akad'] = $this->ws->fetchData('GET','report/akadpenyalur','');
        ini_set('max_execution_time', 300);

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('danakelola/akad', $data);
        $this->load->view('templates/footer', $data);
    }

    public function bayar()
    {
        $data['title'] = 'Pembayaran';
        $data['subtitle'] = 'Data Pembayaran Penyalur ke PIP';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $data['akad'] = $this->ws->fetchData('GET','report/pembayaranpenyalur','');
        ini_set('max_execution_time', 300);

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('danakelola/pembayaran', $data);
        $this->load->view('templates/footer', $data);
    }

}
