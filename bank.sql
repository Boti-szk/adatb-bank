-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Nov 26. 22:57
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `bank`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `birtokolja`
--

CREATE TABLE `birtokolja` (
  `azonosito` varchar(20) NOT NULL,
  `szamlaszam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `birtokolja`
--

INSERT INTO `birtokolja` (`azonosito`, `szamlaszam`) VALUES
('2', 18),
('2', 19),
('2', 20),
('11', 18),
('19', 18),
('20', 20),
('14', 20),
('9', 18),
('5', 19),
('4', 18),
('4', 21),
('4', 22),
('4', 23),
('4', 24),
('2', 18),
('5', 21),
('5', 25),
('5', 26),
('5', 27),
('2', 25),
('4', 27),
('16', 19),
('14', 21),
('5', 29),
('4', 30),
('4', 31),
('2', 32),
('22', 34),
('12', 35),
('16', 35),
('5', 34),
('1', 36),
('1', 37),
('1', 38),
('3', 39),
('3', 40),
('3', 41),
('5', 47),
('22', 19),
('15', 27),
('12', 27),
('9', 47),
('22', 18),
('16', 24),
('11', 31);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `azonosito` varchar(20) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `jelszo` varchar(100) NOT NULL,
  `bejelentkezve` tinyint(1) NOT NULL,
  `utolso_belepes_idopontja` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `szerepkor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`azonosito`, `nev`, `jelszo`, `bejelentkezve`, `utolso_belepes_idopontja`, `szerepkor`) VALUES
('1', 'admin', '$2y$10$c5wOFhqbzFdX3RfC8bX9seFOUicSaZM/Y5r.wYdgmEYARSUXGYSay', 1, '2023-11-26 20:24:13', 'alkalmazott'),
('10', 'Kocsis Lilla', '$2y$10$7M78rd2D5BpTNrHDxCP.heysntinA21BtB0SLRSmTdFByQKQ3Vd9.', 0, '2023-11-25 18:00:47', 'alkalmazott'),
('11', 'Boros Dániel Máté', '$2y$10$CYW76HHlxCvI4Wnxayq/yu9M6lJlNj4zTcyjgBTkqPd8S/lBzVUMW', 0, '2023-11-25 18:01:24', 'ugyfel'),
('12', 'Barna Rebeka', '$2y$10$WyUiEBxFgyxK5NuLAiCTIeRo/bi0xo7lTpA0nYYibv0X9C/n5/6K6', 0, '2023-11-25 18:01:53', 'ugyfel'),
('13', 'Nemes Dániel', '$2y$10$/W6blFqYVDaMaJxmco0kVOKXCqMVfpJDeU4gMvuFGI3pifx8urDtS', 0, '2023-11-25 18:02:34', 'alkalmazott'),
('14', 'Barna Izabella', '$2y$10$lrE3/lB/LHIcQinNnGY2HeORRIChOWWyg5cx1nC4Pyatmw.xKVTn2', 0, '2023-11-25 18:04:06', 'ugyfel'),
('15', 'Horváth Gábor', '$2y$10$1Ylu5wQBTrmib7RWfj7NDuDW3ehDL5God4VEvCz4gPwQwHjC1aZem', 0, '2023-11-25 18:04:35', 'ugyfel'),
('16', 'Péter Dorina Mária', '$2y$10$BP2j2nPfY6JVefQyEPrwl.L83ag/nJceYKmJHI9B2sLUq2OFWo0DK', 0, '2023-11-25 18:04:54', 'ugyfel'),
('17', 'Kende Domonkos', '$2y$10$FkXYrvXeWUtbHVSRPGgGUOMpdIrg3OvwTaFJ1k/WFnr/Gim9qDu42', 0, '2023-11-25 18:05:35', 'alkalmazott'),
('18', 'Halász Ivett', '$2y$10$6nsU9cKwNQuppVtzo8Ea4eIFVa8llCYYFBGHYOMggNMRdQZOctSEC', 0, '2023-11-25 18:06:19', 'ugyfel'),
('19', 'Kovács Ferenc', '$2y$10$1nxQsJrTQeyfz9W7xtzJ6ul9XCRR3XQffZD5TGZw4irjeehrApXxO', 0, '2023-11-25 18:06:45', 'ugyfel'),
('2', 'user', '$2y$10$37eFFWY6wyGKPiagxUo06OSCVljctqun0U/O/LcJBPM6jeqCaN1dC', 0, '2023-11-25 22:10:20', 'ugyfel'),
('20', 'Fodor Géza', '$2y$10$LPQ1j2tuYxV7I1Cf0lxKt.y1PbrKN0MceXsWMhsIG1hOUu2rDlog6', 0, '2023-11-25 18:07:36', 'ugyfel'),
('21', 'Takács Alex', '$2y$10$hqtG590qEERuSmgsFNeiieYXW.9iZlD2nFWSdh2VPoNLjYoKb9P0i', 0, '2023-11-25 18:13:07', 'alkalmazott'),
('22', 'Balogh Olivér', '$2y$10$g8vRDfsdJ2DRQgQej.svT.MB2FcLWi5WuoE7Dv.W1b27eCyqxniXe', 0, '2023-11-25 18:13:33', 'ugyfel'),
('23', 'Szűts Liliána', '$2y$10$D7qbpHrXvSF4oxVyKs9LfuFa.kEpWrLDelRZfZ83MZ0mj7HXKmjca', 0, '2023-11-25 18:14:15', 'alkalmazott'),
('24', 'Bálint Csanád', '$2y$10$8rMTJmgYQrjvDoq0RRgb5OLhjmnXzhR4CCRlsKDvDLsTlLnIOyOu6', 0, '2023-11-25 18:15:18', 'alkalmazott'),
('3', 'Fodor Géza', '$2y$10$JJ4YA91YN48gm2fFcSj/.ulyky6W6cxEBFQyq37RWbwqZDOccYBKa', 0, '2023-11-25 22:12:41', 'alkalmazott'),
('4', 'Balla Edina', '$2y$10$.uaRuwCd4WbOoB.ZFNY6HOToJ3jsQO6R4UnWrhB6E97A7ZRFv9Zk2', 0, '2023-11-25 22:08:48', 'ugyfel'),
('5', 'Magyar Mihály', '$2y$10$hnt4L0RVpktRQl.mW1Pc7u7TS5nfeyRoMgI3WrpI3.53bFzjnyNVK', 0, '2023-11-25 22:07:40', 'ugyfel'),
('6', 'Máté Ágnes', '$2y$10$Nq7ujnjoY6hbdK1qZ29KeO593YwCvF3GhfjDX7CHMWRja1aRt3QPW', 0, '2023-11-25 17:58:57', 'ugyfel'),
('7', 'Gál Sándor', '$2y$10$EIo9NDpD9XrFCUyQh6cL3e63af9U20IO/GYDIkE48lXh/5BrpQrE2', 0, '2023-11-25 17:59:19', 'ugyfel'),
('8', 'Orosz Réka', '$2y$10$9WiSfbeYGrFE7wIi46p4BumEM/vhcFRd9sqYrsUgW4l/W3WClnbJi', 0, '2023-11-25 18:24:58', 'alkalmazott'),
('9', 'Kovács Dávid', '$2y$10$.dGqzYxTYpUjJxiItIgOne3LtabioJeqvgCwSfcnb9nw8CNT/XFW2', 0, '2023-11-25 18:00:28', 'ugyfel');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `folyoszamlak`
--

