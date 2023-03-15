-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2023 at 10:28 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL DEFAULT '.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `firstname`, `lastname`, `email`, `password`) VALUES
(2, 'Desiree', 'Collier', 'Maecenas@non.co.uk', '.'),
(3, 'Irene', 'Walker', 'id.erat.Etiam@id.org', '.'),
(4, 'Forrest', 'Baldwin', 'eget.nisi.dictum@a.com', '.'),
(5, 'Beverly', 'Sellers', 'ultricies.sem@pharetraQuisqueac.co.uk', '.'),
(6, 'Glenna', 'Kinney', 'dolor@orcilobortisaugue.org', '.'),
(7, 'Montana', 'Gallagher', 'sapien.cursus@ultriciesdignissimlacus.edu', '.'),
(8, 'Harlan', 'Lara', 'Duis@aliquetodioEtiam.edu', '.'),
(9, 'Benjamin', 'King', 'mollis@Nullainterdum.org', '.'),
(10, 'Rajah', 'Olsen', 'Vestibulum.ut.eros@nequevenenatislacus.ca', '.'),
(11, 'Castor', 'Kelly', 'Fusce.feugiat.Lorem@porta.co.uk', '.'),
(12, 'Omar', 'Oconnor', 'eu.turpis@auctorvelit.co.uk', '.'),
(13, 'Porter', 'Leonard', 'dui.Fusce@accumsanlaoreet.net', '.'),
(14, 'Buckminster', 'Gaines', 'convallis.convallis.dolor@ligula.co.uk', '.'),
(15, 'Hunter', 'Rodriquez', 'ridiculus.mus.Donec@est.co.uk', '.'),
(16, 'Zahir', 'Harper', 'vel@estNunc.com', '.'),
(17, 'Sopoline', 'Warner', 'vestibulum.nec.euismod@sitamet.co.uk', '.'),
(18, 'Burton', 'Parrish', 'consequat.nec.mollis@nequenonquam.org', '.'),
(19, 'Abbot', 'Rose', 'non@et.ca', '.'),
(20, 'Barry', 'Burks', 'risus@libero.net', '.');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  MODIFY `bookingID` int NOT NULL AUTO_INCREMENT;

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
