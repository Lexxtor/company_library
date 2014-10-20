-- phpMyAdmin SQL Dump
-- version 4.2.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2014 at 03:06 PM
-- Server version: 5.6.21-log
-- PHP Version: 5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test_lib`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `date_inserted`, `date_updated`) VALUES
(1, 'Ascold', '2014-10-17 10:27:57', '2014-10-18 14:45:49'),
(2, 'Dementio', '2014-10-17 10:28:03', '2014-10-18 14:46:02'),
(3, 'Пушкин', '2014-10-17 10:28:16', NULL),
(4, 'Лермантов', '2014-10-17 10:28:50', NULL),
(5, 'Филатов', '2014-10-17 10:29:00', NULL),
(6, 'Фомкин', '2014-10-18 12:20:45', NULL),
(7, 'Писарев', '2014-10-18 12:20:56', NULL),
(8, 'Нагиев', '2014-10-18 12:21:09', NULL),
(9, 'Ямочкин', '2014-10-18 17:55:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `reader_id` int(11) unsigned DEFAULT NULL,
  `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `count_authors` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `reader_id`, `date_inserted`, `date_updated`, `count_authors`) VALUES
(1, 'Феврония', 1, '2014-10-17 10:40:17', '2014-10-20 08:00:50', 4),
(2, 'Страна Россия', 3, '2014-10-17 10:40:35', '2014-10-20 07:52:36', 3),
(3, 'Сказки2', 2, '2014-10-17 10:41:17', '2014-10-20 08:00:32', 3),
(4, 'Картография', 1, '2014-10-17 17:20:41', '2014-10-20 07:52:13', 4),
(7, 'Бухучет', NULL, '2014-10-18 14:42:02', '2014-10-20 07:19:21', 1),
(8, 'Dance', 2, '2014-10-18 19:00:28', '2014-10-20 08:00:32', 0),
(9, 'Алиса в стране чудес', 2, '2014-10-19 19:38:39', '2014-10-20 08:00:32', 3),
(14, 'Капитан Немо', NULL, '2014-10-19 19:38:51', '2014-10-20 08:05:47', 3);

-- --------------------------------------------------------

--
-- Table structure for table `book2author`
--

CREATE TABLE IF NOT EXISTS `book2author` (
  `book_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book2author`
--

INSERT INTO `book2author` (`book_id`, `author_id`) VALUES
(1, 3),
(1, 5),
(1, 6),
(1, 7),
(2, 1),
(2, 3),
(2, 5),
(3, 1),
(3, 3),
(3, 5),
(4, 3),
(4, 6),
(4, 7),
(4, 8),
(7, 1),
(9, 3),
(9, 5),
(9, 6),
(14, 5),
(14, 6),
(14, 7);

-- --------------------------------------------------------

--
-- Table structure for table `reader`
--

CREATE TABLE IF NOT EXISTS `reader` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reader`
--

INSERT INTO `reader` (`id`, `name`, `date_inserted`, `date_updated`) VALUES
(1, 'Васин Никита', '2014-10-17 10:29:10', '2014-10-18 13:25:26'),
(2, 'Соскин', '2014-10-17 10:29:22', NULL),
(3, 'Сичкин', '2014-10-17 10:29:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name_index` (`name`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
 ADD PRIMARY KEY (`id`), ADD KEY `count_authors_index` (`count_authors`), ADD KEY `reader_id` (`reader_id`);

--
-- Indexes for table `book2author`
--
ALTER TABLE `book2author`
 ADD UNIQUE KEY `author_id_book_id_index` (`author_id`,`book_id`), ADD KEY `book_id` (`book_id`), ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `reader`
--
ALTER TABLE `reader`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `reader`
--
ALTER TABLE `reader`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`reader_id`) REFERENCES `reader` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book2author`
--
ALTER TABLE `book2author`
ADD CONSTRAINT `book2author_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `book2author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
