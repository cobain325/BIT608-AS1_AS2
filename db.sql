-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 24, 2023 at 12:44 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motueka`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int NOT NULL,
  `room` int NOT NULL,
  `checkIn` datetime NOT NULL,
  `checkOut` datetime NOT NULL,
  `customer` int NOT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `extras` varchar(255) DEFAULT NULL,
  `review` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `room`, `checkIn`, `checkOut`, `customer`, `contactNumber`, `extras`, `review`) VALUES
(1, 2, '2023-07-13 14:00:00', '2023-07-27 10:00:00', 1, '+64 12 345 6789', '123456', ''),
(2, 1, '2023-07-13 14:00:00', '2023-07-27 10:00:00', 1, '123345678', '\' OR 1/0; --', ''),
(3, 2, '2023-03-16 00:00:00', '2023-03-19 00:00:00', 20, '123', '', NULL),
(4, 2, '2023-03-23 00:00:00', '2023-03-26 00:00:00', 20, '123', '', NULL),
(5, 12, '2023-03-23 00:00:00', '2023-03-26 00:00:00', 20, '123', '', NULL),
(6, 10, '2023-03-25 00:00:00', '2023-03-30 00:00:00', 20, '2313', 'rettrerg', NULL),
(7, 10, '2023-03-25 00:00:00', '2023-03-30 00:00:00', 20, '2313', 'rettrerg', NULL),
(8, 10, '2023-03-25 00:00:00', '2023-03-30 00:00:00', 20, '2313', 'rettrerg', NULL),
(9, 8, '2023-03-17 00:00:00', '2023-03-30 00:00:00', 20, '56564', '', NULL),
(10, 8, '2023-03-17 00:00:00', '2023-03-30 00:00:00', 20, '56564', '', NULL),
(11, 8, '2023-03-17 00:00:00', '2023-03-30 00:00:00', 20, '56564', '', NULL),
(12, 6, '2023-03-18 14:00:00', '2023-03-31 10:00:00', 1, '56564', '', ''),
(13, 8, '2023-03-17 00:00:00', '2023-03-30 00:00:00', 20, '56564', '', NULL),
(14, 2, '2023-03-17 00:00:00', '2023-04-01 00:00:00', 20, '12312', '', NULL),
(15, 2, '2023-03-17 00:00:00', '2023-04-01 00:00:00', 20, '12312', '', NULL),
(16, 13, '2023-02-08 00:00:00', '2023-03-31 00:00:00', 2, '123', '', NULL),
(17, 7, '2023-03-20 14:00:00', '2023-03-23 10:00:00', 1, '0271234567', '', ''),
(19, 8, '2023-05-26 14:00:00', '2023-05-27 10:00:00', 8, '56564', '', NULL),
(20, 5, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(21, 1, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(22, 2, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(23, 3, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123123', '', NULL),
(24, 4, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(25, 6, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(26, 7, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(27, 8, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(28, 9, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(29, 10, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(30, 11, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(31, 12, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(32, 13, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL),
(33, 14, '2023-05-05 14:00:00', '2023-05-05 10:00:00', 8, '123', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.com', '$2y$10$UPLpHU/Hsr12gkO14z7yaOmOjPeUZ6UNZFvRxfRvF6hYR6jjMDuTi'),
(2, 'Desiree', 'Collier', 'Maecenas@non.co.uk', '$2y$10$fBrK2EIrWPvWcYvs6H1kQuG.KeA4UqIuAPEBsfy/WFxbJfsZ44FvG'),
(3, 'Irene', 'Walker', 'id.erat.Etiam@id.org', '.'),
(4, 'Forrest', 'Baldwin', 'eget.nisi.dictum@a.com', '.'),
(5, 'Beverly', 'Sellers', 'ultricies.sem@pharetraQuisqueac.co.uk', '.'),
(6, 'Glenna', 'Kinney', 'dolor@orcilobortisaugue.org', '.'),
(7, 'Montana', 'Gallagher', 'sapien.cursus@ultriciesdignissimlacus.edu', '.'),
(8, 'Harlan', 'Lara', 'Duis@aliquetodioEtiam.edu', '$2y$10$ez6.fc8w/T7./RjlYohFwuq/Q4wjh/fpye9Tr9zBxqoen6Bh1QCYy'),
(9, 'Benjamin', 'King', 'mollis@Nullainterdum.org', '.'),
(10, 'Rajah', 'Olsen', 'Vestibulum.ut.eros@nequevenenatislacus.ca', '.'),
(11, 'Castor', 'Kelly', 'Fusce.feugiat.Lorem@porta.co.uk', '.'),
(12, 'Omar', 'Oconnor', 'eu.turpis@auctorvelit.co.uk', '$2y$10$6vWlqi/RkasQTcs28CyXb.u9LBqh7H.RVgXYedCsSGUWop6gUkB4.'),
(13, 'Porter', 'Leonard', 'dui.Fusce@accumsanlaoreet.net', '.'),
(14, 'Buckminster', 'Gaines', 'convallis.convallis.dolor@ligula.co.uk', '.'),
(15, 'Hunter', 'Rodriquez', 'ridiculus.mus.Donec@est.co.uk', '.'),
(16, 'Zahir', 'Harper', 'vel@estNunc.com', '.'),
(17, 'Sopoline', 'Warner', 'vestibulum.nec.euismod@sitamet.co.uk', '.'),
(18, 'Burton', 'Parrish', 'consequat.nec.mollis@nequenonquam.org', '.'),
(19, 'Abbot', 'Rose', 'non@et.ca', '.'),
(20, 'Barry', 'Burks', 'risus@libero.net', '$2y$10$b.XDZ8fhTc.LRq.YhoP0ZOFxtR4L8VrQaSmlZ2QN9k8eaCdrf03Ea');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` int UNSIGNED NOT NULL,
  `roomname` varchar(100) NOT NULL,
  `description` text,
  `roomtype` char(1) DEFAULT 'D',
  `beds` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `roomname`, `description`, `roomtype`, `beds`) VALUES
(1, 'Kellie', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing', 'S', 5),
(2, 'Herman', 'Lorem ipsum dolor sit amet, consectetuer', 'D', 5),
(3, 'Scarlett', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 'D', 2),
(4, 'Jelani', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam', 'S', 2),
(5, 'Sonya', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.', 'S', 5),
(6, 'Miranda', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 'S', 4),
(7, 'Helen', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.', 'S', 2),
(8, 'Octavia', 'Lorem ipsum dolor sit amet,', 'D', 3),
(9, 'Gretchen', 'Lorem ipsum dolor sit', 'D', 3),
(10, 'Bernard', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer', 'S', 5),
(11, 'Dacey', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 'D', 2),
(12, 'Preston', 'Lorem', 'D', 2),
(13, 'Dane', 'Lorem ipsum dolor', 'S', 4),
(14, 'Cole', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam', 'S', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `roomID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