CREATE TABLE `folyoszamlak` (
  `szamlaszam` int(11) NOT NULL,
  `egyenleg` decimal(20,0) NOT NULL,
  `mikor_nyitottak` timestamp NOT NULL DEFAULT current_timestamp(),
  `zarolva_van` varchar(10) NOT NULL DEFAULT 'nyitva',
  `tipus_azonosito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `folyoszamlak`
--

INSERT INTO `folyoszamlak` (`szamlaszam`, `egyenleg`, `mikor_nyitottak`, `zarolva_van`, `tipus_azonosito`) VALUES
(18, 0, '2023-11-25 18:28:31', 'zarva', 4),
(19, 14123, '2023-11-25 18:28:48', 'zarva', 6),
(20, 97978, '2023-11-25 18:28:55', 'nyitva', 8),
(21, 0, '2023-11-25 18:46:07', 'nyitva', 8),
(22, 4921, '2023-11-25 18:46:12', 'nyitva', 8),
(23, 13126, '2023-11-25 18:46:16', 'zarva', 6),
(24, 0, '2023-11-25 18:46:21', 'nyitva', 4),
(25, 60514, '2023-11-25 18:48:33', 'nyitva', 5),
(26, 28491, '2023-11-25 18:48:38', 'zarva', 7),
(27, 100, '2023-11-25 18:48:43', 'nyitva', 4),
(29, 191, '2023-11-25 18:50:26', 'nyitva', 6),
(30, 15294, '2023-11-25 18:51:02', 'zarva', 5),
(31, 0, '2023-11-25 18:51:06', 'zarva', 5),
(32, 0, '2023-11-25 18:51:44', 'nyitva', 7),
(33, 11080, '2023-11-25 19:11:19', 'nyitva', 9),
(34, 56994, '2023-11-25 19:11:24', 'zarva', 5),
(35, 8172, '2023-11-25 19:11:27', 'nyitva', 6),
(36, 7157, '2023-11-25 19:15:03', 'nyitva', 7),
(37, 543255, '2023-11-25 19:15:09', 'zarva', 9),
(38, 27181, '2023-11-25 19:15:16', 'nyitva', 6),
(39, 3681, '2023-11-25 21:27:22', 'nyitva', 6),
(40, 42882, '2023-11-25 21:27:28', 'nyitva', 9),
(41, 29890, '2023-11-25 21:27:32', 'nyitva', 9),
(43, 22009, '2023-11-25 21:28:13', 'nyitva', 9),
(44, 4673, '2023-11-25 21:28:18', 'nyitva', 7),
(47, 0, '2023-11-25 21:34:47', 'zarva', 7);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szamlatipusok`
--

CREATE TABLE `szamlatipusok` (
  `tipus_azonosito` int(11) NOT NULL,
  `szamlatipus_neve` varchar(100) NOT NULL,
  `mettol_van_ervenyben` datetime NOT NULL,
  `meddig_van_ervenyben` datetime NOT NULL,
  `allapot` varchar(10) NOT NULL DEFAULT 'aktiv'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `szamlatipusok`
--

INSERT INTO `szamlatipusok` (`tipus_azonosito`, `szamlatipus_neve`, `mettol_van_ervenyben`, `meddig_van_ervenyben`, `allapot`) VALUES
(4, 'Folyószámla', '2020-01-01 00:00:00', '2023-12-28 00:00:00', 'passziv'),
(5, 'Devizaszámla', '2023-11-25 19:17:00', '2024-01-01 19:18:00', 'aktiv'),
(6, 'Gyermekszámla', '2023-11-21 19:18:00', '2025-07-15 19:18:00', 'aktiv'),
(7, 'Hitelszámla', '2023-11-01 19:18:00', '2030-12-31 00:00:00', 'aktiv'),
(8, 'Letéti számla', '2023-11-27 00:00:00', '2024-01-01 00:00:00', 'passziv'),
(9, 'Értékpapírszámla', '2023-11-16 20:05:00', '2023-12-17 20:05:00', 'aktiv'),
(10, 'Megtakarítási számla ', '2023-11-13 20:05:00', '2024-02-01 20:05:00', 'passziv');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `utalasok`
--

CREATE TABLE `utalasok` (
  `utalas_azonositoja` int(11) NOT NULL,
  `azonosito` varchar(20) NOT NULL,
  `idopontja` timestamp NOT NULL DEFAULT current_timestamp(),
  `atutalas_osszege` decimal(20,0) NOT NULL,
  `teljesitesi_hatarido` datetime NOT NULL,
  `sikerult` varchar(5) NOT NULL,
  `forras_szamlaszam` int(11) NOT NULL,
  `cel_szamlaszam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `utalasok`
--

INSERT INTO `utalasok` (`utalas_azonositoja`, `azonosito`, `idopontja`, `atutalas_osszege`, `teljesitesi_hatarido`, `sikerult`, `forras_szamlaszam`, `cel_szamlaszam`) VALUES
(102, '5', '2020-12-19 22:06:52', 1000, '2020-12-22 23:06:52', 'nem', 21, 34),
(103, '5', '2023-11-25 22:07:00', 12344, '2023-11-28 23:07:00', 'igen', 25, 38),
(104, '5', '2023-09-12 21:07:08', 1231, '2023-09-15 23:07:08', 'nem', 29, 24),
(105, '5', '2023-11-16 22:07:21', 100, '2023-11-19 23:07:21', 'igen', 29, 21),
(106, '5', '2023-11-02 22:07:30', 1201, '2023-11-05 23:07:30', 'igen', 25, 41),
(107, '4', '2022-05-04 21:08:11', 200, '2022-05-07 23:08:11', 'igen', 21, 38),
(108, '4', '2023-10-05 21:08:19', 33056, '2023-10-08 23:08:19', 'igen', 24, 32),
(109, '4', '2023-10-09 21:08:28', 3484, '2023-10-12 23:08:28', 'igen', 27, 40),
(110, '4', '2022-03-23 22:08:36', 99986, '2022-03-26 23:08:36', 'nem', 27, 26),
(111, '4', '2022-02-09 22:08:44', 10000, '2022-02-12 23:08:44', 'nem', 21, 37),
(112, '2', '2020-10-07 21:09:17', 12957, '2020-10-10 23:09:17', 'igen', 20, 40),
(113, '2', '2023-01-31 22:09:23', 5436, '2023-02-03 23:09:23', 'igen', 32, 23),
(114, '2', '2021-04-16 21:09:32', 3986, '2021-04-19 23:09:32', 'igen', 25, 35),
(115, '2', '2023-05-10 21:09:59', 1373, '2023-05-13 23:09:59', 'nem', 32, 29),
(116, '2', '2021-12-16 22:10:08', 645, '2021-12-19 23:10:08', 'igen', 25, 34),
(117, '2', '2020-12-15 22:10:18', 4327, '2020-12-18 23:10:18', 'nem', 32, 18),
(118, '3', '2021-04-06 21:11:35', 542, '2021-04-09 23:11:35', 'nem', 18, 26),
(119, '3', '2023-06-26 21:11:42', 7647, '2023-06-29 23:11:42', 'igen', 44, 30),
(120, '3', '2020-12-05 22:11:50', 436788, '2020-12-08 23:11:50', 'nem', 33, 36),
(121, '3', '2023-08-01 21:11:58', 321, '2023-08-04 23:11:58', 'nem', 47, 19),
(122, '3', '2023-08-17 21:12:05', 123, '2023-08-20 23:12:05', 'igen', 26, 20),
(123, '3', '2020-09-09 21:12:11', 56898, '2020-09-12 23:12:11', 'nem', 32, 36),
(124, '3', '2021-11-10 22:12:20', 4356, '2021-11-13 23:12:20', 'igen', 23, 34),
(125, '1', '2023-09-14 21:15:15', 1274, '2023-09-17 23:15:15', 'nem', 31, 27),
(126, '1', '2022-12-03 22:15:21', 43, '2022-12-06 23:15:21', 'igen', 36, 41),
(127, '1', '2023-03-10 22:15:28', 456, '2023-03-13 23:15:28', 'igen', 27, 41),
(128, '1', '2023-03-31 21:15:36', 7645, '2023-04-03 23:15:36', 'nem', 18, 34),
(129, '1', '2022-10-21 21:16:10', 10000, '2022-10-24 23:16:10', 'igen', 43, 20),
(130, '1', '2023-11-25 22:16:20', 321, '2023-11-28 23:16:20', 'igen', 25, 26),
(131, '1', '2023-11-01 22:16:36', 20000, '2023-11-04 23:16:36', 'nem', 19, 18);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `birtokolja`
--
ALTER TABLE `birtokolja`
  ADD KEY `birtokolja_ibfk_1` (`azonosito`),
  ADD KEY `birtokolja_ibfk_2` (`szamlaszam`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`azonosito`);

--
-- A tábla indexei `folyoszamlak`
--
ALTER TABLE `folyoszamlak`
  ADD PRIMARY KEY (`szamlaszam`),
  ADD KEY `tipus_azonosito` (`tipus_azonosito`);

--
-- A tábla indexei `szamlatipusok`
--
ALTER TABLE `szamlatipusok`
  ADD PRIMARY KEY (`tipus_azonosito`);

--
-- A tábla indexei `utalasok`
--
ALTER TABLE `utalasok`
  ADD PRIMARY KEY (`utalas_azonositoja`),
  ADD KEY `azonosito` (`azonosito`),
  ADD KEY `forras_szamlaszam` (`forras_szamlaszam`),
  ADD KEY `cel_szamlaszam` (`cel_szamlaszam`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `folyoszamlak`
--
ALTER TABLE `folyoszamlak`
  MODIFY `szamlaszam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT a táblához `szamlatipusok`
--
ALTER TABLE `szamlatipusok`
  MODIFY `tipus_azonosito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `utalasok`
--
ALTER TABLE `utalasok`
  MODIFY `utalas_azonositoja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `birtokolja`
--
ALTER TABLE `birtokolja`
  ADD CONSTRAINT `birtokolja_ibfk_1` FOREIGN KEY (`azonosito`) REFERENCES `felhasznalok` (`azonosito`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `birtokolja_ibfk_2` FOREIGN KEY (`szamlaszam`) REFERENCES `folyoszamlak` (`szamlaszam`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Megkötések a táblához `folyoszamlak`
--
ALTER TABLE `folyoszamlak`
  ADD CONSTRAINT `folyoszamlak_ibfk_1` FOREIGN KEY (`tipus_azonosito`) REFERENCES `szamlatipusok` (`tipus_azonosito`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Megkötések a táblához `utalasok`
--
ALTER TABLE `utalasok`
  ADD CONSTRAINT `utalasok_ibfk_1` FOREIGN KEY (`azonosito`) REFERENCES `felhasznalok` (`azonosito`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `utalasok_ibfk_2` FOREIGN KEY (`forras_szamlaszam`) REFERENCES `folyoszamlak` (`szamlaszam`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `utalasok_ibfk_3` FOREIGN KEY (`cel_szamlaszam`) REFERENCES `folyoszamlak` (`szamlaszam`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
