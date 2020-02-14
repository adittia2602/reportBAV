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
        $this->load->model('Umi_mods', 'umi');
    }

    public function overview() 
    {
        $data['title'] = 'Overview';
        $data['subtitle'] = 'Report Penyaluran dan OSL UMi';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['time'] = $this->umi->lastupdate();
        
        $data['umi'] = $this->umi->penyalurandanOSL();

        ini_set('max_execution_time', 300);

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penyaluran/overview', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function wilayah() 
    {
        $data['title'] = 'Wilayah';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['time'] = $this->umi->lastupdate();
        
        $data['umi'] = $this->umi->penyaluranWilayah();
       
        ini_set('max_execution_time', 300);

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penyaluran/wilayah', $data);
        $this->load->view('templates/footer', $data);
    }

    public function listdebitur()
    {
        $data['penyalur'] = $this->umi->listPenyalur();

        $this->form_validation->set_rules('penyalur', 'Penyalur', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'List Debitur';
            $data['subtitle'] = 'Silahkan Pilih Penyalur';
            $data['bc'] = $this->modul->getBreadcrumb($data['title']);
            $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
            $data['time'] = $this->umi->lastupdate();

            $this->load->view('templates/header', $data); // untuk memanggil template header
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('penyaluran/listdebitur', $data);
            $this->load->view('templates/footer');
        } else {
            $idpenyalur = $this->input->post('penyalur');
            redirect('penyaluran/download/'.$idpenyalur);    
        }
    }

    public function download($idpenyalur)
    {
        $listdebtor = $this->umi->dataPenyaluran($idpenyalur);
        $penyalur = $this->db->get_where('umi_penyalur', ['did' => $idpenyalur])->row_array();
        $title = date('Y-m-d',strtotime('yesterday')). " Debitur UMi - " . $penyalur['nama'] ;

        require(FCPATH . 'assets/extra-libs/PHPExcel-1.8/Classes/PHPExcel.php');
        require(FCPATH . 'assets/extra-libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $object = new PHPExcel();

        $object->getProperties()->setTitle($title);
        $object->getProperties()->setCreator("Framework Indonesia");
        $object->getProperties()->setLastModifiedby("Framework Indonesia");

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1' ,'NO');
        $object->getActiveSheet()->setCellValue('B1' ,'NIK');
        $object->getActiveSheet()->setCellValue('C1' ,'NAMA');
        $object->getActiveSheet()->setCellValue('D1' ,'BIRTHDATE');
        $object->getActiveSheet()->setCellValue('E1' ,'PENDIDIKAN');
        $object->getActiveSheet()->setCellValue('F1' ,'PEKERJAAN');
        $object->getActiveSheet()->setCellValue('G1' ,'ALAMAT');
        $object->getActiveSheet()->setCellValue('H1' ,'PROVINSI');
        $object->getActiveSheet()->setCellValue('I1' ,'KABKOTA');
        $object->getActiveSheet()->setCellValue('J1' ,'NPWP');
        $object->getActiveSheet()->setCellValue('K1' ,'MULAIUSAHA');
        $object->getActiveSheet()->setCellValue('L1' ,'ALAMATUSAHA');
        $object->getActiveSheet()->setCellValue('M1' ,'NOIZIN');
        $object->getActiveSheet()->setCellValue('N1' ,'MODAL');
        $object->getActiveSheet()->setCellValue('O1' ,'JUMLAHPEKERJA');
        $object->getActiveSheet()->setCellValue('P1' ,'OMSET');
        $object->getActiveSheet()->setCellValue('Q1' ,'NOMORHP');
        $object->getActiveSheet()->setCellValue('R1' ,'KONDISIRUMAH');
        $object->getActiveSheet()->setCellValue('S1' ,'URAIANAGUNAN');
        $object->getActiveSheet()->setCellValue('T1' ,'JK');
        $object->getActiveSheet()->setCellValue('U1' ,'MARRIAGE');
        $object->getActiveSheet()->setCellValue('V1' ,'NOAKAD');
        $object->getActiveSheet()->setCellValue('W1' ,'NOREKENING');
        $object->getActiveSheet()->setCellValue('X1' ,'TANGGALAKAD');
        $object->getActiveSheet()->setCellValue('Y1' ,'TANGGALJATUHTEMPO');
        $object->getActiveSheet()->setCellValue('Z1' ,'SUKUBUNGA');
        $object->getActiveSheet()->setCellValue('AA1' ,'NILAIAKAD');
        $object->getActiveSheet()->setCellValue('AB1' ,'TGLUPLOAD');
        $object->getActiveSheet()->setCellValue('AC1' ,'TGLDROPPING');
        $object->getActiveSheet()->setCellValue('AD1' ,'SEKTOR');


        $baris = 2;
        $no = 1;

        foreach ($listdebtor as $item) {
            $object->getActiveSheet()->setCellValue('A' . $baris, $no);
            $object->getActiveSheet()->setCellValueExplicit('B' . $baris, $item['nik'], PHPExcel_Cell_DataType::TYPE_STRING);
            $object->getActiveSheet()->setCellValue('C' . $baris, $item['nama']);
            $object->getActiveSheet()->setCellValue('D' . $baris, $item['birthdate']);
            $object->getActiveSheet()->setCellValue('E' . $baris, $item['pendidikan']);
            $object->getActiveSheet()->setCellValue('F' . $baris, $item['pekerjaan']);
            $object->getActiveSheet()->setCellValue('G' . $baris, $item['alamat']);
            $object->getActiveSheet()->setCellValue('H' . $baris, $item['provinsi']);
            $object->getActiveSheet()->setCellValue('I' . $baris, $item['kabkota']);
            $object->getActiveSheet()->setCellValueExplicit('J' . $baris, $item['npwp'], PHPExcel_Cell_DataType::TYPE_STRING);
            $object->getActiveSheet()->setCellValue('K' . $baris, $item['mulaiusaha']);
            $object->getActiveSheet()->setCellValue('L' . $baris, $item['alamatusaha']);
            $object->getActiveSheet()->setCellValue('M' . $baris, $item['noizin']);
            $object->getActiveSheet()->setCellValue('N' . $baris, $item['modal']);
            $object->getActiveSheet()->setCellValue('O' . $baris, $item['jumlahpekerja']);
            $object->getActiveSheet()->setCellValue('P' . $baris, $item['omset']);
            $object->getActiveSheet()->setCellValueExplicit('Q' . $baris, $item['nomorhp'], PHPExcel_Cell_DataType::TYPE_STRING);
            $object->getActiveSheet()->setCellValue('R' . $baris, $item['kondisirumah']);
            $object->getActiveSheet()->setCellValue('S' . $baris, $item['uraianagunan']);
            $object->getActiveSheet()->setCellValue('T' . $baris, $item['jk']);
            $object->getActiveSheet()->setCellValue('U' . $baris, $item['marriage']);
            $object->getActiveSheet()->setCellValueExplicit('V' . $baris, $item['noakad'], PHPExcel_Cell_DataType::TYPE_STRING);
            $object->getActiveSheet()->setCellValueExplicit('W' . $baris, $item['norekening'], PHPExcel_Cell_DataType::TYPE_STRING);
            $object->getActiveSheet()->setCellValue('X' . $baris, $item['tanggalakad']);
            $object->getActiveSheet()->setCellValue('Y' . $baris, $item['tanggaljatuhtempo']);
            $object->getActiveSheet()->setCellValue('Z' . $baris, $item['sukubunga']);
            $object->getActiveSheet()->setCellValue('AA' . $baris, $item['nilaiakad']);
            $object->getActiveSheet()->setCellValue('AB' . $baris, $item['tglupload']);
            $object->getActiveSheet()->setCellValue('AC' . $baris, $item['tgldropping']);
            $object->getActiveSheet()->setCellValue('AD' . $baris, $item['sektor']);

            $baris++; $no++;
        }
        $filename = $title . '.xlsx';

        $object->getActiveSheet()->setTitle("Data Debitur");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        
        $writer->save('php://output');
        exit;
    }

}
