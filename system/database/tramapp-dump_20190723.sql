-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jul 2019 pada 05.56
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tramapp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_kategori`
--

CREATE TABLE `tr_kategori` (
  `kodekategori` varchar(5) NOT NULL,
  `namakategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_kategori`
--

INSERT INTO `tr_kategori` (`kodekategori`, `namakategori`) VALUES
('ASM', 'Asset Management'),
('MGR', 'Managerial'),
('PDN', 'Pendampingan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_lembaga`
--

CREATE TABLE `tr_lembaga` (
  `kodelembaga` varchar(5) NOT NULL,
  `namalembaga` varchar(50) NOT NULL,
  `namapejabat` varchar(30) NOT NULL,
  `jabatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_lembaga`
--

INSERT INTO `tr_lembaga` (`kodelembaga`, `namalembaga`, `namapejabat`, `jabatan`) VALUES
('ILO', 'International Labour Organization', 'Owais Parray ', 'Kepala Penasehat Teknis'),
('PIP', 'Pusat Investasi Pemerintah', 'Djoko Hendratto', 'Plt. Direktur Utama'),
('TAN', 'Kementerian Pertanian', 'Who Am I', 'Direktur LKMA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_pelatihan`
--

CREATE TABLE `tr_pelatihan` (
  `idpelatihan` int(11) NOT NULL,
  `kodepelatihan` varchar(15) NOT NULL,
  `namapelatihan` varchar(50) NOT NULL,
  `batch` varchar(2) NOT NULL,
  `kodekategori` varchar(5) NOT NULL,
  `tglmulai` date NOT NULL,
  `tglselesai` date NOT NULL,
  `tempat` varchar(50) NOT NULL,
  `kodelembaga` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_pelatihan`
--

INSERT INTO `tr_pelatihan` (`idpelatihan`, `kodepelatihan`, `namapelatihan`, `batch`, `kodekategori`, `tglmulai`, `tglselesai`, `tempat`, `kodelembaga`) VALUES
(1, 'MMW-01-ILO', 'Making Microfinance Work', '01', '', '2018-11-11', '2018-11-22', 'Bogor', 'ILO'),
(2, 'SIYB-01-ILO', 'Start and Improve Your Busines', '01', '', '2018-11-11', '2018-11-22', 'Bogor', 'ILO'),
(3, 'MMW-02-ILO', 'Making Microfinance Work', '02', '', '2018-01-13', '2018-01-26', 'Yogyakarta', 'ILO'),
(4, 'SIYB-02-ILO', 'Start and Improve Your Busines', '02', '', '2018-01-13', '2018-01-26', 'Yogyakarta', 'ILO');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_peserta`
--

CREATE TABLE `tr_peserta` (
  `nik` varchar(16) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgllahir` date NOT NULL,
  `jeniskelamin` int(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `pendidikan` varchar(10) NOT NULL,
  `foto` text NOT NULL,
  `penyalur` varchar(10) NOT NULL,
  `cabangpenyalur` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `recdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_peserta`
--

INSERT INTO `tr_peserta` (`nik`, `nama`, `tgllahir`, `jeniskelamin`, `email`, `nohp`, `pendidikan`, `foto`, `penyalur`, `cabangpenyalur`, `jabatan`, `recdate`) VALUES
('1807050507860005', 'MUHAMAD ARIF SETYAWAN', '1986-07-05', 1, 'eniarif5786@gmail.com', '082178013535', '', 'https://drive.google.com/open?id=1ZH4Y0tiMOgHufLiHznGTNoy6Z90E8Wbt', '010012', 'KANTOR PUSAT', 'DEPUTY GENERAL MANAGER', '0000-00-00 00:00:00'),
('1871022006770008', 'SUMARNA', '1977-06-20', 1, 'sumarna.seo@gmail.com', '085366254823', '', 'https://drive.google.com/open?id=1QS8qV5PCyiOg03keMWaGD4itz3UFxGa9', '010013', 'KANTOR PUSAT', 'KABAG IT', '0000-00-00 00:00:00'),
('2307151201930001', 'ROHMAT JIONO', '2019-12-01', 1, 'rohmatjiono@gmail.com', '085726169296', '', 'https://drive.google.com/open?id=1pXNcsIttWOGVvTKGYOHfb32g8BAGBcwG', '010017', 'RANDUSARI WONOSOBO', 'MANAGER CABANG', '0000-00-00 00:00:00'),
('3207113008880001', 'AGUS SUTRISNA WIJAYA', '1988-08-30', 1, 'wijayaagus533@gmail.com', '081573850608', '', 'https://drive.google.com/open?id=1agm2Iz8l4ZHc4EVejntDsCMx6aIT_ABu', '010009', 'SOREANG', 'BRANCH MANAGER', '0000-00-00 00:00:00'),
('3211061301820001', 'TOTO RIANTO', '1982-01-13', 1, 'smdtotorianto82@gmail.com', '082315810701', '', 'https://drive.google.com/open?id=1cFsi2C42Qei1X0CKiGzLUcDliznT0AJP', '010008', 'PUSAT', 'AO', '0000-00-00 00:00:00'),
('3211064110820008', 'AHMAD YANI, S. E', '1982-10-01', 1, 'ayani8304@gmail.com ', '082318368902', '', 'https://drive.google.com/open?id=1bScafvP63av-wktmYAY-zOqmQHj41jEt', '010008', 'BMT  AL AMANAH SUMEDANG  CAB TASIKMALAYA ', 'KEPALA CABANG', '0000-00-00 00:00:00'),
('3271061003900013', 'FAIZ RASYID HENDRAWAN', '1990-03-10', 1, 'Faizrasyidh@gmail.com', '082112537251', '', 'https://drive.google.com/open?id=1YV-4e7HQ82WiOngZnt5PAYfoDTedPMg7', '0', 'JAKARTA', 'KADIV', '0000-00-00 00:00:00'),
('3273121501970004', 'TRISNA RANGGA SUNJANI ', '1997-01-15', 2, 'Trisnasujani@gmail.com ', '085352802240', '', 'https://drive.google.com/open?id=1dEHpM-ky-gAv9rWr_W217FyuUAWuj_5I', '010009', 'LELES ', 'PLT BRANCH MANAGER ', '0000-00-00 00:00:00'),
('3273206509950002', 'EKA NURYANTHI, S.H. ', '1995-09-25', 1, 'ekanuryanthi95@gmail.com', '08986921015', '', 'https://drive.google.com/open?id=1BGoCODqkU25uiZtT7lMoapEsieYKGIO2', '010009', 'PADASUKA , BANDUNG', 'BRANCH MANAGER', '0000-00-00 00:00:00'),
('3301064710870005', 'NAELI INAYAH', '1987-07-10', 2, 'naeliinayah07@gmail.com', '082136573777', '', 'https://drive.google.com/open?id=13OMC1Gt4IIVKqsojqIReprLMPB58reFJ', '010014', 'KROYA', 'AO', '0000-00-00 00:00:00'),
('3304050406740002', 'BUDI WAHYUONO, SE', '1974-06-04', 1, 'titahmercopodo@gmail.com', '08121598167', '', 'https://drive.google.com/open?id=12YH2MgMw6__-BKdASZJHRwBYtMq85a2c', '010006', 'WONOSOBO', 'MANAJER CABANG', '0000-00-00 00:00:00'),
('3304052812780004', 'AHMAD BAEHAQI, SE', '1978-12-28', 1, 'haqimelati@gmail.com', '082136941505', '', 'https://drive.google.com/open?id=1CfqYK_Y864_a_oN38rszr_kqqIKU3jB8', '010017', 'BANJARNEGARA', 'MANAJER CABANG', '0000-00-00 00:00:00'),
('3307024404800002', 'ENDANG PALUPI,SE', '1980-04-04', 1, 'Palupi.nayaep@gmail.com', '085743382860', '', 'https://drive.google.com/open?id=19GhGhN6CyT4OcXuYdmkZnO36qVyZdudo', '010017', 'SAPURAN', 'MANAJER CABANG', '0000-00-00 00:00:00'),
('3307042008850003', 'AGUS MUTHOLIB, S.KOM', '1985-08-20', 1, 'agusalhuda@gmail.com', '085227002738', '', 'https://drive.google.com/open?id=1yu2WWn13u_me1M9q4e_DBVBKQsJZhnNj', '010015', 'KSPPS BMT AL HUDA AREA WONOSOBO', 'MANAGER MARKETING AREA WONOSOBO', '0000-00-00 00:00:00'),
('3307071904800002', 'MOKHAMAD MUJIYANTO', '1980-04-19', 1, 'mgee.mirza14@gmail.com', '085878678064', '', 'https://drive.google.com/open?id=1TaJhfQOlxwKlG77W9UbjAUtbDxLakA1E', '010006', 'RECO', 'AO', '0000-00-00 00:00:00'),
('3307080308760002', 'BUDI SUTRISNO', '1976-03-08', 1, 'budigazebos@gmail.com', '081327181125', '', 'https://drive.google.com/open?id=1-UpQyjzqBT0KMfwe-_YYq_QvJ7xRy6Mq', '010006', 'UTAMA', 'MANAJER CABANG', '0000-00-00 00:00:00'),
('3307082806910004', 'HASYIM ALWI', '1991-06-28', 1, 'Hasyimgandhi@gmail.com', '085743455227', '', 'https://drive.google.com/open?id=136qUXJxTa-vG7rmTz1aISnWCFbRiBouQ', '010017', 'KERTEK', 'AO', '0000-00-00 00:00:00'),
('3307090208760001', 'AGUS TRINUGROHO', '1976-08-02', 1, 'agustrinugroho01@gmail.com', '081327038447', '', 'https://drive.google.com/open?id=1zldtfVrzzHayWoBfVCX_ijcEEmVvAFC_', '010006', 'SUKOHARJO WONOSOBO', 'MANAGER CABANG', '0000-00-00 00:00:00'),
('3307090501800005', 'SUMEDI', '1980-01-05', 1, 'meidyalhuda2018@gmail.com', '085291488175', '', 'https://drive.google.com/open?id=1okPIqZh7m4k8Ac-MwimJsUrTZL5exZbq', '010015', 'PUSAT', 'MANAJER MARKETING AREA', '0000-00-00 00:00:00'),
('3307091104890001', 'EKO SANDI SULISTIONO', '2019-04-11', 1, 'sandisulistionoeko@gmail.com', '081227168937', '', 'https://drive.google.com/open?id=1hb9RUvELAvf_EgCG2hrQsrBTJudGYTq8', '010006', 'KALIBAWANG WONOSOBO', 'AO', '0000-00-00 00:00:00'),
('3307091504870004', 'HUSEN AGUNG SETIAWAN', '1987-04-15', 1, 'ajunk.husen@gmail.com', '085228154553', '', 'https://drive.google.com/open?id=1kDlYoWxrmONc63XeAxsE2JUL8mZgvrtC', '010006', 'BALEKAMBANG', 'AO', '0000-00-00 00:00:00'),
('3307092306840001', 'FAISAL ARNAS', '1984-06-23', 1, 'faey_77@yahoo.co.id /faeyza7777@gmail.com', '085293234777', '', 'https://drive.google.com/open?id=11JuRtlVOYTSCUXjrkIvuZB-nLHuXnpFH', '010014', 'TAMZIS CABANG KERTEK', 'MANAGER MARKETING CABANG', '0000-00-00 00:00:00'),
('3307120507920001', 'SURAHMAN', '1992-05-07', 1, 'soerahman92@gmail.com', '085741919280', '', 'https://drive.google.com/open?id=1J340D34B9D_EEsBJ9DZUYlXcUKeG76vz', '010007', 'WONOSOBO', 'AO', '0000-00-00 00:00:00'),
('3307122000061985', 'SUGENG RIYADI', '1985-06-20', 1, 'sugeng.ryd85@gmail.com', '085227931192', '', 'https://drive.google.com/open?id=1Aj97pu7EVWcu-FuxewJFwH7A5X-ok1bd', '010007', 'MLANDI', 'ACCAUNT OFFICE', '0000-00-00 00:00:00'),
('3307123107890002', 'AGUS PRAYOGA AKHMAD', '1989-07-31', 1, 'agusprayoga557@gmail.com', '082370761534', '', 'https://drive.google.com/open?id=18ns0BbNf8RzrF7yZwxoLF-75YiL1Ca8P', '010015', 'AREA BANJAR', 'MMA', '0000-00-00 00:00:00'),
('3309142402919001', 'AWWALUL FAHMI', '1991-02-24', 2, 'ksppsbmtnuskaranggede@gmail.com', '085325209466', '', 'https://drive.google.com/open?id=1eqHAbe__nmLsR3kNGicnOS6w31MEWzYJ', '010002', 'KSPPS NUS KARANGGEDE', 'MANAGER', '0000-00-00 00:00:00'),
('3313112805810001', 'ENDRO SUSILO', '1981-05-28', 1, 'endrosusilobmtnus@gmail.com', '081291084481', '', 'https://drive.google.com/open?id=11nS9fyN4fAgs9MSehAyrPfXsxQ5aeNLF', '010002', 'KARANGANYAR', 'MANAGER', '0000-00-00 00:00:00'),
('3315112004910002', 'AHMAD HAIDAR SYIHABUDIN ', '1991-04-20', 1, 'haidar2028@gmail.com ', '082226339891', '', 'https://drive.google.com/open?id=1P2DE7ZdapGcWxo2Ls7U01Z85-IFrrm4c', '010010', 'SUKOLILO ', 'AO', '0000-00-00 00:00:00'),
('3316052708810008', 'AGUNG PRASETYONINGSURYO', '1981-08-27', 1, 'ajunk.2772@gmail.com', '081329081531', '', 'https://drive.google.com/open?id=1TXdbextFHOEnII642Z4y60yWCzWDs5qw', '010014', 'PRAMBANAN,KLATEN', 'AO', '0000-00-00 00:00:00'),
('3317070305920003', 'AHMAD TAUFIQ', '1992-05-03', 1, 'mbaricktaufiq@gmail.com', '085201011163', '', 'https://drive.google.com/open?id=1Z33Jb9OqY6g56A0OfqnhqBl5KBghxN28', '010010', 'CABANG SARANG', 'ACCOUNT OFFICER', '0000-00-00 00:00:00'),
('3317074210850002', 'SITI NURYAH', '1985-10-02', 2, 'nuripembayun@yahoo.com', '085641406296', '', 'https://drive.google.com/open?id=1kfZhhQp4r10M36gEvacICI9rhl-oIoyN', '010010', 'LASEM KOTA', 'AO', '0000-00-00 00:00:00'),
('3317142312890001', 'DEDY ARIFFIYANTO', '1989-12-23', 2, 'dedy.ariffiyanto@gmail.com', '081217004673', '', 'https://drive.google.com/open?id=1DVURULO_XK1SeydaHlWuPxSqgccPgkl_', '010010', 'SARANG', 'AO', '0000-00-00 00:00:00'),
('3317143001860001', 'AKHMAD HASAN KHOLIL', '1986-01-30', 1, 'hasan_sas9996@yahoo.com', '081390199055', '', 'https://drive.google.com/open?id=1gCRHq9IORG2a1KIonIGQn1rlQa0afwO3', '010010', 'CU JOMBANG', 'MANAGER MARKETING', '0000-00-00 00:00:00'),
('3318011310890002', 'MUHAMAD ABDUL ROZAQ', '1989-10-13', 1, 'abdul.rozack089@gmail.com', '085727711611', '', 'https://drive.google.com/open?id=1BSLp0HPk-w0idjeyqjDXPRB-fpfNIDAQ', '010010', 'SUKOLILO', 'MANAJER CABANG', '0000-00-00 00:00:00'),
('3319026306800001', 'MARDIAH, SE', '1980-06-23', 2, 'mardiah8060@yahoo.com', '08985556102', '', 'https://drive.google.com/open?id=1Zy1PFoWK3mxAh9CF1kbtdpT7A0jzanJD', '010001', 'KANTOR PUSAT', 'SUPERVISOR PEMASARAN', '0000-00-00 00:00:00'),
('3319060207850002', 'WIWIT TANGGUH WICAKSONO', '1985-02-07', 1, 'juvew21.wt@gmail.com', '085727580809', '', 'https://drive.google.com/open?id=1mQMDDfWs4SZrAFgIFKE5fekHgTZQ7n07', '010001', 'KANTOR PUSAT', 'SPV PENGENDALI SISTEM', '0000-00-00 00:00:00'),
('3320061306810005', 'FACHRISZAL ARIFIANTO', '1981-06-13', 1, 'ncilhun@yahoo.com', '081360080333', '', 'https://drive.google.com/open?id=1EqDWFA7qM5AHcjQIQvrilNUTSB4jQUEW', '010001', 'KC TAHUNAN JEPARA', 'MANAGER CABANG', '0000-00-00 00:00:00'),
('3320146204840003', 'APRILIYA IKAYANTI SUWANDININGRUM', '1984-04-22', 2, 'apriliya_mfm@yahoo.co.id', '08112776484', '', 'https://drive.google.com/open?id=1GChgZskQ75EeDNrrcZh_Wh9z-1BUj_Z-', '010001', 'KANTOR PUSAT', 'MANAJER DIVISI OPERASIONAL & PEMASARAN', '0000-00-00 00:00:00'),
('3321042612910003', 'MUHAMMAD DALORI', '1991-12-26', 1, 'ridalmuhammad29@gmail.com', '085642856676', '', 'https://drive.google.com/open?id=1Du11bqQFoINUo2-PoBTZfrBiZmKhbvmz', '010010', 'DEMAK', 'AO', '0000-00-00 00:00:00'),
('3322061710810001', 'PRANOTO SUSILO', '1981-10-17', 1, 'omprans1981@gmail.com', '082243882278', '', 'https://drive.google.com/open?id=1v3TzKRz3mcuelElh8Biip44hxq8QBG6t', '010015', 'MAGELANG', 'MARKETING', '0000-00-00 00:00:00'),
('3323071307710003', 'AKHMAD TOLANI, S.AG', '1971-07-13', 1, 'Fatihahmad259@gmail.com', '08122757491', '', 'https://drive.google.com/open?id=1pwrJ1R-yUj0YgyVjslcEfl82zoROUviw', '010002', 'KANTOR CABANG PARAKAN', 'MANAGER', '0000-00-00 00:00:00'),
('3323081206840002', 'WARDANA HERLIYANTO', '1984-06-12', 1, 'wardana.herliyanto@gmail.com', '081387380017', '', 'https://drive.google.com/open?id=1rH3wie0h83Vyz6TQa7JbcK_uf1qr5eGe', '0', 'KANTOR PUSAT PIP JAKARTA', 'STAF KERJASAMA PENDANAAN', '0000-00-00 00:00:00'),
('3323130911820002', 'QORIB AL MUHTAD', '1982-09-11', 1, 'almuhtad82@gmail.com', '085743766569', '', 'https://drive.google.com/open?id=1OiCTUsxkHRRKy2ahSH57U1kA_6s1IoNR', '010014', 'KENDAL', 'ACCOUNT OFFICER', '0000-00-00 00:00:00'),
('3324112406970001', 'MUHAMMAD AINUL YAQIN', '1997-06-24', 1, 'yaqin327@gmail.com', '087700258840', '', 'https://drive.google.com/open?id=1cJlFCE6nXqc53Pw00ZXVqrek55P2EqVl', '010002', 'CABANG KC SLEMAN', 'AO ', '0000-00-00 00:00:00'),
('3324142806880001', 'M. IFAN MURTADHO', '1988-06-28', 1, 'mayangfauna@gmail.cim', '085740122232', '', 'https://drive.google.com/open?id=11qECkYGq4gd9Vfgun0dAXGmgFbm_U87p', '010002', 'KANTOR CABANG PEGANDON', 'MARKETING /AO', '0000-00-00 00:00:00'),
('3374122606930001', 'SHOBACHU CHAFIDHIN A. MA', '1993-06-26', 1, 'shobachu.chafidhin@gmail.com', '08989441185', '', 'https://drive.google.com/open?id=1RtBC2AOfDfyl37gIzLYndBIHNQ33DmeE', '010002', 'GUNUNGPATI', 'MARKETING / AO', '0000-00-00 00:00:00'),
('3402155404890002', 'APRI PASARI', '1989-04-14', 2, 'Apripasari@gmail.com', '087739036837', '', 'https://drive.google.com/open?id=1WzQol_RWeZ_zSbySn8aqaxP9HTgZUTf1', '010014', 'GODEAN', 'ACCOUNT OFFICER', '0000-00-00 00:00:00'),
('3403022403870001', 'DWI PRASETYO', '1987-03-24', 1, 'dwiprasetyotmz@gmail.com', '085743694489', '', 'https://drive.google.com/open?id=1Om8ojbDhh5oiWglSXaGGEkoSpEJNiBy8', '010014', 'MAGELANG', 'MANAGER MARKETING CABANG (MMC)', '0000-00-00 00:00:00'),
('3404020207870002', 'HERI SUSANTO', '1987-07-02', 1, 'herichuss@gmail.com', '085643499122', '', 'https://drive.google.com/open?id=1M85-uQsS2vTa_XV6s1TLefqf_mofKA3O', '010014', 'PURBALINGGA', 'MANAJER MARKETING CABANG', '0000-00-00 00:00:00'),
('3404020606770002', 'AHMAD KURNIAWAN, S.H.', '1977-06-06', 1, 'wawan.tamzis@gmail.com', '085853011027', '', 'https://drive.google.com/open?id=1DFClC4PHq4FiISJrgi5Z0KoX-8xk4gia', '010014', 'AREA KEDU', 'MENEGER MARKETING AREA', '0000-00-00 00:00:00'),
('3523022507860003', 'DIDIK', '1986-07-25', 1, 'Didikalfiansyah@gmail.com', '081217004533', '', 'https://drive.google.com/open?id=16efgtRAO0qqtjLywcgX4Bca-IPBkHlyY', '010010', 'SUKOLILO', 'ACCOUNT OFFICER', '0000-00-00 00:00:00'),
('3523105304850002', 'NASRIATIN', '2019-04-13', 2, 'nasriatin.atin@gmail.com', '082235557899', '', 'https://drive.google.com/open?id=1XqGKAMporyA1LVk3lndtbzY70q3m4C3i', '010010', 'LASEM KOTA', 'MANAGER CABANG', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_sertifikat`
--

CREATE TABLE `tr_sertifikat` (
  `nosertifikat` varchar(50) NOT NULL,
  `tglsertifikat` date NOT NULL,
  `nik` varchar(16) NOT NULL,
  `idpelatihan` varchar(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `penyalur` varchar(10) NOT NULL,
  `nilai` int(11) NOT NULL,
  `posttest` int(11) NOT NULL,
  `pretest` int(11) NOT NULL,
  `status` varchar(2) NOT NULL,
  `qrcode` text NOT NULL,
  `recdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `umi_penyalur`
--

CREATE TABLE `umi_penyalur` (
  `idpenyalur` varchar(11) NOT NULL,
  `induk` varchar(10) NOT NULL,
  `namapenyalur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `umi_penyalur`
--

INSERT INTO `umi_penyalur` (`idpenyalur`, `induk`, `namapenyalur`) VALUES
('0', '0', 'PIP'),
('010', '010', 'BAV'),
('010001', '010', 'KSP KUD MINTOROGO'),
('010002', '010', 'KSPPS NUSA UMMAT SEJAHTERA'),
('010003', '010', 'KSPPS BAYTUL IKHTIAR'),
('010004', '010', 'KSPPS ABDI KERTA RAHARJA'),
('010005', '010', 'KOPERASI MITRA DHUAFA'),
('010006', '010', 'KSPPS BMT MARHAMAH'),
('010007', '010', 'KSPPS BMT BERSAMA SURYA MANDIRI'),
('010008', '010', 'KSPPS AL AMANAH SUMEDANG'),
('010009', '010', 'KSPPS BMT ITQAN'),
('010010', '010', 'KSPPS BMT BINA UMMAT SEJAHTERA'),
('010011', '010', 'KSPS BMT UGT SIDOGIRI'),
('010012', '010', 'KSPPS BTM AMANAH BINA INSAN'),
('010013', '010', 'KSPPS BTM BINA MASYARAKAT UTAMA'),
('010014', '010', 'KSPPS TAMZIS BINA UTAMA'),
('010015', '010', 'KSPPS BMT ALHUDA'),
('010016', '010', 'KJKS BMT NUANSA UMAT'),
('010017', '010', 'KSPPS BMT MELATI'),
('010018', '010', 'KSPPS BMT PRADESA FINANCE MANDIRI'),
('010019', '010', 'KSPPS BMT EL ANUGRAH SEJAHTERA'),
('010020', '010', 'KSPPS BMT AMANAH RAY'),
('010021', '010', 'KSPPS BMT MENTARI MUAMALAT MANDIRI'),
('010022', '010', 'KSPPS BMT ASSYAFIIYAH BERKAH NASIONAL'),
('010023', '010', 'KSPPS MITRA UMMAT NASIONAL'),
('010024', '010', 'KSPPS BMT SURYA ABADI RIYANTO'),
('010025', '010', 'KSPPS KOSPIN SYARIAH'),
('010026', '010', 'KSPPS NUR INSANI'),
('010027', '010', 'KSPPS ARTHA BAHANA SYARIAH'),
('010028', '010', 'KSPPS BMT UMMAT SEJAHTERA ABADI'),
('010029', '010', 'KSPPS BMT HARAPAN BERSAMA'),
('010030', '010', 'KSPPS BINA NIAGA UTAMA'),
('010031', '010', 'KSPPS BMT EL LABANA'),
('010032', '010', 'KSPPS BMT BINA IHSANUL FIKRI'),
('010033', '010', 'KSSU BMT MITRA USAHA MULIA'),
('010034', '010', 'KSPPS BMT SURYA AMANAH'),
('010035', '010', 'KSPPS BMT NURUL BAHRI'),
('011', '011', 'PNM'),
('012', '012', 'PEGADAIAN'),
('penyalur', 'induk', 'namapenyalur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_create`) VALUES
(1, 'master', 'master@umi.id', 'dflt.jpg', '$2y$10$3IGQWP1WB1IlnXbq3O5Hqe4ecgTGMylPgpV592Xu277jwh.v5kY0.', 1, 1, '0000-00-00 00:00:00'),
(2, 'rianindaa', 'rianindaa@umi.id', 'dflt.jpg', '$2y$10$82AOVnLZq6qnmvwveq3b0.T0GS1B5fpxnBkO706ijbo/JlDSXCrQe', 3, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(14, 1, 2),
(18, 2, 6),
(20, 3, 2),
(23, 1, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `urutan` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `urutan`) VALUES
(1, 'Setting', 3),
(2, 'Account', 1),
(6, 'Pelatihan', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member'),
(3, 'New User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 2, 'Dashboard', 'setting', 'fas fa-fw fa-tachometer-alt', 0),
(2, 2, 'My Profile', 'account', 'fas fa-fw fa-user', 1),
(4, 1, 'Menu Management', 'setting/menu', 'far fa-fw fa-folder', 1),
(5, 1, 'Submenu Management', 'setting/submenu', 'fas fa-fw fa-folder-open', 1),
(7, 1, 'Role', 'setting/role', 'fas fa-user-tie', 1),
(10, 6, 'List Pelatihan', 'pelatihan', 'fas fa-fw fa-folder-open', 1),
(11, 1, 'Users', 'setting/users', 'fa fa-user-circle', 1),
(12, 6, 'List Peserta', 'pelatihan/peserta', 'fa fa-users', 1),
(14, 6, 'Sertifikat', 'pelatihan/sertifikat', 'fa fa-list-alt', 1),
(17, 7, 'baru menu', 'baru/users', 'fa fa-user-circle', 1),
(18, 6, 'Profil', 'pelatihan/profil', 'fa fa-user-circle', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tr_kategori`
--
ALTER TABLE `tr_kategori`
  ADD PRIMARY KEY (`kodekategori`);

--
-- Indeks untuk tabel `tr_lembaga`
--
ALTER TABLE `tr_lembaga`
  ADD PRIMARY KEY (`kodelembaga`);

--
-- Indeks untuk tabel `tr_pelatihan`
--
ALTER TABLE `tr_pelatihan`
  ADD PRIMARY KEY (`idpelatihan`),
  ADD KEY `kodelembaga` (`kodelembaga`),
  ADD KEY `kodekategori` (`kodekategori`);

--
-- Indeks untuk tabel `tr_peserta`
--
ALTER TABLE `tr_peserta`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `penyalur` (`penyalur`);

--
-- Indeks untuk tabel `tr_sertifikat`
--
ALTER TABLE `tr_sertifikat`
  ADD PRIMARY KEY (`nosertifikat`),
  ADD KEY `nik` (`nik`),
  ADD KEY `idpelatihan` (`idpelatihan`);

--
-- Indeks untuk tabel `umi_penyalur`
--
ALTER TABLE `umi_penyalur`
  ADD PRIMARY KEY (`idpenyalur`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tr_pelatihan`
--
ALTER TABLE `tr_pelatihan`
  MODIFY `idpelatihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
