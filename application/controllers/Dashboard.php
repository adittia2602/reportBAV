<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');
        $this->load->model('WS_mods', 'ws');
        $this->load->model('Umi_mods', 'umi');
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['time'] = $this->umi->lastupdate();
        ini_set('max_execution_time', 300);

        // GET DATA
        $data['reminder'] = $this->umi->duedateAkad();
        $data['penyaluran'] = $this->umi->overview();

        $totpenyalur = $totdebitur = $totpenyaluran = $totpembiayaan = 0;
        $data['overview'] = new stdClass();
        foreach ($data['penyaluran'] as $r){
            $totpenyalur += 1;
            $totdebitur += $r['totaldebitur'];
            $totpenyaluran += $r['totalpenyaluran'];
            $totpembiayaan += $r['totalpembiayaan'];
        }
        $data['overview']->totaldebitur = number_format($totdebitur,0, '', '.');
        $data['overview']->totalpenyaluran = number_format($totpenyaluran,0, '', '.');
        $data['overview']->totalpenyalur = number_format($totpenyalur,0, '', '.');
        $data['overview']->totalpembiayaan = number_format($totpembiayaan,0, '', '.');
        
        $bulanan = $this->umi->penyaluranBulanan();


        // BAR-CHART DEBITUR & PENYALURAN
        $dataset  = new StdClass;
        foreach($bulanan as $row) {
            $debtor[]    = $row["totaldebitur"];
            $disburse[]  = $row["totalpenyaluran"];
            $bulan[]     = $row["bulan"];

            $mstdbt[] = (object) array(
                'bulan'     => $row["bulan"] . " / " . $row["tahun"],
                'debitur'   => number_format($row["totaldebitur"],0, '', '.') . " Debitur"
            );

            $mstpnyl[] = (object) array(
                'bulan'      => $row["bulan"]. " / " . $row["tahun"],
                'penyaluran' => "Rp. ". number_format($row["totalpenyaluran"],0, '', '.')
            );
            
        }
        $dataset->backgroundColor =  'darkblue';

        // DATA CHART DEBITUR
        $dataset->label =  "TOTAL DEBITUR";
        $dataset->data =  array_slice($debtor,count($debtor)-6);

        $debitur['datasets'][] = $dataset;
        $debitur['labels'] = array_slice($bulan,count($bulan)-6);
        $data['overall_debitur'] = json_encode( $debitur, true);
        $data['master_debitur']  = array_slice($mstdbt, count($mstdbt)-6);
        

        // DATA CHART PENYALURAN
        $dataset->label =  "TOTAL PENYALURAN";
        $dataset->data =  array_slice($disburse,count($disburse)-6);

        $penyaluran['datasets'][] = $dataset;
        $penyaluran['labels'] = array_slice($bulan,count($bulan)-6);
        $data['overall_penyaluran'] = json_encode( $penyaluran, true);
        $data['master_penyaluran']  = array_slice($mstpnyl, count($mstpnyl)-6);
        
        


        // LOAD VIEW
        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/index', $data);

    }
}
