#!/usr/bin/perl -w

use lib ".";
use Data::Dump qw( dump );
use Data::Dumper;
use File::Spec;
use JSON;
use configs;
use POSIX qw( strftime );
use REST::Client;
use experimental qw( switch );
use strict;


my ($row, $sql, $sth, $sql1, $sth1, $i, );
configs->WriteLog('------------------------------------ STARTING DBH CONNECTION ----------------------------------------','');
my $dbh = configs->ConnectDB();

# PROCESSING PENYALUR
configs->WriteLog('PENYALUR','PROCESSING LIST PENYALUR');
my $penyalur = &updatePenyalur($dbh);

# PROCESSING AKAD PEMBIAYAAN
configs->WriteLog('AKAD PEMBIAYAAN','PROCESSING LIST AKAD PEMBIAYAAN');
my $pembiayaan = &updateAkad($dbh);

# PROCESSING TAGIHAN 
configs->WriteLog('TAGIHAN','PROCESSING LIST TAGIHAN');
my $tagihan = &updateTagihan($dbh);

# PROCESSING LIST DEBITUR 
configs->WriteLog('DEBITUR','PROCESSING LIST DEBITUR');
my $debitur = &updateDebitur($dbh);

# PROCESSING OVERVIEW 
configs->WriteLog('OVERVIEW','PROCESSING RESUME PENYALURAN');
my $overview = &updateOverview($dbh);

$dbh->disconnect;
configs->WriteLog('------------------------------------ DBH DISCONNECTED ----------------------------------------','');



#################################################
# SUB CLASS
#################################################
sub truncateTable
{
    my ($dbh, $table, $keterangan) = @_;
    my ($sql, $sth);
    configs->WriteLog($keterangan,'TRUNCATE TABLE '.$keterangan);

    $sql = "TRUNCATE TABLE ".$table;
    $sth = configs->ExecQuery($dbh, $sql);
    $sth->finish();

    return 1;
}

sub fetchDataUMi
{
	my ($path) = @_;
	my ($apiEndPoint, @rs);
    $apiEndPoint =  $var{ 'API_umi' } . '/' . $path;

	my $client = REST::Client->new();
    configs->WriteLog('ACCESS WEBSERVICE','GET: '. $apiEndPoint);
	$client->GET($apiEndPoint);
	if ( $client->responseCode() ne 200) {
		print STDOUT strftime("%Y-%m-%d %H:%M:%S", localtime) . " - RECEIVED ERROR: " . dump( $client->responseContent() ) . "\n";
		exit;
	}
    
	# process the result
	my $jsonResp = decode_json $client->responseContent();

	return $jsonResp;
}

sub updatePenyalur
{
    my($dbh) = @_;
    my ($row, $sql, $sth, $ts, $i);

    my $respPenyalur = &fetchDataUMi($var{ 'path_penyalur' });
    if (ref($respPenyalur) eq 'ARRAY'){
        &truncateTable($dbh, $var{'tblpenyalur'}, 'PENYALUR');
    } else {
        configs->WriteLog('PENYALUR','GAGAL MENGAMBIL DATA PENYALUR');
        exit;
    }

    $ts = time();
    $sql = "INSERT INTO ".$var{'tblmoddate'}." (id, debitur, akad, tagihan, overview, penyalur) VALUES ('". $ts ."', 0,0,0,0,1)";
    $sth = configs->ExecQuery($dbh, $sql);
    $sth->finish();
    $i = 1;

    configs->WriteLog('PENYALUR','START INSERT TABLE PENYALUR');
    foreach my $penyalur (@$respPenyalur) {
        $sql = "INSERT INTO ".$var{'tblpenyalur'}." (did, nama) VALUES ('".$penyalur->{'KODEBARU'}."','".$penyalur->{'PENYALUR'}."')";
        $sth = configs->ExecQuery($dbh, $sql);
        $sth->finish();
        $dbh->commit;
        $i++;
    }
    configs->WriteLog('PENYALUR','SUCCESS INSERT: '.($i-1).' DATA PENYALUR');

    return 1;
}

