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
        $overview->totaldebitur = $penyaluran['totaldebitur'];
        $overview->totalpenyaluran = $penyaluran['totalpenyaluran'];
        $overview->totalpenyalur = $linkage['totalpenyalur'];
        $overview->totalpembiayaan = $pembiayaan['totalpencairan'];


        return $overview;
    }

    public function akadPembiayaan()
    {
        $query = "SELECT * FROM umi_akad";

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

    public function penyaluranBulanan()
    {
        $query = "SELECT a.ts, a.tahun, a.bulan, b.nama as penyalur, count(a.noakad) as totaldebitur, sum(nilaiakad) as totalpenyaluran
                  FROM umi_noa a, umi_penyalur b WHERE a.kodepenyalur = b.did GROUP BY 1, 2, 3";

        return $this->db->query($query)->result_array();
    }

}
