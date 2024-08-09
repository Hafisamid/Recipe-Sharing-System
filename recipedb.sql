-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 05:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Name`) VALUES
(1, 'nasi'),
(2, 'italian'),
(3, 'malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `RecipeID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Ingredients` text DEFAULT NULL,
  `Instructions` text DEFAULT NULL,
  `PreparationTime` int(11) DEFAULT NULL,
  `CookingTime` int(11) DEFAULT NULL,
  `Servings` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Video` varchar(255) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`RecipeID`, `Title`, `Description`, `Ingredients`, `Instructions`, `PreparationTime`, `CookingTime`, `Servings`, `Image`, `Video`, `CategoryID`) VALUES
(7, 'Nasi Ayam', 'Nasi Ayam Legend by Che Nom', '- Bahan-bahan untuk kisar halus:\r\n6 inci halia\r\n12 ulas bawang putih\r\nBahan-bahan untuk ayam:\r\n1 kiub pati ayam\r\nDaun bawang\r\nPes halia & bawang putih\r\n2 sb sos tiram\r\n1 sb kicap manis\r\n1 sb kicap cair\r\nMinyak untuk menggoreng\r\n1 ekor ayam\r\nMinyak bijan\r\nMadu\r\n- Bahan-bahan untuk nasi:\r\n1-2 potong lemak\r\n1/2 senduk mentega\r\nPes halia & bawang putih\r\n1 kayu manis\r\n5 biji buah pelaga\r\n3 kuntum bunga cengkih\r\n2 kuntum bunga lawang\r\n1 helai daun pandan\r\n1 batang serai\r\n3 cwn  beras\r\n4 1/2 cwn air rebusan ayam\r\nSedikit garam\r\n1 sk serbuk kunyit\r\n- Bahan-bahan untuk sos:\r\n6-8 biji cili merah\r\n6 biji cili api\r\nSedikit air rebusan ayam\r\nPes halia & bawang putih\r\n2 sb jus lemon\r\nGula\r\nGaram\r\n1 sb sos cili\r\n- Bahan-bahan untuk kicap:\r\nAir lebihan perapan ayam\r\n1 mangkuk kecil kicap manis\r\nSedikit air rebusan ayam\r\nGaram\r\n- Bahan-bahan untuk sup:\r\nLebihan air rebusan ayam\r\nKaki ayam (jika suka)\r\n1 sup bunjut\r\nLobak merah\r\nKentang\r\n1 sk lada sulah\r\nGaram\r\nDaun sup\r\n- Bahan-bahan untuk hiasan:\r\nTomato\r\nTimun\r\nSalad\r\nDaun sup\r\nDaun bawang', '1. Cara-cara untuk bahan kisar:\r\nPotong kasar bawang putih dan halia.\r\nKisar halus bawang putih dan halia dengan sedikit air.\r\nDah siap kisar, bahagikan kepada 4 bahagian.\r\n2. Cara-cara untuk ayam rebus:\r\nDaun sup bahagian batang potong panjang 2 inci (untuk rebus ayam). Bahagian daun potong halus (untuk hiasan).\r\nDaun bawang bahagian batang belah dua, bahagian daun potong memanjang.\r\nBersihkan ayam dan belah 2 (simpan sikit bahagian kulit / lemak untuk masak nasi)\r\nGaul ayam dengan pes bawang putih dan halia.\r\nMasukkan ayam, air (sampai tengelam ayam) dan kiub pati ayam dalam periuk\r\nRebus dengan api perlahan sampai ayam masak.\r\nBila dah masak, angkat ayam dan sejukkan.\r\nUntuk perapan, kacau sebati pes halia, bawang putih, sos tiram, kicap manis dan kicap cair.\r\nSapu ayam dengan perapan tadi.\r\nPerap ayam anggaran ½ -1 jam.\r\n3. Cara-cara untuk nasi:\r\nCarik dan simpul daun pandan.\r\nKetuk serai sampai pecah.\r\nPanaskan kulit / lemak ayam atas kuali sampai cair dan mengecut (nak mudah cair letak minyak masak sikit).\r\nBila dah mengecut, keluarkan kulit.\r\nMasukkan butter atau majerin.\r\nTumis pes halia, bawang putih, rempah 4 sekawan, daun pandan dan serai sampai kekuningan.\r\nMasukkan  beras dan goreng sekejap biar bergaul sekata.\r\nTuang masuk air rebusaan ayam, garam dan serbuk kunyit.\r\nAkhir sekali pindah masuk  rice cooker dan biar nasi masak.\r\n4. Cara-cara untuk sos cili:\r\nPotong kasar cili merah besar (tambah cili padi kalau nak pedas).\r\nLemon perah ambil jus (atau cuka).\r\nKisar kasar cili, air rebusan ayam, jus lemon, gula, garam, pes halia dan bawang putih.\r\nTuang masuk dalam periuk dan masak sampai mendidih.\r\nTambah sos cili dan kacau sebati.\r\nTutup api dan sejukkan sebelum hidang.\r\n5. Cara-cara untuk kuah kicap:\r\nMasukkan baki perapan ayam, kicap manis, air rebusan ayam dan sedikit garam (kalau perlu) dalam periuk.\r\nMasak sampai mendidih dan angkat.\r\n6. Cara-cara untuk  sup ayam:\r\nPotong kentang dan karot.\r\nMasukkan sup bunjut, serbuk lada sulah, garam, kentang dan karot dalam baki air rebusan ayam. Nak tambah kaki atau tulang ayam pon boleh.\r\nMasak sampai mendidih dan tabur daun sup.\r\n7. Cara-cara untuk  ayam goreng:\r\nPanaskan minyak dan goreng ayam sampai masak keperangan.\r\nBila dah perang boleh angkat dan sapu dengan minyak bijan dan madu (sapu minyak bijan dulu dan kemudian sapu madu).\r\n8. Cara-cara untuk condiment:\r\nPotong sederhana nipis timun dan tomato.\r\nDaun  salad rendam dengan air sejuk dan keringkan.\r\nSusun dalam pinggan dan sedia untuk dihidang.', 30, 40, 8, 'uploads/Nasi_Ayam.png', 'https://www.youtube.com/watch?v=FamGd3JRS_s', 1),
(8, 'Nasi Goreng Kampung', 'Nasi Goreng Kampung by Che Nom', 'Bahan-bahan nasi goreng kampung:\r\n4 cawan nasi sejuk\r\n3 ulas bawang putih\r\n2 biji bawang merah kecil\r\n6-8 tangkai cili padi\r\n2 sb ikan bilis\r\n1 ketul isi ayam\r\n1 ikat kangkung\r\n1 inci belacan\r\n1 sk garam\r\n2 biji telur\r\n1-2 sb kicap manis\r\n1-2 sb sambal belacan\r\n1 cawan ikan bilis\r\nTimun\r\nCili merah', 'Cara-cara untuk nasi goreng kampung:\r\n1.Daun kangkung, potong dan asingkan batang dan daun.\r\n2. Isi ayam buang lemak dan tulang kemudian potong kepada ketulan kecil.\r\n3. Cincang kasar bawang merah kecil dan bawang putih.\r\n4. Potong kasar cili padi.\r\n5. Tumbuk halus ikan bilis, bawang putih, bawang merah dan cili padi.\r\n6. Panaskan minyak dan goreng telur. Kacau biar hancur. Angkat dan ketepikan.\r\n7. Goreng ikan bilis sampai garing. Angkat dan ketepikan.\r\n8. Tumis bahan tumbuk sehingga garing.\r\n9. Masukkan belacan bakar dan isi ayam. Kacau sampai ayam separuh masak.\r\n10. Masukkan batang kangkung dan sambal belacan (lebihkan belacan dan cili padi kalau tak nak masuk sambal belacan).\r\n11. Masukkan nasi sejuk dan kacau sebati.\r\n12. Masukkan garam, telur, daun kangkung, kicap pekat manis dan ikan bilis goreng (simpan sikit untuk taburan akhir). Kacau sebati\r\n13. Hidangkan bersama ikan bilis goreng, hirisan timun dan cili merah.', 20, 30, 5, 'uploads/NasiGorengK.png', 'https://www.youtube.com/watch?v=096Za7YzggI', 1),
(9, 'Pizza ', 'Pizza Homemade by Che Nom', '- Bahan-bahan untuk doh pizza:\r\n500g / 4 cawan tepung Italian 00 ATAU\r\n445g / 3 1/2 cawan tepung roti\r\n1 sudu kecil garam halus\r\n375ml / 1 1/2 cawan air suam\r\n2 sudu kecil serbuk yis\r\n1 sudu kecil gula\r\n2 1/2 sudu besar minyak zaitun extra virgin\r\nsedikit tepung semolina\r\n- Bahan untuk topping (beef mushroom pizza) :\r\nsos pasta tomato\r\nsedikit minyak zaitun extra virgin olive\r\ndaging kisar (dimasak)\r\ncapsicum\r\nserbuk cheese pasmesan\r\ncendawan butang\r\nbawang\r\nparutan cheese mozzarella\r\nblack olive\r\nTopping daging kisar yg dimasak:\r\n1 ulas bawang putih\r\n1 mangkuk kecil daging kisar\r\nserbuk black pepper\r\nsedikit Italian herbs\r\nsedikit garam\r\n- Bahan untuk topping (beef pepperoni pizza) :\r\nsos pasta tomato\r\nsedikit minyak zaitun extra virgin\r\nserbuk cheese parmesan\r\nparutan cheese mozzarella\r\nhirisan beef pepperoni\r\ntabur dengan daun basil , optional', '1. Masukkkan tepung italian \'00\' atau tepung roti kedalam mangkuk adunan.\r\n2. Masukkkan garam halus dan kacau sebati mengunakan whisk.\r\n3. Dalam bekas yang berasingan, masukan air suam, serbuk yis segera dan gula.\r\n4. Kacau dan biarkan sebentar sehingga muncul buih di permukaan.\r\n5. Tuang bancuhan yis kedalam adunan tadi.\r\n6. Tambah sedikit minyak zaitun extra virgin (extra virgin olive oil).\r\n7. Kacau sehingga semua bahan sebati.\r\n8. Taburkan sedikit tepung dan keluarkan doh.\r\n9. Uli sehingga 10 minit atau sehingga elastik dan lincin.\r\n10. Griskan mangkuk dengan minyak zaitun, letakkan doh dan sapu permukaan doh dengan minyak zaitun\r\n11. Tutup dengan plastik cling wrap.\r\n12. Biarkan doh naik sehingga dua kali ganda atau 5 jam.\r\n13. Boleh perap semalaman untuk doh yang lebih sedap.\r\n14. Bila doh dah kembang, keluarkan dan uli sekali lagi sehingga lincin.\r\n15. Bahagikan kepada dua bahagian.\r\n16. Mula panaskan oven kepada suhu paling maximum oven anda.\r\n17. Masukkan tray kosong yang diterbalikkan (untuk dapatkan permukaan yang rata dan senang nak pindahkan pizza nant).\r\n18. Tabur sedikit tepung semolina dan tepung roti.\r\n19. Ambil doh dan leperkan kepada bentuk bulat.\r\n- Cara-cara untuk toping beef mushroom:\r\nPanaskan minyak zaitun.\r\nTumis bawang putih cincang.\r\nMasukkan daging kisar, black pepper, italian herbs dan sedikit garam.\r\nMasak sehingga daging kering.\r\nPotong kecil capsicum hijau.\r\nHiris nipis cendawan butang dan bawang besar.\r\nHiris nipis black olive.\r\nSediakan sos pasta tomato @ whole peeled tomatoes(kisar halus sebelum guna).\r\nSapu sos pasta tomato atas permukkan doh dengan sekata.\r\nTuang sedikit minyak zaitun extra virgin oil.\r\nTabur sedikit daging kisar yg telah dimasak tadi.\r\nKemudian taburkan kesemua bahan-bahan yang dihiris nipis.\r\nTaburkan serbuk cheese Parmesan dan parutan cheese mozzarella.\r\n- Cara-cara untuk topping beef pepperoni:\r\nSapu sos pasta tomato dengan sekata.\r\nTuang sedikit minyak zaitun extra virgin.\r\nTabur sedikit serbuk cheese Parmesan dan cheese mozzarella.\r\nSusun hirisan beef pepperoni.\r\nTabur sekali lagi cheese Parmesan.\r\nBakar pizza sehingga kedua-dua permukkan atas dan bawah masak keperangan dan bahagian bawah bertukar kepada lapisan yang ranggup.\r\n20. Bila dah masak, keluarkan dan potong dengan pizza roller atau pisau.', 20, 35, 4, 'uploads/pizza.png', 'https://www.youtube.com/watch?v=tgACJACuSwc', 2),
(10, 'Roti Telur', 'cara memasak roti telur yang mudah', '4 biji telur\r\n\r\n2 sudu besar planta\r\n\r\n\r\nSerbuk lada putih\r\n\r\nLada hitam kasar\r\n\r\nMushroom seasoning\r\n\r\n1 sudu kecil mayonis\r\n\r\nRoti keping\r\n\r\nKeju', '1.Rebus telur dalam 4 biji.\r\n\r\n2.Kupas kulit telur tu, masuk dalam mangkuk, lenyekkan dengan garfu.\r\n\r\n3.Masuk planta, serbuk lada putih, lada hitam kasar (black pepper coarse), mushroom seasoning, mayonaise, Gaul semua sebati.\r\n\r\n4.Letak pada roti, letak keju sekeping, sapu planta luar roti, grill atas kuali tidak melekat. Jangan letak minyak apa-apa, pusingkan sampai roti tu garing.\r\n\r\n5.Angkat, potong tepi roti dan belah tengah, guna pisau yang tajam.', 3, 10, 4, 'uploads/roti telur.jpg', 'https://www.youtube.com/watch?v=rHhGlno0TG4', 3),
(11, 'Pasta bolognese', 'cara mudah spagetti bolognese', '2 liter air\r\n500 gram spaghetti\r\n2 sudu kecil garam\r\nsedikit minyak zaitun\r\n\r\nBahan-bahan untuk sos Bolognese:\r\nsedikit minyak zaitun\r\n1/2 biji bawang Holland\r\n3 ulas bawang putih\r\n1/2 biji capsicum hijau\r\n1/2 biji karot\r\n2-3 biji hirisan tomato\r\n7 biji cendawan\r\n300 gram daging kisar\r\nsos Bolognese\r\n3-4 sudu besar tomato puree\r\nsedikit Italian herbs\r\nsedikit air pasta\r\nserbuk parmesan\r\nsedikit garam\r\nsedikit gula (jika perlu)\r\n1/4 cawan susu full cream', 'Cara-cara untuk pasta:\r\nRebus spaghetti.\r\nMasukkan air kedalam periuk yang besar dan masak air sehingga mendidih.\r\nMasukkan garam secukupnya.\r\nSetelah mendidih, masukkan spaghetti kering.\r\nTerus kacau spaghetti supaya spaghetti tidak melekat antara satu sama lain.\r\nRebus mengikut berapa minit mengikut arahan di packat pasta.\r\nSetelah pasta lembut sikit tapi tak terlebih kembang, tapis dan gaulkan dengan sedikit minyak zaitun.\r\nCara-cara untuk sos Bolognese:\r\nSimpan sedikit air rebusan spaghetti untuk kita masukkan dalam kuah nanti.\r\nPotong dadu bawang holland dan carrot.\r\nCincang halus bawang putih.\r\nHiris kecil nipis capsicum hijau dan cendawan butang putih .\r\nBuang biji tengah tomato dan hiris nipis.\r\nPanaskan sedikit minyak zaitun.\r\nTumis bawang holland sehingga bawang lembut.\r\nMasukkan bawang putih.\r\nMasukkan daging kisar dan kacau.\r\nMasukkan capsicum dan carrot.\r\nKacau dan teruskan masak sehingga kering air daging.\r\nMasukkan sedikit serbuk black pepper.\r\nMasukkan hirisan tomato dan masak sehingga lembut.\r\nMasukkan hirisan cendawan.\r\nKacau sehingga cendawan layu sikit.\r\nKemudian masukkan sos bolognese segera.\r\nTambah tomato puree.\r\nMasukkan sikit italian herbs.\r\nMasukkan sikit air pasta dan kacau sebati.\r\nTambah serbuk parmesan dan garam.\r\nKalau masam boleh tambah sedikit gula.\r\nAkhir sekali tambahkan sedikit susu full cream (optional).\r\nHidangkan dengan spaghetti dan sedikit taburan keju parmesan.', 15, 20, 4, 'uploads/th.jpeg', 'https://www.youtube.com/watch?v=v2WqcHH65NQ', 2),
(12, 'Nasi Minyak', 'Cara mudah untuk memasak nasi minyak', 'Bahan-bahan nasi minyak:\r\n3 cwn beras basmathi\r\n3 1/2 cwn air\r\n1 cwn susu cair\r\n3 sb minyak sapi\r\n2 sb minyak masak\r\n1/2 biji bawang besar\r\n3 ulas bawang putih\r\n2 biji bawang merah\r\n2 inci halia\r\n1 helai daun pandan\r\nRempah 4 sekawan\r\n1/4 cwn kismis\r\n1 sk gula\r\nGaram secukup rasa\r\nPewarna kuning/oren\r\nBawang goreng\r\nGajus\r\nDaun ketumbar\r\nBahan-bahan rempah 4 sekawan:\r\n1 batang kayu manis\r\n4 biji buah pelaga\r\n4 kuntum bunga cengkih\r\n1 kuntum bunga lawang', 'Potong bawang besar, bawang merah dan bawang putih. Halia hiris tebal dan ketuk kasar.\r\nDaun pandan carik dan simpul.\r\nTumbuk halus bawang merah dan bawang putih\r\nRendam beras (kurang dari 30 minit), basuh dan toskan air.\r\nPanaskan minyak sapi dan minyak masak\r\nTumis rempah 4 sekawan.\r\nMasukkan bawang tumbuk, daun pandan, hirisan halia dan bawang besar. Kacau sampai bawang besar layu.\r\nMasukkan kismis dan kacau sekejap.\r\nMasukkan beras dan goreng sekejap.\r\nMasukkan air, garam, susu cair dan gula. Kacau sebati.\r\nPindah masuk kedalam pressure cooker / periuk nasi.\r\nSelepas nasi dah masak, cucuk dan buat lubang kemudian titis masuk pewarna oren dan biarkan 10 minit.\r\nSapu dekat bahagian atas nasi dengan minyak sapi (1 sudu besar).\r\nKeluarkan hirisan halia dan daun pandan.\r\nHidang bersama bawang goreng, kacang gajus dan daun ketumbar.\r\nTip:\r\nGunakan cawan yang sama untuk sukat beras, air dan susu cair.\r\nUntuk dapatkan nasi yang tak melekat dan sebiji-sebiji berderai, Che Nom goreng dulu beras masa menumis, beras akan bersalut rata dengan minyak sebelum kita masukkan air.', 40, 30, 3, 'uploads/th (1).jpeg', 'https://www.youtube.com/watch?v=LNkatkw7VN4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewID` int(11) NOT NULL,
  `RecipeID` int(11) DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Comment` text DEFAULT NULL,
  `ReviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`ReviewID`, `RecipeID`, `UserID`, `UserName`, `Rating`, `Comment`, `ReviewDate`) VALUES
