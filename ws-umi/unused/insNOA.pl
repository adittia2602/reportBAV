#!/usr/bin/perl -w

use lib ".";
use Data::Dump qw( dump );
use Data::Dumper;
use File::Spec;
use JSON;
use configs;
use POSIX qw( strftime );
use REST::Client;
use strict;


$| = 1;
my $workDir = File::Spec->rel2abs( File::Spec->curdir() );

# FIRST THING FIRST, don't forget to modify THIS field.
my $inFile  = File::Spec->catfile($workDir, 'bav2.txt');
my $outFile = File::Spec->catfile($workDir, 'result_bav1.txt');

# redirect output
close STDOUT;
open(STDOUT, '>', $outFile);
select STDOUT; $| = 1;

open(my $fh, '<', $inFile) || die "Can't open $inFile: $!\n";
my @contents = <$fh>;
close $fh;
# comment this line if you don't have header
# shift(@contents);

# create output file
open($fh, '>', $outFile) || die "Can't create $outFile: $!\n";
# print STDOUT "LINE;NIK;UPDATE;ERROR\n";
# close $fh;

# connect to Database
my ( $dbh, $row, $sql, $sth);		
$dbh = configs->ConnectDB();

# now we process each record
my (%contract, %rs);

AKADS:
foreach my $line (@contents)
{
	$line =~ s/\s+$//;
	my ($id_ts, $id, $kodepenyalur, $provinsi, $kabkota, 
		$ts, $tahun, $bulan, $nik, $nama, $birthdate, $pendidikan, 
		$pekerjaan, $alamat, $kodewilayah, $kodepos, $npwp, $mulaiusaha,
		$alamatusaha, $noizin, $modal, $jumlahpekerja, $omset, $nomorhp, 
		$kondisirumah, $uraianagunan, $jk, $marriage, $noakad, $norekening, 
		$tanggalakad, $tanggaljatuhtempo, $nopenjaminan, $nilaidijamin, $sukubunga, 
		$nilaiakad, $tglupload, $tgldropping, $sektor, $skemakredit, $outstanding ) = split ';', $line;


	$sql  = "INSERT IGNORE INTO `umi_noa` ";
	$sql .= "(  `id_ts`, `id`, `kodepenyalur`, `provinsi`, `kabkota`, `ts`, `tahun`, `bulan`, 
				`nik`, `nama`, `birthdate`, `pendidikan`, `pekerjaan`, `alamat`, `kodewilayah`, 
				`kodepos`, `npwp`, `mulaiusaha`, `alamatusaha`, `noizin`, `modal`, `jumlahpekerja`, 
				`omset`, `nomorhp`, `kondisirumah`, `uraianagunan`, `jk`, `marriage`, `noakad`, `norekening`, 
				`tanggalakad`, `tanggaljatuhtempo`, `nopenjaminan`, `nilaidijamin`, `sukubunga`, `nilaiakad`, 
				`tglupload`, `tgldropping`, `sektor`, `skemakredit`, `outstanding`) VALUES ";
	$sql .= "(  '".$id_ts."', '".$id."', '".$kodepenyalur."', '".$provinsi."', '".$kabkota."', 
				'".$ts."', '".$tahun."', '".$bulan."', '".$nik."', '".$nama."', '".$birthdate."', 
				'".$pendidikan."', '".$pekerjaan."', '".$alamat."', '".$kodewilayah."', '".$kodepos."', 
				'".$npwp."', '".$mulaiusaha."', '".$alamatusaha."', '".$noizin."', '".$modal."', 
				'".$jumlahpekerja."', '".$omset."', '".$nomorhp."', '".$kondisirumah."', '".$uraianagunan."', 
				'".$jk."', '".$marriage."', '".$noakad."', '".$norekening."', '".$tanggalakad."', 
				'".$tanggaljatuhtempo."', '".$nopenjaminan."', '".$nilaidijamin."', '".$sukubunga."', 
				'".$nilaiakad."', '".$tglupload."', '".$tgldropping."', '".$sektor."', '".$skemakredit."', 
				'".$outstanding."') ";

	$sth = configs->ExecQuery($dbh, $sql);
	$sth->finish();
	if ($sth){
		print STDOUT "$id berhasil diinput!\n";
	}
	else {
		print STDOUT "$id GAGAL\n";
	}
	$dbh->commit;
    
}

$dbh->disconnect;
close $fh;
