<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Umi_mods extends CI_Model
{

    public function listPenyalur()
    {
        $query = "SELECT did, nama FROM umi_penyalur";

        return $this->db->query($query)->result_array();
    }

    public function overview()
    {
        $query = "SELECT count(noakad) as totaldebitur, sum(nilaiakad) as totalpenyaluran FROM umi_noa";
        $penyaluran = $this->db->query($query)->row_array();

        $query1 = "SELECT count(*) as totalpenyalur FROM umi_penyalur";
        $linkage = $this->db->query($query1)->row_array();

        $query2 = "SELECT sum(nilaipencairan) as totalpencairan FROM umi_akad";
        $pembiayaan = $this->db->query($query2)->row_array();

        $overview = new StdClass();
        $overview->totaldebitur = number_format($penyaluran['totaldebitur'],0, '', '.');
        $overview->totalpenyaluran = number_format($penyaluran['totalpenyaluran'],0, '', '.');
        $overview->totalpenyalur = number_format($linkage['totalpenyalur'],0, '', '.');
        $overview->totalpembiayaan = number_format($pembiayaan['totalpencairan'],0, '', '.');


        return $overview;
    }

    public function penyaluranBulanan()
    {
        $query = "SELECT a.ts, a.tahun, a.bulan, b.nama as penyalur, count(a.noakad) as totaldebitur, sum(nilaiakad) as totalpenyaluran
                  FROM umi_noa a, umi_penyalur b WHERE a.kodepenyalur = b.did GROUP BY 1, 2, 3";

        return $this->db->query($query)->result_array();
    }

    public function duedateAkad()
        {
        $penyaluran = new StdClass();

        $query = "  SELECT 
                        kodepenyalur,
                        penyalur, 
                        MAX(tglakad) AS tglakad_, 
                        MAX(target) AS tglexp, 
                        DATEDIFF(MAX(target), MAX(tglakad)) AS duedate, 
                        DATEDIFF(CURDATE(), MAX(tglakad)) AS curdate, 
                        sum(nilaipencairan) AS totalpencairan 
                    FROM umi_akad
                    GROUP BY 1 
                    ORDER BY kodepenyalur ";
        $contract = $this->db->query($query)->result_array();
        

        // $query = " SELECT kodepenyalur, SUM(nilaiakad) AS totalpenyaluran FROM umi_noa GROUP BY 1 ";
        // $disbursement = $this->db->query($query)->result_array();
        // foreach ( $disbursement as $tp ){  
        //     $penyaluran->$tp['kodepenyalur'] = $tp['totalpenyaluran']; 
        // }
        
    
        foreach ($contract as $pembiayaan){
            $kdpenyalur = $pembiayaan['kodepenyalur'];

            $query = " SELECT SUM(nilaiakad) AS totalpenyaluran FROM umi_noa WHERE kodepenyalur = ". $kdpenyalur ." AND tglakad >= ". $pembiayaan['tglakad_'] ;
            $disbursement = $this->db->query($query);
            if( $pembiayaan['totalpencairan'] > $disbursement['totalpenyaluran'] ){
                $data[] = (object) array(
                    'kodepenyalur'    => $kdpenyalur,
                    'penyalur'        => $pembiayaan['penyalur'],
                    'tglakad'         => $pembiayaan['tglakad_'],
                    'tglexp'          => $pembiayaan['tglexp'],
                    'duedate'         => $pembiayaan['duedate'],
                    'curdate'         => $pembiayaan['curdate'],
                    'totalpencairan'  => number_format($pembiayaan['totalpencairan'],0, '', '.'),
                    'totalpenyaluran' => number_format($disbursement['totalpenyaluran'],0, '', '.')
                );
            }
        }
     
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
        $query = "SELECT count(noakad) as totaldebitur, sum(nilaiakad) as totalpenyaluran FROM umi_noa";

        return $this->db->query($query)->row_array();
    }

    public function dataPenyaluran($idpenyalur)
    {
        $query = "SELECT nik, nama, birthdate, pendidikan, pekerjaan, alamat, kodewilayah, kodepos, npwp, 
                         mulaiusaha, alamatusaha, noizin, modal, jumlahpekerja, omset,
                         nomorhp, kondisirumah, uraianagunan, jk, marriage, marriage,
                         noakad, norekening, tanggalakad, tanggaljatuhtempo,  
                         sukubunga, nilaiakad, tglupload, tgldropping, sektor
                  FROM umi_noa where kodepenyalur = $idpenyalur";

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

        $query = "  SELECT 
                        kodepenyalur,
                        penyalur, 
                        sum(nilaipencairan) AS totalpencairan 
                    FROM umi_akad
                    GROUP BY 1 
                    ORDER BY kodepenyalur ";
        $contract = $this->db->query($query)->result_array();
        foreach ( $contract as $tp ){  
            $pembiayaan[] = (object) array(
                'kodepenyalur'      => $tp['kodepenyalur'],
                'penyalur'          => $tp['penyalur'],
                'totalpencairan'      => $tp['totalpencairan'] 
            );
        }

        $query = " SELECT kodepenyalur, count(nik) AS totaldebitur, SUM(nilaiakad) AS totalpenyaluran, SUM(outstanding) AS ospenyaluran FROM umi_noa GROUP BY 1 ";
        $penyaluran = $this->db->query($query)->result_array();
        
    
        foreach ($penyaluran as $py) {
            foreach ($pembiayaan as $pb) {
                if ( $py['kodepenyalur'] == $pb->kodepenyalur ){
                    $data[] = (object) array(
                        'penyalur' =>$pb->penyalur,
                        'totaldebitur' => number_format($py['totaldebitur'],0, '', '.'),
                        'totalpenyaluran'  => number_format($py['totalpenyaluran'],0, '', '.'),
                        'totalpembiayaan' => number_format($pb->totalpencairan,0, '', '.'), 
                        'ospenyaluran' => number_format($py['ospenyaluran'],0, '', '.'),
                        'ospembiayaan' => number_format($pb->totalpencairan,0, '', '.')
                    );
                }
            }
        }
     
        return $data;
    }

    
}
