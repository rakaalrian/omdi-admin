-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 24, 2017 at 01:28 PM
-- Server version: 10.0.31-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omdiipb1_omdi`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `berita_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` longtext NOT NULL,
  `image` text NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`berita_id`, `judul`, `konten`, `image`, `waktu`) VALUES
(11, 'Launch OMDI APPS 2.0', '<p>Tahun ini BEM -J Diploma IPB meluncrukan aplikasi OMDI APPS 2.0, dimana aplikasi ini akan menjadi salah satu fasilitas untuk para pendukung melihat bagaimana Jadwal, Hasil, dan perolehan medali para program keahliannya</p>', 'LaunchOMDIAPPS2.0-2zoL.jpg', '2017-09-20 00:45:42'),
(12, 'Download dan Update selalu berita OMDI tentang Program Keahlianmu', '<p>Ayo segera download dan update bagaimana kabar program keahlianmu di OMDI tahun ini, kini OMDI 2017 akan disemarakkan dengan kehadiran 18 program keahlian dimana para peserta bersaing untuk memperebutkan juara 1.</p>', 'DownloaddanUpdatesel-K40Z.png', '2017-09-20 00:51:51'),
(13, 'Mengulang Kesuksesan OMI 2015 melalui OMDI 2017', '<p>Kesuksesan Diploma pada OMI tahun 2015 adalah buah hasil kerja keras para pengurus dan official dari Bem - J Diploma IPB. Persiapan yang matang dan juga pembimbingan atlet menjadi kunci utama kesuksesan tersebut, dengan menyabet 18 Emas Diploma keluar menjadi juara umum dan piala bergilir OMI pun singgah di gedung Cilibende</p>', 'MengulangKesuksesanO-YI1F.png', '2017-09-20 01:05:27'),
(14, 'Kata Wakil Direktur Bid. Kemahasiswaan Soal Aplikasi OMDI APPS 2.0', '<p>\"Saya sangat mengapresiasi karya mahasiswa program diploma IPB dalam bidang penerapan teknologi informasi, kami selaku pihak dosen dan para direktur sangat bangga dengan adanya sistem update yang bisa kita lihat diamanapun, kapanpun, terobosan baru ini semoga menjadi cikal bakal untuk tumbuhnya karya-karya besar lagi di diploma ipb\" Ucap Pak Irmansyah selaku Wakil Direktur Bid, Kemahasiswaan diploma IPB</p>', 'KataWakilDirekturBid-zhSI.png', '2017-09-20 01:19:46'),
(15, 'IPB Runners Pelopor Hidup Sehat Mahasiswa IPB', '<p>IPB Runners hadir dengan membawa motto untuk terus menyebarkan kampanya pentingnya kesehatan dan kebugaran kepada seluruh mahasiswa IPB. IPB Runners rutin melakukan kegiata berlari setiap akhir pekan dipagi hari, mulai lari disekitran kampus dramag hingga mengikuti event lari international.</p>', 'IPBRunnersPeloporHid-yNf4.png', '2017-09-20 01:26:40');

-- --------------------------------------------------------

--
-- Table structure for table `cabor`
--

CREATE TABLE `cabor` (
  `cabor_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `background` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabor`
--

INSERT INTO `cabor` (`cabor_id`, `nama`, `background`) VALUES
(2, 'Futsal', 'Futsal-cG7t.png'),
(3, 'Catur', 'Catur-mFb3.png'),
(4, 'Renang Putra', 'Renang-jxsU.png'),
(5, 'Tenis Meja', 'TenisMeja-xevh.png'),
(6, 'Bulu Tangkis Putra', 'BuluTangkis-gFdX.png'),
(7, 'Sepak Bola', 'SepakBola-m0eS.png'),
(8, 'Basket Putra', 'BasketPutra-rigY.png'),
(9, 'Basket Putri', 'BasketPutri-9CPU.png'),
(10, 'Renang Putri', 'RenangPutri-Vv2t.png'),
(11, 'Atletik Putra', 'AtletikPutra-TWVM.png'),
(12, 'Atletik Putri', 'AtletikPutri-EBhF.png'),
(13, 'Voli Putra', 'VoliPutra-co5D.png'),
(14, 'Voli Putri', 'VoliPutri-GTRB.png'),
(15, 'Futsal Putra', 'FutsalPutra-mLno.png'),
(16, 'Futsal Putri', 'FutsalPutri-gYEF.png'),
(17, 'Bulu Tangkis Putri', 'BuluTangkisPutri-LZoa.png'),
(18, 'Bulu Tangkis Ganda Putra', 'BuluTangkisGandaPutra-C4fs.png'),
(19, 'Bulu Tangkis Ganda Putri', 'BuluTangkisGandaPutri-2QvZ.png'),
(20, 'Bulu Tangkis Ganda Campuran', 'BuluTangkisGandaCampuran-r1Qc.png');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `jadwal_id` int(11) NOT NULL,
  `cabor_id` int(11) NOT NULL,
  `lokasi_id` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `babak` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`jadwal_id`, `cabor_id`, `lokasi_id`, `waktu`, `babak`, `status`) VALUES
(1, 4, 5, '2017-09-21 08:00:00', 'Gaya Dada', 1),
(2, 7, 6, '2017-09-21 08:00:00', 'Penyisihan', 1),
(3, 7, 7, '2017-09-21 08:00:00', 'Penyisihan', 1),
(4, 7, 8, '2017-09-21 08:00:00', 'Penyisihan', 1),
(5, 7, 8, '2017-09-21 15:30:00', 'Penyisihan', 1),
(6, 7, 6, '2017-09-21 15:30:00', 'Penyisihan', 1),
(7, 4, 3, '2017-09-21 08:00:00', 'Gaya Kupu-kupu', 1),
(23, 13, 9, '2017-09-24 07:00:00', 'Penyisihan', 0),
(24, 14, 10, '2017-09-24 07:00:00', 'Penyisihan', 0),
(25, 13, 9, '2017-09-24 08:00:00', 'Penyisihan', 0),
(26, 14, 10, '2017-09-24 08:00:00', 'Penyisihan', 0),
(27, 13, 9, '2017-09-24 09:00:00', 'Penyisihan', 0),
(28, 14, 10, '2017-09-24 09:00:00', 'Penyisihan', 0),
(29, 13, 9, '2017-09-24 10:00:00', 'Penyisihan', 0),
(30, 14, 10, '2017-09-24 10:00:00', 'Penyisihan', 0),
(31, 7, 8, '2017-09-24 08:00:00', 'Penyisihan', 0),
(32, 7, 6, '2017-09-24 14:30:00', 'Penyisihan', 0),
(33, 7, 8, '2017-09-24 14:30:00', 'Penyisihan', 0),
(34, 7, 6, '2017-09-24 08:00:00', 'Penyisihan', 0),
(35, 16, 11, '2017-09-24 07:00:00', 'Penyisihan', 0),
(36, 16, 11, '2017-09-24 09:00:00', 'Penyisihan', 0),
(37, 16, 11, '2017-09-24 08:00:00', 'Penyisihan', 0),
(38, 16, 11, '2017-09-24 10:00:00', 'Penyisihan', 0),
(39, 16, 11, '2017-09-24 11:00:00', 'Penyisihan', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_detail`
--

