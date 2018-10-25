-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2018 at 05:24 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotify`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkpath` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `artworkpath`) VALUES
(1, 'The Essential MC', 1, 1, 'assets/images/artwork/image1.jpg'),
(2, 'The Very Best of DW', 2, 2, 'assets/images/artwork/image2.jpg'),
(3, 'Song of the Bird', 3, 3, 'assets/images/artwork/image3.jpg'),
(4, 'Best of 2013', 4, 4, 'assets/images/artwork/image4.jpg'),
(5, 'Living Legend', 5, 4, 'assets/images/artwork/image5.jpg'),
(6, 'Maya Murali', 6, 3, 'assets/images/artwork/image6.jpg'),
(7, 'Into the Light', 7, 5, 'assets/images/artwork/image7.jpg'),
(8, 'Bensound', 8, 5, 'assets/images/artwork/image8.png');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Mariah Carey'),
(2, 'Don Williams'),
(3, 'Pablo Casals'),
(4, 'Vishal Dadlani'),
(5, 'Lata Mangeshkar'),
(6, 'K Janardhanan'),
(7, 'Chris de Burgh'),
(8, 'Pantomime');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Jazz'),
(2, 'Country'),
(3, 'Classical'),
(4, 'Bollywood'),
(5, 'Pop');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `owner`, `dateCreated`) VALUES
(2, 'hansPlay', 'hans2018', '2018-02-14 17:40:53'),
(10, 'maya1', 'maya18', '2018-02-14 20:12:25'),
(11, 'myMusic', 'maya18', '2018-02-14 20:16:05'),
(12, 'track', 'maya18', '2018-02-14 20:34:10'),
(13, 'teaParty', 'hans2018', '2018-02-14 00:00:00'),
(14, 'Playlist-1', 'ammu2019', '2018-02-20 00:00:00'),
(15, 'playlist-2', 'ammu2019', '2018-02-26 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `playlistSongs`
--

CREATE TABLE `playlistSongs` (
  `id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `playlistSongs`
--

INSERT INTO `playlistSongs` (`id`, `songId`, `playlistId`, `playlistOrder`) VALUES
(41, 2, 10, 1),
(42, 4, 10, 2),
(43, 4, 10, 3),
(44, 7, 10, 4),
(45, 6, 11, 1),
(46, 2, 12, 1),
(47, 8, 2, 1),
(48, 1, 13, 1),
(49, 9, 14, 1),
(50, 4, 14, 2),
(51, 6, 14, 3),
(52, 3, 14, 4),
(53, 9, 15, 1),
(54, 10, 15, 2),
(55, 11, 15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`) VALUES
(1, 'Hero', 1, 1, 1, '2:34', 'assets/music/bensound-betterdays.mp3', 1, 45),
(2, 'You are my best friend', 2, 2, 2, '2:27', 'assets/music/bensound-enigmatic.mp3', 2, 55),
(3, 'El Cant Des Ocells', 3, 3, 3, '3:24', 'assets/music/bensound-instinct.mp3', 1, 39),
(4, 'Balam Pichkari', 4, 4, 4, '1:46', 'assets/music/bensound-jazzyfrenchy.mp3', 1, 61),
(5, 'Besharam', 4, 4, 4, '5:36', 'assets/music/bensound-love.mp3', 2, 56),
(6, 'Yeh Zindagi', 5, 5, 4, '3:32', 'assets/music/bensound-november.mp3', 2, 34),
(7, 'The Cradle Song', 6, 6, 3, '2:57', 'assets/music/bensound-psychedelic.mp3', 3, 44),
(8, 'The lady in red', 7, 7, 5, '2:29', 'assets/music/bensound-sadday.mp3', 4, 37),
(9, 'Little Idea', 8, 8, 5, '2:49', 'assets/music/bensound-littleidea.mp3', 1, 79),
(10, 'Energy', 8, 8, 5, '3:00', 'assets/music/bensound-energy.mp3', 2, 59),
(11, 'Ukulele', 8, 8, 5, '2:26', 'assets/music/bensound-ukulele.mp3', 3, 58);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL,
  `username` varchar(25) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `profilePic` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `password`, `signUpDate`, `profilePic`) VALUES
(7, 'ammu2019', 'Ammu', 'Varma', 'me@ammu.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2018-02-14 00:00:00', 'assets/images/profile-pics/profile-pic.jpeg'),
(8, 'hans2018', 'Hans', 'Stapersma', 'you@mail.com', '3ca35b768e98e0c9963b82473b90018b', '2018-02-14 00:00:00', 'assets/images/profile-pics/profile-pic.jpeg'),
(9, 'maya18', 'Maya', 'Varma', 'maya@maya.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2018-02-14 00:00:00', 'assets/images/profile-pics/profile-pic.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistSongs`
--
ALTER TABLE `playlistSongs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `playlistSongs`
--
ALTER TABLE `playlistSongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