sub updateAkad
{
    my ($dbh) = @_;
    my ($row, $sql, $sth, $ts, $i);
    my ($duedate, $contractdate, @tempdate, $month, $year);
    
    my $respAkad = &fetchDataUMi($var{ 'path_akad' });
    if (ref($respAkad) eq 'ARRAY'){
        &truncateTable($dbh, $var{'tblpembiayaan'}, 'AKAD PEMBIAYAAN');
    } else {
        configs->WriteLog('AKAD PEMBIAYAAN','GAGAL MENGAMBIL DATA AKAD');
        exit;
    }

    $ts = time();
    $sql = "INSERT INTO ".$var{'tblmoddate'}." (id, debitur, akad, tagihan, overview, penyalur) VALUES ('". $ts ."', 0,1,0,0,0)";
    $sth = configs->ExecQuery($dbh, $sql);
    $sth->finish();
    $i = 1;

    configs->WriteLog('AKAD PEMBIAYAAN','START INSERT TABLE AKAD');
    foreach my $akad (@$respAkad) {
        # create DUE DATE akad 
        $contractdate = $akad->{'TGLAKAD'};
        @tempdate = split'-', $contractdate;
        $year = $tempdate[0];
        $month = $tempdate[1]+5;
        if ($month > 12){
            $month = $month - 12;
            $year += 1;
        } 
        $duedate = $year .'-'. $month .'-'. $tempdate[2] ;

        $sql  = "INSERT INTO ".$var{'tblpembiayaan'}."
                (`id`, `kodepenyalur`, `penyalur`, `tglakad`, `nilaiakad`, `target`, 
                `batchpencairan`, `tglpencairan`, `nilaipencairan`, `id_ts`) VALUES ";
        $sql .= "('".$i."','".$akad->{'KODEPENYALUR'}."','".$akad->{'PENYALUR'}."',
                    '".$contractdate."','".$akad->{'NILAIAKAD'}."','".$duedate."',
                    '".$akad->{'BATCH'}."','".$akad->{'TGLPENCAIRAN'}."','".$akad->{'NILAIPENCAIRAN'}."', '".$ts."')";
        $sth = configs->ExecQuery($dbh, $sql);
        $sth->finish();
        $dbh->commit;
        $i++;
    }
    configs->WriteLog('AKAD PEMBIAYAAN','SUCCESS INSERT: '.($i-1).' DATA AKAD PEMBIAYAAN');

    return 1;
}

sub updateTagihan
{
    my ($dbh) = @_;
    my ($row, $sql, $sth, $ts, $i);
    
    my $respTagihan = &fetchDataUMi($var{ 'path_tagihan' });
    if (ref($respTagihan) eq 'ARRAY'){
        $i = &truncateTable($dbh, $var{'tbltagihan'}, 'TAGIHAN');
    } else {
        configs->WriteLog('TAGIHAN','GAGAL MENGAMBIL DATA TAGIHAN');
        exit;
    }

    $ts = time();
    $sql = "INSERT INTO ".$var{'tblmoddate'}." (id, debitur, akad, tagihan, overview, penyalur) VALUES ('". $ts ."', 0,0,1,0,0)";
    $sth = configs->ExecQuery($dbh, $sql);
    $sth->finish();
    $i = 1;

    configs->WriteLog('TAGIHAN','START INSERT TABLE TAGIHAN');
    foreach my $tagihan (@$respTagihan) {
        $sql = "INSERT INTO ".$var{'tbltagihan'}." (`id`, `id_ts`, `penyalur`, `tglakad`, `batch`, 
                `tglpencairan`, `nilaipencairan`, `tgljthtempo`, `angsuranpokok`, 
                `angsuranbunga`, `totalangsuran`, `angsuranke`) VALUES 
                ('".$i."','".$ts."','".$tagihan->{'PENYALUR'}."','".$tagihan->{'TGLAKAD'}."','".$tagihan->{'BATCH'}."',
                '".$tagihan->{'TGLPENCAIRAN'}."','".$tagihan->{'NILAIPENCAIRAN'}."',
                '".$tagihan->{'JTHTEMPO'}."','".$tagihan->{'TAGIHAN_POKOK'}."','".$tagihan->{'TAGIHAN_BUNGA'}."','".$tagihan->{'TOTAL_ANGSURAN'}."','".$tagihan->{'ANGSURAN_KE'}."')";
        $sth = configs->ExecQuery($dbh, $sql);
        $sth->finish();
        $dbh->commit;
        $i++;
    }
    configs->WriteLog('TAGIHAN','SUCCESS INSERT: '.($i-1).' DATA TAGIHAN');

    return 1;
}