CREATE TABLE `jadwal_detail` (
  `jadwal_detail_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `pk_id` int(11) NOT NULL,
  `poin` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_detail`
--

INSERT INTO `jadwal_detail` (`jadwal_detail_id`, `jadwal_id`, `pk_id`, `poin`, `deskripsi`) VALUES
(1, 1, 1, '0', ''),
(2, 1, 2, '0', ''),
(3, 1, 3, '0', ''),
(4, 1, 4, '0', ''),
(5, 1, 5, '0', ''),
(6, 1, 6, '0', ''),
(7, 1, 7, '0', ''),
(8, 1, 8, '0', ''),
(9, 1, 9, '0', ''),
(10, 1, 10, '0', ''),
(11, 1, 11, '0', ''),
(12, 1, 12, '0', ''),
(13, 1, 13, '0', ''),
(14, 1, 14, '0', ''),
(15, 1, 15, '0', ''),
(16, 1, 16, '0', ''),
(17, 1, 17, '0', ''),
(18, 2, 6, '0', ''),
(19, 2, 15, '0', ''),
(20, 3, 16, '0', ''),
(21, 3, 9, '0', ''),
(22, 4, 8, '0', ''),
(23, 4, 5, '0', ''),
(24, 5, 2, '0', ''),
(25, 5, 7, '0', ''),
(26, 6, 3, '0', ''),
(27, 6, 14, '0', ''),
(29, 8, 7, '0', ''),
(30, 9, 4, '0', ''),
(31, 9, 17, '0', ''),
(32, 20, 13, '0', ''),
(33, 20, 10, '0', ''),
(34, 21, 3, '0', ''),
(35, 21, 7, '0', ''),
(36, 19, 1, '0', ''),
(37, 19, 11, '0', ''),
(38, 16, 13, '0', ''),
(39, 16, 17, '0', ''),
(40, 11, 1, '0', ''),
(41, 11, 6, '0', ''),
(42, 10, 10, '0', ''),
(43, 10, 17, '0', ''),
(44, 8, 1, '0', ''),
(45, 23, 10, '0', ''),
(46, 23, 17, '0', ''),
(47, 24, 4, '0', ''),
(48, 24, 17, '0', ''),
(49, 25, 7, '0', ''),
(50, 25, 1, '0', ''),
(51, 26, 1, '0', ''),
(52, 26, 6, '0', ''),
(53, 27, 12, '0', ''),
(54, 27, 3, '0', ''),
(55, 28, 2, '0', ''),
(56, 28, 16, '0', ''),
(57, 29, 8, '0', ''),
(58, 29, 6, '0', ''),
(59, 30, 8, '0', ''),
(60, 30, 9, '0', ''),
(61, 31, 13, '0', ''),
(62, 31, 17, '0', ''),
(63, 32, 12, '0', ''),
(64, 32, 4, '0', ''),
(65, 33, 10, '0', ''),
(66, 34, 11, '0', ''),
(67, 34, 1, '0', ''),
(68, 35, 13, '0', ''),
(69, 35, 10, '0', ''),
(70, 36, 13, '0', ''),
(71, 36, 10, '0', ''),
(72, 37, 7, '0', ''),
(73, 37, 3, '0', ''),
(74, 38, 4, '0', ''),
(75, 38, 12, '0', ''),
(76, 39, 11, '0', ''),
(77, 39, 1, '0', ''),
(79, 40, 17, '100', ''),
(80, 40, 15, '100 Menit', '');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `lokasi_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `lat` text NOT NULL,
  `lng` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`lokasi_id`, `nama`, `lat`, `lng`) VALUES
(1, 'Pizza Hut Pajajaran', '-6.606243099999999', '106.80898690000004'),
(2, 'GOR Pajajaran', '-6.577821399999999', '106.79778120000003'),
(3, 'Kolam Renang Vila Duta', '-6.6095329', '106.81705020000004'),
(4, 'Futsal Cimahpar', '-6.587193848916296', '106.8136739730835'),
(5, 'Kolam Renang Cimahpar', '-6.588153068790114', '106.82607650756836'),
(6, 'Lapangan Lodaya', '-6.591009400000002', '106.80508859999998'),
(7, 'Lapangan Cimahpar', '-6.584122700000001', '106.83243029999994'),
(8, 'Lapangan Jasilun', '-6.5837623', '106.83238370000004'),
(9, 'Lap Voli GG', '-6.587417667052733', '106.80733323097229'),
(10, 'Lap Voli Lodaya', '-6.587748065069605', '106.8087387084961'),
(11, 'Lap Futsal GG', '-6.587737407072495', '106.807461977005');

-- --------------------------------------------------------

--
-- Table structure for table `medali`
--

CREATE TABLE `medali` (
  `medali_id` int(11) NOT NULL,
  `pk_id` int(11) NOT NULL,
  `emas` int(11) NOT NULL DEFAULT '0',
  `perak` int(11) NOT NULL DEFAULT '0',
  `perunggu` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medali`
--

INSERT INTO `medali` (`medali_id`, `pk_id`, `emas`, `perak`, `perunggu`) VALUES
(1, 1, 0, 0, 0),
(2, 2, 0, 0, 0),
(3, 3, 0, 0, 0),
(4, 4, 0, 0, 0),
(5, 5, 0, 0, 0),
(6, 6, 0, 0, 0),
(7, 7, 0, 0, 0),
(8, 8, 0, 0, 0),
(9, 9, 0, 0, 0),
(10, 10, 0, 0, 0),
(11, 11, 0, 0, 0),
(12, 12, 0, 0, 0),
(13, 13, 0, 0, 0),
(14, 14, 0, 0, 0),
(15, 15, 0, 0, 0),
(16, 16, 0, 0, 0),
(17, 17, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pk`
--

CREATE TABLE `pk` (
  `pk_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `singkatan` varchar(255) NOT NULL,
  `logo` text NOT NULL,
  `deskripsi` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pk`
--

INSERT INTO `pk` (`pk_id`, `nama`, `singkatan`, `logo`, `deskripsi`) VALUES
(1, 'Komunikasi', 'KMN', 'KMN-REt9.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Superhero yang identik dengan kelelawar, dingin, gelap dan berprinsip moralitas yang tinggi. Sama halnya dengan PK Komunikasi dengan seragam hitam-hitamnya yang terkesan dingin dan gelap. Memiliki sikap stay cool dalam menghadapi masalah. Karena kami tau ketika kami panic kami tidak akan bisa berfikir jernih. Hanya dengan otak tanpa kekuatan super, batman dapat menjatuhkan lawan. Begitu pula dengan PK Komunikasi yang dapat mengalahkan lawan dengan cara member pelajaran yaitu menunjukan kemampuan kami bertotalitas tinggidan keras agar lawan sadar seberapa tangguhnya kami untuk dihadapi tanpa menimbulkan permusuhan.</span>'),
(2, 'Ekowisata', 'EKW', 'EKW-jlJk.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Tarzan merupakan manusia yang lahir di hutan yang menyatu dengan alam. Memiliki jiwa kepemimpinan serta konservasionis dan juga mampu beradaptasi dimanapun dia berada. Dia akan marah dan membela diri serta kawannya apabila&nbsp; dirinya atau salah satu kawannya diusik atau diganggu oleh orang yang tidak bertanggungjawab yang memiliki maksud merusak.</span>'),
(3, 'Manajemen Informatika', 'INF', 'INF-KGqt.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Di dunia, Anonymous misterius, tidak banyak orang yang tau informasinya tapi berbahaya dan ditakuti karena kemampuan terpendamnya yaitu hacker yang digunakan untuk membantu menyelesaikan kasus-kasus. INF juga seperti Anonymous, INF merupakan PK misterius, tidak banyak Informasi yang PK lain tentang INF tapi kami berbahaya dan perlu ditakuti untuk OMDI tahun ini. Karena kami mempunyai kemampuan terpendam.</span>'),
(4, 'Teknik Komputer', 'TEK', 'TEK-jRk9.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Lebah identik dengan kekompakan, apabila diusik akan menyengat, lebah juga melindungi ratu lebah yang diibaratkan seperti para wanita di Program Keahlian Teknik Komputer.</span>'),
(5, 'Spv. Jaminan Mutu Pangan', 'SJMP', 'SJMP-FKie.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Blues itu sesuai dengan baju Program keahlian SJMP, warna biru itu tenang tapi mematikan (laut) botulin itu toxic yang siap mematikan semua lawan.</span>'),
(6, 'Manj. Industri Jasa Makanan Dan Gizi', 'GZI', 'GZI-yYxD.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Garuda Intelektual melambangkan bahwa Mahasiswa Program Keahlian Gizi merupakan mahasiswa yang cerdas namun tidak lupa dengan tanah dimana mereka hidup. Garuda merupakan burung yang kuat sehingga harapan kita untuk OMDI yaitu mampu terbang gagah menjadi juara bak garuda ketika melayang dilangit.</span>'),
(7, 'Teknologi Industri Benih', 'TIB', 'TIB-0fYV.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Super Seed Man adalah manusia super yang siap menebar benih-benih unggul di setiap cabor untuk memenangkan OMDI TIB.</span>'),
(8, 'Tek.Produksi Dan Manj. Perikanan Budidaya', 'IKN', 'IKN-oXxl.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Megalodon adalah Penguasa Air yang Besar. Seperti IKN yang mempunyai semangat yang BESAR., Jiwa yang BESAR, solidaritas yang BESAR, niat yang BESAR sehingga menjadi penguasa samudera yang luas. Ukuran ikan inilah yang menggambarkan nyali dan kekuatan IKN.</span>'),
(9, 'Teknologi Dan Manajemen Ternak', 'TNK', 'TNK-pJSv.png', '-'),
(10, 'Manajemen Agribisnis', 'MAB', 'MAB-QTmu.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Popaye adalah pelaut yang meninggalkan daratan, diibaratkan Mahasiswa MAB yang meninggalkan tempat asal mereka untuk mendukung MAB. MAB adalah Program Keahlian yang kuat layaknya Popaye, selalu siap dalam setiap pertandingan PK, sama seperti Popaye yang selalu siap membantu kala ada yang mengalami kesulitan.</span>'),
(11, 'Manajemen Industri', 'MNI', 'MNI-pBOf.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Golden Gear Warior diartikan sebagai bakat emas (kontingen) yang ada di MNI, yang akan mewakili MNI di OMDI, MNI identik akan Gear dan Semangat MNI yang seperti Warior.</span>'),
(12, 'Analisis Kimia', 'KIM', 'KIM-FgmG.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Semut merah merupakan semut yang paling menggigit dan paling garang diantara jenis semut lainnya. Dengan prinsip hidup secara berkoloni dan bekerja sama, semut merah dapat mengangkat beban 1000 kali berat badannya. Filosofi ini berkaitan erat dengan kepribadian mahasiswa Analisis Kimia yang selalu bekerja sama menghadapi segala tantangan yang menghadang, serta menjadi suatu pasukan yang paling kuat dan garang. Dengan jargon “Hanya untuk yang berani” semut merah siap mengarungi OMDI 2016 dengan semangat “Sang Juara”&nbsp;</span>'),
(13, 'Teknik Dan Manajemen Lingkungan', 'LNK', 'LNK-V2MX.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Rein merupakan nama rusa legendaris dan rusa merupakan biokatalisator lingkungan yang mencirikan lingkungan yang baik dan keistimewaan The Rein ini memiliki tanduk yang kuat memcirikan tekad LNK yang kuat menjadi juara.</span>'),
(14, 'Akuntansi', 'AKN', 'AKN-L5Za.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Filosofi Anubis adalah Penguasa. Anubis memiliki timbangan keadilan yang mencermin keadilan. Akuntansi harus adil, ga boleh memihak siapapun, dan harus bersikap jujur. Anubis pelindung roh-roh baik dan pemakan roh-roh jahat. Anubis juga diasumsikan sebagai oknum yang baik dan penghancur bagi yang jahat(koruptor).</span>'),
(15, 'Paramedik Veteriner', 'PVT', 'PVT-J5t9.png', '<div id=\":qx\" class=\"ii gt adP adO\" style=\"font-size: 12.8px; direction: ltr; margin: 5px 15px 0px 0px; padding-bottom: 5px; position: relative; color: rgb(34, 34, 34); font-family: arial, sans-serif;\"><div id=\":t9\" class=\"a3s aXjCH m157006043795e3e1\" style=\"overflow: hidden;\"><div dir=\"ltr\"><div class=\"gmail_quote\"><div dir=\"ltr\">PVT mempunyai sifat seperti layaknya burung hantu yaitu ramah dan bersahabat, tetapi ia ( PVT ) juga hewan (&nbsp;<span class=\"il\">PK</span>&nbsp;) yang perlu diwaspadai karena ia bisa menjadi predator untuk musuhnya. Kecerdasan, kemampuan diatur dan wataknya yang tidak banyak tingkah membuat dia menjadi hewan (&nbsp;<span class=\"il\">PK</span>&nbsp;) yang tidak suka memamerkan dirinya ( rendah hati )<div class=\"yj6qo\"></div></div><div><br></div></div></div></div></div><div class=\"hq gt a10\" id=\":si\" style=\"margin: 15px 0px; clear: both; font-size: 12.8px; color: rgb(34, 34, 34); font-family: arial, sans-serif;\"></div>'),
(16, 'Teknologi Dan Manj. Produksi Perkebunan', 'TMP', 'TMP-urdz.png', '<span style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 16px;\">Hanzo adalah ninja yang melegendaris, sedangkan Nursery berarti persemaian, menghasilkan benih bermutu untuk dijadikan bibit prestasi. Bila ditelisik lebih lanjut, dalam istilah ninja, ada keahlian yang disebut seishin teki kyoyo Artinya pemurnian Jiwa, diri tentang begaimana seorang ninja harus mengetahui dengan tepat komitmen dan motivasi hidupnya sebelum berkiprah dalam memikul tanggung jawab. Disini anggota TMP yang merupakan bibit prestasi berkomitmen dan bertanggung jawab untuk menjadi pemenang dari setiap cabang olahraga.</span>'),
(17, 'Teknologi Produksi Dan Pengembangan Masyarakat Pertanian', 'PPP', 'PPP-4X5v.png', '--');

-- --------------------------------------------------------

--
-- Table structure for table `saran`
--

CREATE TABLE `saran` (
  `saran_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `saran` text NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saran`
--

INSERT INTO `saran` (`saran_id`, `email`, `saran`, `waktu`) VALUES
(1, 'dandipangestu96@gmail.com', 'Keren Appsnya', '2017-08-19 00:51:03'),
(2, 'dandipangestu96@gmail.com', 'Keren Appsnya', '2017-08-24 03:22:22'),
(3, 'dandipangestu96@gmail.com', 'Keren Appsnya', '2017-09-12 17:32:52'),
(4, 'a@sjsi.com', 'jeksjz', '2017-09-13 09:30:33'),
(5, 'uxkdj@kdkd.com', 'jdkd', '2017-09-13 09:30:49'),
(6, 'omdi@yahoo.com', 'bisa ga yaaa', '2017-09-13 09:36:37'),
(7, 'bagas@gmail.com', 'ahh akhirnya bisa post pake retrofit2', '2017-09-13 09:39:47'),
(8, 'raka@raka.raka', '????', '2017-09-13 16:50:39'),
(9, 'ardiecontinued@gmail.com', 'Rrrr', '2017-09-13 18:48:21'),
(10, 'ardiecontinued@gmail.com', 'Ysgshs', '2017-09-14 14:12:25'),
(11, 'Hamba Allah', 'jadi sebenernya ini apa?', '2017-09-16 20:55:44'),
(12, 'Hamba Allah', 'aww', '2017-09-16 21:23:31'),
(13, 'Hamba Allah', 'Coba ahh', '2017-09-16 21:26:16'),
(14, 'Hamba Allah', 'e', '2017-09-16 21:37:43'),
(15, 'Hamba Allah', 'Mantaaaaap ', '2017-09-16 21:56:29'),
(16, 'Hamba Allah', 'kxkd', '2017-09-16 23:18:28'),
(17, 'Hamba Allah', 'Cihuy', '2017-09-20 01:07:22'),
(18, 'Hamba Allah', 'apasih', '2017-09-21 09:54:36'),
(19, 'Hamba Allah', 'applikasi masih belum berjalan dg baik. ', '2017-09-21 15:43:22'),
(20, 'Hamba Allah', 'ini saran', '2017-09-21 21:11:39'),
(21, 'Hamba Allah', 'ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ini saran ', '2017-09-21 21:47:27'),
(22, 'Hamba Allah', 'Assalamualaikum\nMaaf tolong jadwal omdi 2017 dan perolehan medali serta jadwal diupdate lagi\nTerima kasih ', '2017-09-22 19:17:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`berita_id`);

--
-- Indexes for table `cabor`
--
ALTER TABLE `cabor`
  ADD PRIMARY KEY (`cabor_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`jadwal_id`);

--
-- Indexes for table `jadwal_detail`
--
ALTER TABLE `jadwal_detail`
  ADD PRIMARY KEY (`jadwal_detail_id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`lokasi_id`);

--
-- Indexes for table `medali`
--
ALTER TABLE `medali`
  ADD PRIMARY KEY (`medali_id`),
  ADD KEY `pk_id` (`pk_id`);

--
-- Indexes for table `pk`
--
ALTER TABLE `pk`
  ADD PRIMARY KEY (`pk_id`);

--
-- Indexes for table `saran`
--
ALTER TABLE `saran`
  ADD PRIMARY KEY (`saran_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `berita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `cabor`
--
ALTER TABLE `cabor`
  MODIFY `cabor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `jadwal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `jadwal_detail`
--
ALTER TABLE `jadwal_detail`
  MODIFY `jadwal_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `lokasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `medali`
--
ALTER TABLE `medali`
  MODIFY `medali_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pk`
--
ALTER TABLE `pk`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `saran`
--
ALTER TABLE `saran`
  MODIFY `saran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `medali`
--
ALTER TABLE `medali`
  ADD CONSTRAINT `medali_ibfk_1` FOREIGN KEY (`pk_id`) REFERENCES `pk` (`pk_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