(1, 8, 0, 'hafis', 5, 's', '2024-06-04 20:25:01'),
(2, 8, 0, 'jiua', 3, 'assda', '2024-06-04 21:15:46'),
(3, 9, 0, 'hafis', 3, 'uyguihg', '2024-06-05 05:21:12'),
(4, 9, 0, 'kkklkl', 5, 'njnjlo', '2024-06-05 05:22:11'),
(5, 10, 0, 'hafisfis', 5, 'sedap dan mudah', '2024-06-06 03:42:56'),
(6, 11, 0, 'we1', 3, 'sedap', '2024-06-12 14:28:09'),
(7, 12, 0, 'we1', 5, 'seappppp', '2024-06-12 14:39:20'),
(8, 12, 8, 'we1', 5, 'sssds', '2024-06-12 14:50:50'),
(9, 12, 8, 'we1', 3, 'SESAPPPPPPP', '2024-06-12 14:52:30'),
(10, 10, 8, 'we1', 4, 'besttt', '2024-06-12 15:34:47'),
(11, 10, 8, 'we1', 4, 'haii sedapnya', '2024-06-12 15:42:38'),
(12, 7, 10, 'nuryn', 4, 'so good and easy', '2024-06-13 02:32:06'),
(13, 11, 8, 'we1', 5, 'barang mudah didapati dan enak', '2024-06-13 02:37:33'),
(14, 10, 8, 'we1', 4, 'sedapp', '2024-06-13 03:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `Bio` text DEFAULT NULL,
  `UserType` enum('Admin','User') NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `ProfilePicture`, `Bio`, `UserType`, `Password`) VALUES
(6, 'hafis1', '', 'AA', 'User', '$2y$10$fl5gMibSW6h1HJ1Xxmk/TeNZtv.KTuC0OsDKX8ssl7aTbmZ9WufDC'),
(7, 'we', '', 'd', 'User', '$2y$10$SYrJhxU.r6ak7pmmljP5aum42x8Tijmdq4sKZYmKsxLw4JuC3gd9W'),
(8, 'we1', 'uploads/Screenshot (407).png', 'we1', 'User', '$2y$10$qwX.91IRgFGhXNBjRsDjb.IA3mkEtqIO5trtj.gsDKgPghc/YrOp.'),
(9, 'hafis', 'uploads/food3.jpg', 'Admin Michelin Star', 'Admin', '$2y$10$4wd7RInsF.HaPaeMRj9GEO.4/iy0dwFWTctWD4NV381GkcYcVZ3RW'),
(10, 'nuryn', 'uploads/updatehotelowner.png', 'just a ordinary 20 years old girl who learning how to cook', 'User', '$2y$10$PU2O51gUX72AibdLF51l0eVYuGKiSC0lCOPVYHOdvfCOOrLtqZcE6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`RecipeID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `RecipeID` (`RecipeID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `RecipeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
