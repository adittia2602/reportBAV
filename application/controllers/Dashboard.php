<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('WS_mods', 'ws');
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        ini_set('max_execution_time', 300);

        // TABLE
        $data['overview'] = $this->ws->fetchData('GET','overview','');
        $data['umiallpartner'] = $this->ws->fetchData('GET','report/penyaluran/allpartner','');

        // PETA PENYALURAN 
        $datawilayah  = $this->ws->fetchData('GET','report/penyaluran/provinsi','');
        
        $code = new stdClass();
        foreach ($datawilayah as $key => $value)
        {
            $sum = new stdClass();
            foreach ($value as $key1 => $value1)
            {
                $sum->$key1 = $value1;
            }
            $code->$key = $sum;
        }
        $data['petapenyaluran'] = json_encode($code, false);  
       
        // PIE-CHART GENDER
        $gender = $this->ws->fetchData('GET','report/penyaluran/gender','');

        $dataset  = new StdClass;
        foreach($gender as $row) {
            $color[]      = $row["LABEL"] === "P" ? "PINK" : "BLUE";
            $sumdebtor[]  = $row["COUNT"];
            $labels[]     = $row["LABEL"];
        }

        $dataset->data =  (array) $sumdebtor;
        $dataset->backgroundColor =  (array) $color;
        $dataset->hoverBackgroundColor = 'lightgrey';

        $jk['datasets'][] = $dataset;
        $jk['labels'] = $labels;
        $data['umi_gender'] = json_encode( $jk, true);

       // PIE-CHART USIA
       $usia = $this->ws->fetchData('GET','report/penyaluran/age','');

       $dataset  = new StdClass;
       foreach($usia as $row) {
        //    $color1[] = '#' . substr(md5(mt_rand()), 0, 6);
           $sumdebtor1[]  = $row["DEBITUR"];
           $labels1[]     = $row["LABEL"];
       }

       $dataset->data =  (array) $sumdebtor1;
        $dataset->backgroundColor =   array("#464159", "#6c7b95","#6fb98f" ,"#8bbabb", "#c7f0db");
        $dataset->hoverBackgroundColor = 'lightgrey';

       $age['datasets'][] = $dataset;
       $age['labels'] = $labels1;
       $data['umi_age'] = json_encode( $age, true);

       // PIE-CHART NOMINAL PEMBIAYAAN
       $nominal = $this->ws->fetchData('GET','report/penyaluran/nominalpembiayaan','');

       $dataset  = new StdClass;
       foreach($nominal as $row) {
           $color2[] = '#' . substr(md5(mt_rand()), 0, 6);
           $sumdebtor2[]  = $row["DEBITUR"];
           $labels2[]     = $row["LABEL"];
       }

       $dataset->data =  (array) $sumdebtor2;
       $dataset->backgroundColor =   array("#f8b195", "#f67280","#c06c84" ,"#6c5b7b");
        $dataset->hoverBackgroundColor = 'lightgrey';

       $nom['datasets'][] = $dataset;
       $nom['labels'] = $labels2;
       $data['umi_nominal'] = json_encode( $nom, true);


        // LOAD VIEW
        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/dash_topbar', $data);
        $this->load->view('dashboard/index', $data);

    }
}
