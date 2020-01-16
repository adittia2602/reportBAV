<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyaluran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');
        $this->load->model('WS_mods', 'ws');
    }

    public function overview() 
    {
        $data['title'] = 'Overview';
        $data['subtitle'] = 'Report Penyaluran dan OSL UMi';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        
        $cod = $this->input->post('cod');   
        
        if ( isset($cod) ){
            $data['umi'] = $this->ws->fetchData('GET','bav/penyaluran/'.$cod,'');
            $data['cod'] = $cod;
        } 
        else {
            $data['umi'] = $this->ws->fetchData('GET','bav/penyaluran/','');
            $data['cod'] = date("Y-m-d"); 
        }
        ini_set('max_execution_time', 300);

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penyaluran/overview', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function penyalur()
    {
        $data['penyalur'] = $this->ws->fetchData('GET','bav/listlinkage','');

        $this->form_validation->set_rules('penyalur', 'Penyalur', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Penyalur';
            $data['subtitle'] = 'Silahkan Pilih Penyalur';
            $data['bc'] = $this->modul->getBreadcrumb($data['title']);
            $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

            $this->load->view('templates/header', $data); // untuk memanggil template header
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('penyaluran/penyalur', $data);
            $this->load->view('templates/footer');
        } else {
            $idpenyalur = $this->input->post('penyalur');
            redirect('penyaluran/profilpenyalur/'.$idpenyalur);
        }
    }

    public function profilpenyalur( $idpenyalur )
    {
        $data['title'] = 'Penyalur';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $penyalurs = $this->ws->fetchData('GET','penyalur','');

        foreach ( $penyalurs as $p ){
            if ($p['KODEBARU'] ===  $idpenyalur){
                $penyalur = $p['PENYALUR'];
                $kodelama = $p['KODELAMA'];
                $kodebaru = $idpenyalur;
                break;
            }
            else { continue; }
        }

        $formdata = [
            'penyalur' => $penyalur,
            'kodelama' => $kodelama,
            'kodebaru' => $kodebaru
        ];
        $data['profil'] = $this->ws->fetchData('POST','profilpenyalur',$formdata);
        ini_set('max_execution_time', 500);

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penyaluran/profilpenyalur', $data);
        $this->load->view('templates/footer');
    }

    public function bulanan()
    {
        $data['title'] = 'Bulanan';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $data['umi'] = $this->ws->fetchData('GET','report/penyaluran','');
        ini_set('max_execution_time', 300);

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penyaluran/bulanan', $data);
        $this->load->view('templates/footer', $data);
    }

}
