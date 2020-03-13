<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Umi_mods extends CI_Model
{
    public function lastupdate()
    {
        $query = "SELECT DATE(timestamp) as last_update
                    FROM umi_ts 
                    order by timestamp desc limit 1";
        return $this->db->query($query)->row_array();
    }
    
    public function listPenyalur()
    {
        $query = "SELECT did, nama FROM umi_penyalur";

        return $this->db->query($query)->result_array();
    }

    public function dashboard()
    {
        $data = new stdClass();
        $query = "SELECT count(`kodepenyalur`) as totalpenyalur, sum(`totaldebitur`) as debitur, sum(`totalpenyaluran`) as penyaluran, sum(`totalpencairan`) as pembiayaan FROM `umi_overview` WHERE 1";
        $overview = $this->db->query($query)->row_array();
        
        $data->totaldebitur = number_format($overview['debitur'],0, '', '.');
        $data->totalpenyaluran = number_format($overview['penyaluran'],0, '', '.');
        $data->totalpenyalur = number_format($overview['totalpenyalur'],0, '', '.');
        $data->totalpembiayaan = number_format($overview['pembiayaan'],0, '', '.');
        
        return $data;
    }
    
    public function overview()
    {
        $query = "SELECT B.nama as penyalur, A.* FROM umi_overview A, umi_penyalur B WHERE A.kodepenyalur = B.did";

        return $this->db->query($query)->result_array();
    }

    public function penyaluranProvinsi()
    {
        $data = new stdClass();
        $query = "SELECT provinsi, kodewilayah, COUNT(nik) as debitur, SUM(nilaiakad) as penyaluran FROM `umi_noa` GROUP BY 1 ORDER BY 2";
        $prov = $this->db->query($query)->result_array();

        foreach ( $prov as $result){
            $provinsi = $result['kodewilayah'];
            $data->$provinsi = new stdClass();
            $data->$provinsi->debitur = number_format($result['debitur'],0, '', '.');
            $data->$provinsi->penyaluran =  'Rp. '.number_format($result['penyaluran'],0, '', '.');
        }
        
        $result = json_encode($data);
        return $result;
    }

    public function penyaluranBulanan()
    {
        $query = "SELECT a.tahun, a.bulan, b.nama as penyalur, count(a.noakad) as totaldebitur, sum(nilaiakad) as totalpenyaluran
                  FROM umi_noa a, umi_penyalur b WHERE a.kodepenyalur = b.did GROUP BY 1, 2";

        return $this->db->query($query)->result_array();
    }

    public function duedateAkad()
    {

        $query = "  SELECT A.kodepenyalur, A.penyalur, 
                            A.tglakad , 
                            A.target AS tglexp, 
                            DATEDIFF(A.target, A.tglakad) AS duedate, 
                            DATEDIFF(CURDATE(), A.tglakad) AS curdate, 
                            A.nilaiakad AS totalpencairan 
                    FROM `umi_akad` A
                    WHERE A.tglakad = (SELECT MAX(tglakad) FROM umi_akad WHERE kodepenyalur = A.kodepenyalur)
                    GROUP BY kodepenyalur, tglakad ";
        $contract = $this->db->query($query)->result_array();
        
        
        foreach ($contract as $pembiayaan){
            $kdpenyalur = $pembiayaan['kodepenyalur'];
            $tglexp = $pembiayaan['tglexp'];
            $curdate = date('Y-m-d') ;
          
            
            if ($tglexp <  $curdate) {continue;};

            $query = " SELECT SUM(nilaiakad) AS totalpenyaluran FROM umi_noa WHERE kodepenyalur = '". $kdpenyalur ."' AND tanggalakad >= '". $pembiayaan['tglakad'] . "'" ;
            $disbursement = $this->db->query($query)->row_array();

            if( $pembiayaan['totalpencairan'] > $disbursement['totalpenyaluran'] ){
                $data[] = (object) array(
                    'kodepenyalur'    => $kdpenyalur,
                    'penyalur'        => $pembiayaan['penyalur'],
                    'tglakad'         => $pembiayaan['tglakad'],
                    'tglexp'          => $tglexp,
                    'duedate'         => $pembiayaan['duedate'],
                    'curdate'         => $pembiayaan['curdate'],
                    'totalpencairan'  => number_format($pembiayaan['totalpencairan'],0, '', '.'),
                    'totalpenyaluran' => number_format($disbursement['totalpenyaluran'],0, '', '.')
                );
            }
        }
        // print_r ($data);
        // die;
    
        return $data;
    }

    public function akadPembiayaan()
    {
        $query = "SELECT * FROM umi_akad";

        return $this->db->query($query)->result_array();
    }
    
    public function tagihanPembiayaan()
    {
        $query = "SELECT * FROM umi_tagihan ORDER BY tgljthtempo ASC";

        return $this->db->query($query)->result_array();
    }

    public function summaryPenyaluran()
    {
        $query = "SELECT count(*) as totaldebitur, sum(nilaiakad) as totalpenyaluran FROM umi_noa";

        return $this->db->query($query)->row_array();
    }

    public function dataPenyaluran($idpenyalur)
    {
        $query = "SELECT nik, nama, birthdate, pendidikan, pekerjaan, alamat, provinsi, kabkota, npwp, 
                         mulaiusaha, alamatusaha, noizin, modal, jumlahpekerja, omset,
                         nomorhp, kondisirumah, uraianagunan, jk, marriage, marriage,
                         noakad, norekening, tanggalakad, tanggaljatuhtempo,  
                         sukubunga, nilaiakad, tglupload, tgldropping, sektor
                  FROM umi_noa where kodepenyalur = $idpenyalur";
        // print_r($query);
        // print_r($this->db->query($query)->result_array());
        // die;

        return $this->db->query($query)->result_array();
    }

    public function penyaluranWilayah()
    {
        $query = "SELECT a.provinsi, a.kabkota, b.nama as penyalur, count(a.noakad) as totaldebitur, sum(nilaiakad) as totalpenyaluran
                  FROM umi_noa a, umi_penyalur b WHERE a.kodepenyalur = b.did GROUP BY 1, 2, 3";

        return $this->db->query($query)->result_array();
    }

    public function penyalurandanOSL()
    {
        $penyaluran = new StdClass();

        $query = "  SELECT B.nama, A.* FROM umi_overview A, umi_penyalur B WHERE A.kodepenyalur = B.did ";
        $contract = $this->db->query($query)->result_array();
        foreach ( $contract as $py ){  
            $data[] = (object) array(
                'penyalur' =>$py['nama'],
                'totaldebitur' => number_format($py['totaldebitur'],0, '', '.'),
                'totalpenyaluran'  => number_format($py['totalpenyaluran'],0, '', '.'),
                'totalpembiayaan' => number_format($py['totalpencairan'],0, '', '.'), 
                'ospenyaluran' => number_format($py['oslpenyaluran'],0, '', '.'),
                'ospembiayaan' => number_format($py['oslpembiayaan'],0, '', '.')
            );      
        }

      
     
        return $data;
    }

    public function cariNik($nik)
    {
        $query = "SELECT B.nama as penyalur, A.nik, A.nama,  A.birthdate, A.jk, A.marriage, A.nomorhp, A.alamat, A.provinsi, A.kabkota, 
                         A.noakad, A.norekening, A.tanggalakad, 
                         A.tanggaljatuhtempo, A.nilaiakad, A.sukubunga, A.tgldropping, A.tglupload, A.sektor, A.outstanding
                  FROM umi_noa A, umi_penyalur B WHERE A.kodepenyalur = B.did AND nik = '$nik'";

        $result = $this->db->query($query)->result_array();
        $data = new stdClass();

        foreach ($result as $r){
            $data->NIK              = $r['nik'];
            $data->NAMA             = $r['nama'];
            $data->TGLLAHIR         = $r['birthdate'];
            $data->JK               = $r['jk'];
            $data->STATUS           = $r['marriage'];
            $data->NOHP             = $r['nomorhp'];
            $data->ALAMAT           = $r['alamat'];
            $data->PROVINSI         = $r['provinsi'];
            $data->KABKOTA          = $r['kabkota'];
            $data->PEMBIAYAAN[]     = (object) array(
                                        'PENYALUR'      => $r['penyalur'],
                                        'NOAKAD'        => $r['noakad'],
                                        'NOREKENING'    => $r['norekening'],
                                        'TGLAKAD'       => $r['tanggalakad'],
                                        'TGLJTHTEMPO'   => $r['tanggaljatuhtempo'],
                                        'NILAIAKAD'     => $r['nilaiakad'],
                                        'BUNGA'         => $r['sukubunga'],
                                        'TGLDROPPING'   => $r['tgldropping'],
                                        'SEKTOR'        => $r['sektor'],
                                        'OUTSTANDING'   => $r['outstanding']
                                    );
        }

        // print_r($data);
        // die;
        return $data;
    }

    
}