sub updateDebitur
{
    my ($dbh) = @_;
    my ($row, $sql, $sth, $ts, $i);
    my ($pendidikan,$pekerjaan, $kondisirumah, $alamat, $alamatusaha, $namadebitur);
    my $respDebitur = &fetchDataUMi($var{ 'path_noa' });

    if (ref($respDebitur) eq 'ARRAY'){
        $i = &truncateTable($dbh, $var{'tblpenyaluran'}, 'DEBITUR');
    } else {
        configs->WriteLog('DEBITUR','GAGAL MENGAMBIL DATA DEBITUR');
        exit;
    }

    $ts = time();
    $sql = "INSERT INTO ".$var{'tblmoddate'}." (id, debitur, akad, tagihan, overview, penyalur) VALUES ('". $ts ."', 1,0,0,0,0)";
    $sth = configs->ExecQuery($dbh, $sql);
    $sth->finish();
    $i = 1;

    configs->WriteLog('DEBITUR','START UPDATE TABLE DEBITUR');
    foreach my $debitur (@$respDebitur){
        
        given ($debitur->{'PENDIDIKAN'}){
            when(1)  {$pendidikan = "SD";}
            when(2)  {$pendidikan = "SMP";}
            when(3)  {$pendidikan = "SMU";}
            when(4)  {$pendidikan = "DIPLOMA";}
            when(5)  {$pendidikan = "SARJANA";}
            when(6)  {$pendidikan = "LAINNYA";}
        };

        given ($debitur->{'PEKERJAAN'}){
            when(1)  {$pekerjaan = "PNS";}
            when(2)  {$pekerjaan = "TNI/POLRI";}
            when(3)  {$pekerjaan = "PENSIUNAN/PURNAWIRAWAN";}
            when(4)  {$pekerjaan = "PROFESIONAL";}
            when(5)  {$pekerjaan = "KARYAWAN SWASTA";}
            when(6)  {$pekerjaan = "WIRASWASTA";}
            when(7)  {$pekerjaan = "PETANI";}
            when(8)  {$pekerjaan = "PEDAGANG";}
            when(9)  {$pekerjaan = "NELAYAN";}
            when(99)  {$pekerjaan = "LAINNYA";}
        };
                
        given ($debitur->{'KONDISIRUMAH'}){
            when(1)  {$kondisirumah = "LANTAI TANAH";}
            when(2)  {$kondisirumah = "LANTAI SEMEN";}
            when(3)  {$kondisirumah = "LANTAI KAYU";}
            when(4)  {$kondisirumah = "LANTAI KERAMIK";}
        };
        $namadebitur    = $debitur->{'NAMA'}  =~ s/\W//g;
        $alamatusaha    = $debitur->{'ALAMATUSAHA'} =~ s/\W//g;
        $alamat         = $debitur->{'ALAMAT'} =~ s/\W//g;
        $debitur->{'SEKTOR'}  =~ s/\W//g;

        $sql  = "INSERT IGNORE INTO ".$var{'tblpenyaluran'}." ( `id_ts`, `id`, `kodepenyalur`, `provinsi`, `kabkota`, `ts`, `tahun`, `bulan`, 
                    `nik`, `nama`, `birthdate`, `pendidikan`, `pekerjaan`, `alamat`, `kodewilayah`, 
                    `kodepos`, `npwp`, `mulaiusaha`, `alamatusaha`, `noizin`, `modal`, `jumlahpekerja`, 
                    `omset`, `nomorhp`, `kondisirumah`, `uraianagunan`, `jk`, `marriage`, `noakad`, `norekening`, 
                    `tanggalakad`, `tanggaljatuhtempo`, `nopenjaminan`, `nilaidijamin`, `sukubunga`, `nilaiakad`, 
                    `tglupload`, `tgldropping`, `sektor`, `skemakredit`, `outstanding`) VALUES 
                    ('".$ts."','".$debitur->{'ID'}."','".$debitur->{'KODEPENYALUR'}."','".$debitur->{'PROVINSI'}."','".$debitur->{'KABKOTA'}."',
                    '".$debitur->{'TS'}."','".$debitur->{'TAHUN'}."','".$debitur->{'BULAN'}."','".$debitur->{'NIK'}."','".$namadebitur."',
                    '".$debitur->{'BIRTHDATE'}."','".$pendidikan."','".$pekerjaan."','".$alamat."',
                    '".$debitur->{'KODEWILAYAH'}."','".$debitur->{'KODEPOS'}."','".$debitur->{'NPWP'}."','".$debitur->{'MULAIUSAHA'}."',
                    '".$alamatusaha."','".$debitur->{'NOIZIN'}."','".$debitur->{'MODAL'}."','".$debitur->{'JUMLAHPEKERJA'}."',
                    '".$debitur->{'OMSET'}."','".$debitur->{'NOMORHP'}."','".$kondisirumah."','".$debitur->{'URAIANAGUNAN'}."',
                    '".$debitur->{'JK'}."','".$debitur->{'MARRIAGE'}."','".$debitur->{'NOAKAD'}."','".$debitur->{'NOREKENING'}."',
                    '".$debitur->{'TANGGALAKAD'}."','".$debitur->{'TANGGALJATUHTEMPO'}."','".$debitur->{'NOPENJAMINAN'}."','".$debitur->{'NILAIDIJAMIN'}."',
                    '".$debitur->{'SUKUBUNGA'}."','".$debitur->{'NILAIAKAD'}."','".$debitur->{'TGLUPLOAD'}."','".$debitur->{'TGLDROPPING'}."',
                    '".$debitur->{'SEKTOR'}."','".$debitur->{'SKEMAKREDIT'}."','".$debitur->{'OUTSTANDING'}."')";
        $sth = configs->ExecQuery($dbh, $sql);
        $sth->finish();
        $dbh->commit;
        configs->WriteLog('SUCCESS INSERT: '.$debitur->{'ID'},'','');
        $i++;
    }
    configs->WriteLog('DEBITUR','SUCCESS UPDATE: '.($i-1).' DATA DEBITUR SAH');

    return 1;
}

