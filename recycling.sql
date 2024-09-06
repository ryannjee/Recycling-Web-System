-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2023-03-28 08:28:59
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recycling`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`) VALUES
('admin@hotmail.com', '11111111');

-- --------------------------------------------------------

--
-- Table structure for table `recyclingform`
--

CREATE TABLE `recyclingform` (
  `SubmitID` int(8) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `member` varchar(8) NOT NULL,
  `saddress` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `paper` float NOT NULL,
  `plastic` float NOT NULL,
  `metal` float NOT NULL,
  `electronic` float NOT NULL,
  `wood` float NOT NULL,
  `glass` float NOT NULL,
  `clothes` float NOT NULL,
  `bricks` float NOT NULL,
  `picname` varchar(255) NOT NULL,
  `CurrentStatus` varchar(200) NOT NULL,
  `LastUpdated` varchar(200) NOT NULL,
  `point` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recyclingform`
--

INSERT INTO `recyclingform` (`SubmitID`, `fname`, `lname`, `email`, `phone`, `member`, `saddress`, `city`, `zip`, `country`, `date`, `time`, `paper`, `plastic`, `metal`, `electronic`, `wood`, `glass`, `clothes`, `bricks`, `picname`, `CurrentStatus`, `LastUpdated`, `point`) VALUES
(84, 'jiahengDashen', 'nghiiii', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2123', 'Kuala Lumpur', '12333', 'British', '2023-03-31', '12:54:00', 5, 5, 0, 0, 0, 0, 0, 0, 'pictures/117d1a4e1c4cab1e1589e4ba10b8b117.jpg', 'Departing', 'In Process', '2'),
(85, 'zheqian', 'wong', 'perth_0@Hotmail.com', '+60111111111', '', 'qwee2', 'klang', '12333', 'Indian', '2023-04-07', '12:42:00', 5, 5, 0, 0, 0, 0, 0, 0, 'pictures/f873124291d7c46cb3b0dcae1b79ad5e.png', '', '', '2'),
(86, 'zheqian', 'wong', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2123', 'Kota Kinabalu', '12333', 'Indian', '2023-03-18', '12:43:00', 5, 0, 0, 0, 0, 0, 0, 0, 'pictures/cab2df2cf7f88544cfa80baed79888d0.png', '', '', '1'),
(87, 'zheqian', 'gan', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2', 'Johor Bahru', '12333', 'German', '2023-03-25', '12:52:00', 5, 5, 5, 5, 5, 5, 5, 5, '', '', '', '0'),
(88, 'zheqian', 'gan', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2', 'Johor Bahru', '12333', 'German', '2023-03-25', '12:52:00', 5, 5, 5, 5, 5, 5, 5, 5, '', '', '', '21'),
(89, 'zheqian', 'gan', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2', 'Johor Bahru', '12333', 'German', '2023-03-25', '12:52:00', 5, 5, 5, 5, 5, 5, 5, 0, '', '', '', '16'),
(90, 'zheqian', 'ng', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2', 'Petaling Jaya', '12333', 'Malaysia', '2023-03-25', '12:56:00', 5, 5, 5, 5, 5, 5, 5, 5, 'pictures/e07837ea4844110cb6e925b41edb3416.jpg', '', '', '21'),
(91, 'zheqian', 'ng', '11@gmail.com', '+60111111111', '33', 'qwee2', 'Petaling Jaya', '12333', 'Australian', '2023-03-25', '12:56:00', 5, 5, 5, 5, 5, 5, 5, 5, 'pictures/99af86967650295bde516318f3d25d7e.png', '', '', '21'),
(92, 'zheqian', 'ng', 'perth_0@Hotmail.com', '+60111111111', '', 'qwee2', 'Melaka', '12111', 'British', '2023-03-24', '13:43:00', 5, 0, 0, 0, 0, 0, 0, 0, '', '', '', '1'),
(93, 'zheqian', 'ng', 'perth_0@Hotmail.com', '+60111111111', '', 'qwee2', 'Melaka', '12111', 'British', '2023-03-24', '13:43:00', 0, 0, 0, 0, 0, 0, 0, 5, '/pictures/515723cf21afdf3de9636fd5a6050531.jpg', '', '', '5'),
(94, 'zheqian', 'ng', 'perth_0@Hotmail.com', '+60111111111', '', 'qwee2', 'Melaka', '12111', 'British', '2023-03-24', '13:43:00', 0, 0, 0, 0, 0, 0, 0, 5, '/pictures/014a37084dfb2c1ec676036fdccfda86.jpg', '', '', '5'),
(95, 'looperth', 'wong', 'perth_0@Hotmail.com', '+60111111111', '', 'qwee2', 'Klang', '12333', 'German', '2023-03-24', '10:08:00', 5, 0, 0, 0, 0, 0, 0, 0, '/pictures/febdc9000e7a76d46d8194a7deb396e5.jpg', 'In Process', '', '1'),
(96, 'perth', 'loowogn', 'perth_@Hotmail.com', '+60111111111', '33', '5jalan 1111 sentosa', 'Kuala Lumpur', '12111', 'Malaysia', '2023-03-29', '14:15:00', 5, 0, 0, 0, 0, 0, 0, 0, '', '', '', '1'),
(97, 'perth', 'loowogn', 'perth_@Hotmail.com', '+60111111111', '33', '5jalan 1111 sentosa', 'Kuala Lumpur', '12111', 'Malaysia', '2023-03-29', '14:15:00', 5, 0, 0, 0, 0, 0, 0, 0, 'pictures/31d3ade21f22403002a85272c830ba37.jpg', '', '', '1'),
(98, 'perth', 'loowogn', 'perth_0@Hotmail.com', '+60111111111', '33', '5jalan 1111 sentosa', 'Kuala Lumpur', '12111', 'Malaysia', '2023-03-29', '14:15:00', 5, 0, 0, 0, 0, 0, 0, 0, 'pictures/b2cf233c8abf9fc1ef48b07018955bca.jpg', '', '', '1'),
(99, 'zheqian', 'ng', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2', 'Penang', '12333', 'French', '2023-03-28', '16:58:00', 5, 0, 0, 0, 0, 0, 0, 0, 'pictures/3b14fa6484be53365b48b93b5ddd740a.jpg', '', '', '1'),
(100, 'zheqian', 'ng', 'perth_0@Hotmail.com', '+60111111111', '33', 'qwee2', 'Klang', '12333', 'Chinese', '2023-04-01', '16:03:00', 2, 0, 0, 0, 0, 0, 0, 0, 'pictures/d91a21f6781fdf80fe94f5c8539d86f8.jpg', '', '', '0'),
(101, 'zheqian', 'ng', 'perth_0@Hotmail.com', '+60111111111', '', 'qwee2', 'Penang', '12333', 'German', '2023-03-30', '15:13:00', 5, 0, 0, 0, 0, 0, 0, 0, '/pictures/438273db33b9fe97663529a407f0f248.jpg', '', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zipcode` varchar(120) NOT NULL,
  `country` varchar(50) NOT NULL,
  `picname` text NOT NULL,
  `point` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password`, `fname`, `lname`, `contact`, `address`, `city`, `zipcode`, `country`, `picname`, `point`) VALUES
(33, 'JiahengDashen', 'perth_0@hotmail.com', '$2y$10$RlT3GEbY8EDnyvdo112AVe6YTvbztlwob3hoTBJBYy8tKlsTHIoZy', 'JiahengDashen', 'ng', '+60111111111', '5jalan 1111 sentosa', 'Kuala Lumpur', '11112', 'Australian', 'pictures/4c469d78b52e55c9bfa4ac1c4512f3da.jpg', ''),
(34, 'perth', '11@gmail.com', '$2y$10$ZskYNdLbZ781FLTGMkfV5.ysKiVFZ5EyuLXTbMj3ScQU6.sH5AcNe', 'zheqian', 'ng', '+601133500549', 'Perth', 'Klang', '11111', 'German', 'pictures/face.png', ''),
(35, 'perth', '121@gmail.com', '$2y$10$01G94ITDANqH/TdGbuCo3ujBxhaS8kSnPzGf85A0RjO3SJdhWh/Qu', 'zheqian', 'ng', '+601133500549', 'Perth', 'Melaka', '11111', 'Indian', 'pictures/face.png', ''),
(36, 'perth', '1211@gmail.com', '$2y$10$rtMCKDrpf6z.fFA74EYeleMVgQLcKLzrPFidOclbf5erLHKuElIvK', 'zheqian', 'ng', '+601133500549', 'Perth', 'Klang', '11111', 'American', 'pictures/face.png', ''),
(37, 'perth ', '11323@gmail.com', '$2y$10$usRx8OUWl3Si8gICh8aRQ.o6m3OzUdfo78z7UNkcO89YEUg.LY1z.', 'zheqian', 'ng', '+601133500549', 'Perth', 'Melaka', '11111', 'Japanese', 'pictures/face.png', ''),
(38, 'perth', 'perth_10@hotmail.com', '$2y$10$nrqLPbSpabjPN0dZwSefI.xPmtKjX29VyRogdl3FhHRiYHWpka3c.', 'zheqian', 'gan', '+601133500549', 'Perth', 'Johor Bahru', '11111', 'Indian', 'pictures/face.png', ''),
(40, 'hello ', 'pert23h_0@hotmail.com', '$2y$10$0I8OldYXuv4AiEw3YjUFweQKYTEoqOx7NF7vTH1nIw5VNV3SEx9oW', 'asd', 'ryanDashen', '+6011-33500549', '5jalan 1111 sentosa', 'Kuala Lumpur', '12312', 'Canadian', 'pictures/face.png', ''),
(44, 'perth', '11123@gmail.com', '$2y$10$21AL4GiFgGfjwJgr/4Dpn.udxwnRahphNVadRkvc6EiKyPnvYzdnW', 'zheqian', 'ng', '+601133500549', 'Perth', 'Melaka', '11111', 'Malaysian', 'pictures/face.png', ''),
(45, 'perth', '1112@gmail.com', '$2y$10$D1xwJBqCCg5KPXG.1o.Z9eAgSG8WMyrKxvDuV8ZBBYLa7iYX94IN.', 'zheqian', 'ng', '+601133500549', 'Perth', 'Melaka', '11111', 'Chinese', 'pictures/face.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `recyclingform`
--
ALTER TABLE `recyclingform`
  ADD PRIMARY KEY (`SubmitID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recyclingform`
--
ALTER TABLE `recyclingform`
  MODIFY `SubmitID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
