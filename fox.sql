-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 03, 2010 at 04:26 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `fox`
--

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
  `channel` text NOT NULL,
  `date` text NOT NULL,
  `addedby` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`channel`, `date`, `addedby`) VALUES
('#chat', '6 3 2010 2 29 05 pm', 'cooper'),
('#matthew', '6 3 2010 1 43 41 am', 'cooper'),
('#unmoderated', '6 3 2010 2 29 21 pm', 'cooper'),
('#cooper', '6 3 2010 1 02 00 am', 'coop3r'),
('#fox', '6 3 2010 12 36 21 am', 'cooper'),
('#o_o', '6 3 2010 1 45 13 am', 'cooper'),
('#ConnectTek', '6 3 2010 2 29 54 pm', 'cooper');

-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE IF NOT EXISTS `commands` (
  `command` text NOT NULL,
  `response` text NOT NULL,
  `channel` text NOT NULL,
  `addedby` text NOT NULL,
  `date` text NOT NULL,
  `wild` text NOT NULL,
  `me` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commands`
--

INSERT INTO `commands` (`command`, `response`, `channel`, `addedby`, `date`, `wild`, `me`) VALUES
('ACTION rapes fox', 'ACTION lieks it', '#chat', 'cooper[local]', '6 3 2010 4 22 21 pm', 'false', 'false'),
('fox, k', '$nick, k', '#chat', 'cooper[local]', '6 3 2010 3 52 57 pm', 'false', 'false'),
('!lag', '$nick: !lag', '#chat', 'cooper[local]', '6 3 2010 3 53 21 pm', 'false', 'false'),
('who am i', '$nick!$ident@$host, a $sexuality $lol who sexes old men every night for $rand bucks a job :O', '#chat', 'cooper', '6 3 2010 3 35 32 pm', 'false', 'false'),
('\\o', 'o/', '#chat', 'cooper', '6 3 2010 3 16 08 pm', 'false', 'false'),
('o/', '\\o', '#chat', 'cooper', '6 3 2010 3 16 16 pm', 'false', 'false'),
('ACTION waves', 'o/', '#chat', 'cooper', '6 3 2010 3 15 32 pm', 'false', 'false'),
('ACTION <3 fox', 'ACTION <3 $nick', '#chat', 'cooper', '6 3 2010 3 03 08 pm', 'false', 'false'),
('<3 fox', '<3 $nick', '#chat', 'Freelancer[Fail]', '6 3 2010 3 02 43 pm', 'false', 'false'),
('no u', 'NO U', '#chat', 'cooper', '6 3 2010 2 59 10 pm', 'false', 'false'),
('nou', '$nick: 2 words kthx', '#chat', 'cooper', '6 3 2010 2 58 46 pm', 'true', 'false'),
('<_<', '>_>', '#chat', 'cooper', '6 3 2010 2 50 46 pm', 'false', 'false'),
('.', '.', '#cooper', 'coop3r', '6 3 2010 1 02 09 am', 'false', 'false'),
('._>', 'LOLFAIL $capsnick', '#chat', 'cooper', '6 3 2010 2 51 14 pm', 'true', 'false'),
('ACTION hugs fox', 'ACTION hugs $nick', '#chat', 'cooper', '6 3 2010 2 46 45 pm', 'false', 'false'),
('>_>', '<_<', '#chat', 'cooper', '6 3 2010 2 50 48 pm', 'false', 'false'),
(':D', ':D!', '#chat', 'cooper', '6 3 2010 2 33 27 pm', 'false', 'false'),
('o.o', 'looks at $nick', '#chat', 'cooper', '6 3 2010 2 30 05 pm', 'true', 'true'),
('Matthew', 'is a sexy beast', '#chat', 'Matt', '6 3 2010 2 29 36 pm', 'false', 'false'),
('cooper', 'ftw', '#chat', 'Matt', '6 3 2010 2 29 26 pm', 'false', 'false'),
('Matt', 'is super sexy', '#chat', 'Matt', '6 3 2010 2 29 20 pm', 'false', 'false'),
(':D?', ':D!', '#chat', 'cooper', '6 3 2010 2 29 15 pm', 'false', 'false'),
(':D!', ':D!', '#chat', 'cooper', '6 3 2010 2 29 11 pm', 'false', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `pics`
--

CREATE TABLE IF NOT EXISTS `pics` (
  `id` text NOT NULL,
  `pic` text NOT NULL,
  `channel` text NOT NULL,
  `addedby` text NOT NULL,
  `date` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pics`
--

INSERT INTO `pics` (`id`, `pic`, `channel`, `addedby`, `date`) VALUES
('1', 'http://www.fanpix.net/picture-gallery/485/1790485-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('2', 'http://www.fanpix.net/picture-gallery/520/1790520-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('3', 'http://www.fanpix.net/picture-gallery/609/1807609-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('4', 'http://www.fanpix.net/picture-gallery/604/1787604-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('5', 'http://www.fanpix.net/picture-gallery/588/1787588-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('6', 'http://www.fanpix.net/picture-gallery/528/1787528-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('7', 'http://www.fanpix.net/picture-gallery/185/1784185justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('8', 'http://www.fanpix.net/picture-gallery/954/1783954-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('9', 'http://www.fanpix.net/picture-gallery/947/1783947-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('10', 'http://www.fanpix.net/picture-gallery/918/1783918-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('11', 'd http://www.fanpix.net/picture-gallery/522/1787522-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('12', 'd http://www.zenyangxuangou.com/gallery/justin-bieber-kissing-2009.jpg', '#o_o', 'auto-script', 'unknown'),
('13', 'd http://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Justin_Bieber.jpg/506px-Justin_Bieber.jpg', '#o_o', 'auto-script', 'unknown'),
('14', 'd http://www.fanpix.net/picture-gallery/293/1297293-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('15', 'http://www.fanpix.net/picture-gallery/531/1780531-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('16', 'http://www.fanpix.net/picture-gallery/481/1780481-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('17', 'http://www.fanpix.net/picture-gallery/045/1780045-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('18', 'http://www.fanpix.net/picture-gallery/621/1776621-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('19', 'http://www.fanpix.net/picture-gallery/616/1776616-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('20', 'http://www.fanpix.net/picture-gallery/608/1776608-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('21', 'http://www.fanpix.net/picture-gallery/607/1776607-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('22', 'http://www.fanpix.net/picture-gallery/606/1776606-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('23', 'http://images2.fanpop.com/image/photos/9100000/JB-Rocks-justin-bieber-9143496-320-480.jpg', '#o_o', 'auto-script', 'unknown'),
('24', 'http://www.fanpix.net/picture-gallery/629/1807629-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('25', 'http://www.fanpix.net/picture-gallery/596/1807596-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('26', 'http://www.fanpix.net/picture-gallery/977/1800977-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('27', 'http://www.fanpix.net/picture-gallery/200/1800200-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('28', 'http://www.fanpix.net/picture-gallery/760/1791760-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('29', 'http://www.fanpix.net/picture-gallery/759/1791759-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('31', 'http://www.fanpix.net/picture-gallery/650/1791650-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('32', 'http://www.fanpix.net/picture-gallery/626/1791626-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('33', 'http://www.fanpix.net/picture-gallery/624/1791624-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('34', 'http://www.fanpix.net/picture-gallery/531/1787531-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('35', 'http://www.fanpix.net/picture-gallery/530/1787530-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('36', 'http://www.fanpix.net/picture-gallery/522/1787522-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('37', 'http://www.fanpix.net/picture-gallery/492/1787492-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('38', 'http://www.fanpix.net/picture-gallery/491/1787491-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('39', 'http://www.fanpix.net/picture-gallery/422/1787422-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('40', 'http://www.fanpix.net/picture-gallery/957/1779957-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('41', 'http://www.fanpix.net/picture-gallery/956/1779956-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('42', 'http://www.fanpix.net/picture-gallery/870/1743870-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('43', 'http://www.fanpix.net/picture-gallery/869/1743869-justin-bieber-picture.htm', '#o_o', 'auto-script', 'unknown'),
('44', 'http://www.justinbieberzone.com/wp-content/uploads/2010/03/Justin-Bieber-and-Selena-Gomez.jpg', '#o_o', 'auto-script', 'unknown'),
('45', 'http://justinbieberfan.org/wp-content/uploads/2010/03/seljust.jpg', '#o_o', 'auto-script', 'unknown'),
('46', 'http://images2.fanpop.com/image/photos/9600000/sel-and-justin-bieber-Dick-Clark-s-New-Year-s-Rockin-Eve-selena-gomez-9695032-289-399.jpg', '#o_o', 'auto-script', 'unknown'),
('47', 'http://www.disneydreaming.com/wp-content/uploads/2010/02/Justin-Bieber-Performs-In-Miami-Beach-Pointing-Fingers-344x525.jpg', '#o_o', 'auto-script', 'unknown'),
('48', 'http://media.photobucket.com/image/selena%20gomez%20and%20justin%20bieber/miley1016_/MANIPS/justinbieberandselenagomezpic.jpg', '#o_o', 'auto-script', 'unknown'),
('49', 'http://media.photobucket.com/image/selena%20gomez%20and%20justin%20bieber/flower_flor/AK699DNOS1_Selena_Gomez_Dick_Clarks.jpg?o=31', '#o_o', 'auto-script', 'unknown'),
('30', 'null', 'null', 'lol', 'lol');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` text NOT NULL,
  `quote` text NOT NULL,
  `channel` text NOT NULL,
  `addedby` text NOT NULL,
  `date` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `quote`, `channel`, `addedby`, `date`) VALUES
('1', '18<28Brenden|iPod> erm well parents wank me downstairs', '#cooper', 'coop3r', '6 3 2010 1 02 50 am');