sub oslPembiayaan
{
    my ($dbh) = @_;
    my ($row, $sql, $sth, $penyalur, $totbayar, $oslpembiayaan);
    my (%data);
    $sql = "SELECT B.did, A.angsuranke, A.totalangsuran, A.nilaipencairan FROM umi_tagihan A, umi_penyalur B WHERE A.penyalur = B.nama";
    $sth = configs->ExecQuery($dbh, $sql);
    while ($row = $sth->fetchrow_hashref()) {
        $penyalur       = $row->{'did'};
        $totbayar       = $row->{'angsuranke'} * $row->{'totalangsuran'};
        $oslpembiayaan  = $row->{'nilaipencairan'} - $totbayar;

        $data{$penyalur} = !defined($data{$penyalur}) ? 0 : ($data{$penyalur}+$oslpembiayaan) ; 
    }
    $sth->finish();
    return encode_json \%data;
}

sub updateOverview
{
    my ($dbh) = @_;
    my ($row, $sql, $sth, $ts, $i);
    
    $i = &truncateTable($dbh, $var{'tbloverview'}, 'OVERVIEW');

    configs->WriteLog('OVERVIEW','GENERATE RESUME OVERVIEW');

    $ts = time();
    $sql = "INSERT INTO ".$var{'tblmoddate'}." (id, debitur, akad, tagihan, overview, penyalur) VALUES ('". $ts ."', 0,0,0,1,0)";
    $sth = configs->ExecQuery($dbh, $sql);
    $sth->finish();

    configs->WriteLog('OVERVIEW','START INSERT TABLE OVERVIEW');
    $sql = "SELECT A.kodepenyalur, sum( A.totakad ) as totpembiayaan, B.totpencairan, C.totdebitur, C.totpenyaluran, D.oslpenyaluran
            FROM ( SELECT kodepenyalur, sum(nilaiakad) as totakad FROM umi_akad WHERE batchpencairan = 1 GROUP BY kodepenyalur)  A,
                 ( SELECT kodepenyalur , sum(nilaipencairan) as totpencairan FROM umi_akad GROUP BY kodepenyalur )  B, 
                 ( SELECT kodepenyalur, count(nik) as totdebitur, sum(nilaiakad) as totpenyaluran FROM umi_noa GROUP BY kodepenyalur ) C,
                 ( SELECT kodepenyalur, sum(outstanding) as oslpenyaluran FROM umi_noa WHERE tanggaljatuhtempo >= 'NOW()' GROUP BY kodepenyalur ) D
            WHERE A.kodepenyalur = B.kodepenyalur AND A.kodepenyalur = C.kodepenyalur AND C.kodepenyalur = A.kodepenyalur
            GROUP BY kodepenyalur";
    $sth = configs->ExecQuery($dbh, $sql);
    while ($row = $sth->fetchrow_hashref()) {
        $sql1  = "INSERT INTO ".$var{'tbloverview'}." (id_ts, kodepenyalur, totalpembiayaan, totaldebitur, totalpencairan, totalpenyaluran, oslpembiayaan, oslpenyaluran) 
                VALUES ('".$ts."','". $row->{'kodepenyalur'} ."','". $row->{'totpembiayaan'} ."','". $row->{'totdebitur'} ."','". $row->{'totpencairan'} ."','". $row->{'totpenyaluran'} ."',0,'". $row->{'oslpenyaluran'} ."')";
        $sth1 = configs->ExecQuery($dbh, $sql1);
        $sth1->finish();
        $dbh->commit;
        $i++;
    }
    $sth->finish();

    configs->WriteLog('OVERVIEW','UPDATE DATA OSL PEMBIAYAAN');
    my $oslpembiayaan = decode_json (&oslPembiayaan($dbh));

    foreach my $penyalur (keys %$oslpembiayaan){
        $sql  = " UPDATE ".$var{'tbloverview'}." SET oslpembiayaan = '".$oslpembiayaan->{$penyalur}."' 
                   WHERE kodepenyalur = '".$penyalur."'";
        $sth = configs->ExecQuery($dbh, $sql);
        $sth->finish();
        $dbh->commit;
    }

    configs->WriteLog('OVERVIEW','SUCCESS UPDATE: '.($i-1).' DATA OVERVIEW');

    return 1;
}