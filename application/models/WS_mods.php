<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WS_mods extends CI_Model
{
    public function baseUrlApi() {
        $url = 'http://localhost:5000/bav/';

        return $url;
    }

    public function fetchData( $method, $path, $data ) {
        $url = $this->baseUrlApi() . $path;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ( $method == "GET" ) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        elseif ( $method == "POST" ) {
            $formdata = json_encode($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json" ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
        }

        $feedback = curl_exec($ch);
        ini_set('max_execution_time', 1000000000);

        curl_close($ch);

        $results = $feedback ? json_decode($feedback, true) : "Kesalahan koneksi Web Services.";

        return $results;
    }

    public function updatePenyalur()
    {
        $dataFetch = $this->fetchData('GET','listlinkage','');
        
        foreach ($dataFetch as $item){
            $penyalur = [
                'did' => $item['KODEBARU'],
                'nama' => $item['PENYALUR'],
            ];
            $batchpenyalur[] = $penyalur;
        }

        $this->db->update_batch('umi_penyalur', $batchpenyalur, 'did');


        if ( $this->db->affected_rows() > 0 ){
            $result['message'] = "Data Penyalur berhasil di insert!";
        } else {
            $result = $this->db->error(); 
        }
        
        
        return $result['message'] ;
    }

    public function updateDebitur()
    {
        // create parent
        $ts = time();
        $parent = [
            'debitur' => TRUE,
            'overview' => FALSE,
            'id' => $ts,
            'akad' => FALSE, 
            'tagihan' => FALSE 
        ];
        $this->db->insert('umi_ts', $parent);

        // update data Debitur
        $dataFetch = $this->fetchData('GET','listdebtor','');
        foreach ($dataFetch as $item){

            switch ($item['PENDIDIKAN']) {
                case "1" :  $pendidikan = "SD";
                            break;
                case "2" :  $pendidikan = "SMP";
                            break;
                case "3" :  $pendidikan = "SMU";
                            break;
                case "4" :  $pendidikan = "DIPLOMA";
                            break;
                case "5" :  $pendidikan = "SARJANA";
                            break;
                case "6" :  $pendidikan = "LAINNYA";
                            break;                
            }

            switch ($item['PEKERJAAN']) {
                case "1" :  $pekerjaan = "PNS";
                            break;
                case "2" :  $pekerjaan = "TNI/POLRI";
                            break;
                case "3" :  $pekerjaan = "PENSIUNAN/PURNAWIRAWAN";
                            break;
                case "4" :  $pekerjaan = "PROFESIONAL";
                            break;
                case "5" :  $pekerjaan = "KARYAWAN SWASTA";
                            break;
                case "6" :  $pekerjaan = "WIRASWASTA";
                            break;  
                case "7" :  $pekerjaan = "PETANI";
                            break;                
                case "8" :  $pekerjaan = "PEDAGANG";
                            break;                
                case "9" :  $pekerjaan = "NELAYAN";
                            break;                
                case "99" :  $pekerjaan = "LAINNYA";
                             break;              
            }
            
            switch ($item['KONDISIRUMAH']) {
                case "1" :  $kondisirumah = "LANTAI TANAH";
                            break;
                case "2" :  $kondisirumah = "LANTAI SEMEN";
                            break;
                case "3" :  $kondisirumah = "LANTAI KAYU";
                            break;
                case "4" :  $kondisirumah = "LANTAI KERAMIK";
                            break;
            }

            $noa = [
                'id_ts'         =>  $ts,
                'id'            =>  $item['ID'],
                'kodepenyalur'	=>	$item['KODEPENYALUR'],
                'provinsi'	    =>	$item['PROVINSI'],
                'kabkota'	    =>	$item['KABKOTA'],
                'ts'	        =>	$item['TS'],
                'tahun'	        =>	$item['TAHUN'],
                'bulan'	        =>	$item['BULAN'],
                'nik'	        =>	$item['NIK'],
                'nama'	        =>	$item['NAMA'],
                'birthdate'	    =>	$item['BIRTHDATE'],
                'pendidikan'	=>	$pendidikan,
                'pekerjaan'	    =>	$pekerjaan,
                'alamat'	    =>	$item['ALAMAT'],
                'kodewilayah'	=>	$item['KODEWILAYAH'],
                'kodepos'	    =>	$item['KODEPOS'],
                'npwp'	        =>	$item['NPWP'],
                'mulaiusaha'	=>	$item['MULAIUSAHA'],
                'alamatusaha'	=>	$item['ALAMATUSAHA'],
                'noizin'	    =>	$item['NOIZIN'],
                'modal'	        =>	$item['MODAL'],
                'jumlahpekerja'	=>	$item['JUMLAHPEKERJA'],
                'omset'	        =>	$item['OMSET'],
                'nomorhp'	    =>	$item['NOMORHP'],
                'kondisirumah'	=>	$kondisirumah,
                'uraianagunan'	=>	$item['URAIANAGUNAN'],
                'jk'	        =>	$item['JK'],
                'marriage'	    =>	$item['MARRIAGE'],
                'noakad'	    =>	$item['NOAKAD'],
                'norekening'	=>	$item['NOREKENING'],
                'tanggalakad'	=>	$item['TANGGALAKAD'],
                'tanggaljatuhtempo'	=>	$item['TANGGALJATUHTEMPO'],
                'nopenjaminan'	=>	$item['NOPENJAMINAN'],
                'nilaidijamin'	=>	$item['NILAIDIJAMIN'],
                'sukubunga'	    =>	$item['SUKUBUNGA'],
                'nilaiakad'	    =>	$item['NILAIAKAD'],
                'tglupload'	    =>	$item['TGLUPLOAD'],
                'tgldropping'	=>	$item['TGLDROPPING'],
                'sektor'	    =>	$item['SEKTOR'],
                'skemakredit'   =>	$item['SKEMAKREDIT']

            ];

            $insert_query = $this->db->insert_string('umi_noa', $noa);
            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
            $this->db->query($insert_query);

        }

        // $updateos = $this->updateOSdebitur();
        $updateos = "NOT";


        if ( $updateos == 'updated' && $this->db->affected_rows() > 0 ){
            $result = "Data Noa & Update Outstanding berhasil di insert!";
        } elseif ( $updateos != 'updated' && $this->db->affected_rows() > 0 ){
            $result = "Data Noa berhasil di insert! dan Error update OS : ". $updateos ;
        } else {
            $err = $this->db->error(); 
            $result = $err['message'];
        }
        
        return $result ;
    }

    public function updateOSdebitur()
    {
 
        // update data OS Debitur
        $dataFetch = $this->fetchData('GET','osdebtor','');
        foreach ($dataFetch as $item){
            $os = [
                'outstanding' => $item['OUTSTANDING'],
            ];

            $this->db->where('id', $item['ID']);
            $result=$this->db->update('umi_noa', $os);
        }

        if ( $this->db->affected_rows() > 0 ){
            $result = "updated";
        } else {
           $err = $this->db->error(); 
            $result = $err['message'];
        }
        
        return $result ;
    }

    public function updateAkadpembiayaan()
    {
        // create parent
        $ts = time();
        $parent = [
            'debitur' => FALSE,
            'overview' => FALSE,
            'id' => $ts,
            'akad' => TRUE, 
            'tagihan' => FALSE 
        ];
        $this->db->insert('umi_ts', $parent);


        $dataFetch = $this->fetchData('GET','akadpenyalur','');
        foreach ($dataFetch as $item) {
            $effectiveDate = date('Y-m-d', strtotime("+5 months", strtotime($item['TGLAKAD'])));
            $akad = [
                'kodepenyalur' => $item['KODEPENYALUR'],
                'penyalur' => $item['PENYALUR'],
                'tglakad' => $item['TGLAKAD'],
                'nilaiakad' => $item['NILAIAKAD'],
                'batchpencairan' => $item['BATCH'],
                'tglpencairan' => $item['TGLPENCAIRAN'],
                'nilaipencairan' => $item['NILAIPENCAIRAN'],
                'id_ts' => $ts,
                'target' => $effectiveDate,
            ];

            $insert_query = $this->db->insert_string('umi_akad', $akad);
            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
            $this->db->query($insert_query);
        }

        if ( $this->db->affected_rows() > 0 ){
            $result['message'] = "Data Akad Pembiayaan berhasil di insert!";
        } else {
            $result = $this->db->error(); 
        }
        
        return $result['message'] ;
    }
}
