-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2017 at 04:47 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `booking`
--
CREATE DATABASE IF NOT EXISTS `booking` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `booking`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
`bookingid` int(25) NOT NULL,
  `date` date NOT NULL,
  `reason` tinytext NOT NULL,
  `bookinguserid` varchar(25) NOT NULL,
  `bookingstatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookinginfo`
--

CREATE TABLE IF NOT EXISTS `bookinginfo` (
`bookinginfoid` int(40) NOT NULL,
  `bookingid` int(40) NOT NULL,
  `roomid` int(25) NOT NULL,
  `time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookinglog`
--

CREATE TABLE IF NOT EXISTS `bookinglog` (
`bookinglogid` int(40) NOT NULL,
  `bookingid` int(40) NOT NULL,
  `date` date NOT NULL,
  `userid` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
`buildingid` int(20) NOT NULL,
  `campusid` int(20) NOT NULL,
  `buildingname` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`buildingid`, `campusid`, `buildingname`) VALUES
(1, 1, 'Main Building'),
(2, 2, 'Main Building'),
(3, 3, 'Main Building'),
(4, 4, 'Main Building');

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE IF NOT EXISTS `campus` (
`campusid` int(10) NOT NULL,
  `campusname` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`campusid`, `campusname`, `address`) VALUES
(1, 'New Lynn Campus', '3033 Great North Rd, New Lynn, Auckland'),
(2, 'City Campus', 'Level 3, 131 Queen Street CBD, Auckland'),
(3, 'Avondale Campus', '2171 Great North Rd Avondale'),
(4, 'Manukau Campus', '6 Osterley Way, Manukau, Auckland, New ');

-- --------------------------------------------------------

--
-- Table structure for table `campus_programme`
--

CREATE TABLE IF NOT EXISTS `campus_programme` (
`cpid` int(3) NOT NULL,
  `programmeid` int(3) NOT NULL,
  `campusid` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campus_programme`
--

INSERT INTO `campus_programme` (`cpid`, `programmeid`, `campusid`) VALUES
(1, 19, 4),
(3, 1, 4),
(4, 19, 4),
(5, 2, 4),
(6, 21, 4),
(7, 4, 4),
(8, 6, 4),
(9, 7, 4),
(10, 6, 3),
(11, 7, 3),
(12, 3, 3),
(13, 8, 3),
(14, 10, 3),
(15, 9, 3),
(16, 17, 1),
(17, 4, 1),
(18, 1, 1),
(19, 20, 2),
(20, 21, 2),
(21, 1, 2),
(22, 12, 2),
(23, 14, 2),
(24, 15, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cohort`
--

CREATE TABLE IF NOT EXISTS `cohort` (
  `cohortid` varchar(10) NOT NULL,
  `starttime` time NOT NULL,
  `roomid` int(3) DEFAULT NULL,
  `endtime` time NOT NULL,
  `programmeid` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cohort`
--

INSERT INTO `cohort` (`cohortid`, `starttime`, `roomid`, `endtime`, `programmeid`) VALUES
('70118', '13:00:00', 4, '17:00:00', 10),
('Hsdfsd', '09:00:00', 2, '11:00:00', 7),
('IT6117', '13:00:00', 1, '17:00:00', 9),
('it6118', '13:00:00', 4, '17:00:00', 9),
('IT6217', '13:00:00', 4, '17:00:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseid` varchar(10) NOT NULL,
  `programmeid` int(3) NOT NULL,
  `duration` int(3) NOT NULL,
  `credits` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `level` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseid`, `programmeid`, `duration`, `credits`, `name`, `level`) VALUES
('BAT3001', 1, 4, 15, 'Business Reception and Office Services', 3),
('BAT3002', 1, 4, 15, 'Documents for the Workplace', 3),
('BAT3003', 1, 4, 15, 'Financial Documents', 3),
('BAT3004', 1, 4, 15, 'Business Communication', 3),
('DC50101', 5, 4, 15, 'ICT Technical Infrastructure', 5),
('DC50111', 5, 4, 15, 'Introduction to Programming and Database', 5),
('DC50121', 5, 4, 15, 'ICT in Business', 5),
('DC50131', 5, 4, 15, 'ICT in Society', 5),
('DC50203', 5, 4, 15, 'Interface Design and User Experience', 5),
('DC50214', 5, 4, 15, 'Requirements Gathering', 5),
('DC50224', 5, 4, 15, 'Web Programming', 5),
('DC50225', 5, 4, 15, 'Web Implementation', 5),
('DC50243', 5, 4, 15, 'Web Implementation', 5),
('DC50244', 5, 4, 15, 'Web Implementation', 5),
('ICT301', 2, 4, 15, 'Desktop Productivity Tools', 3),
('ICT302', 2, 4, 15, 'Solution Design and Implementation', 3),
('ICT303', 2, 4, 15, 'Collaboration and Communication', 3),
('ICT304', 2, 4, 15, 'Integrated Solutions', 3),
('x1', 4, 4, 15, 'Computer Service Hardware Module', 5),
('x2', 4, 4, 15, 'Computer Service Operating System Module', 5),
('x3', 4, 4, 15, 'Computer Service Networking Module', 5),
('x4', 4, 4, 15, 'Computer Helpdesk and Customer Services Module', 5),
('xxx1', 3, 4, 15, 'ICT Technical Infrastructure', 5),
('xxx2', 3, 4, 15, 'Introduction to Programming and Database', 5),
('xxx3', 3, 4, 15, 'ICT in Business', 5),
('xxx4', 3, 4, 15, 'ICT in Society', 5),
('xxx5', 3, 4, 15, 'Interface Design and User Experience', 5),
('xxx6', 3, 4, 15, 'Requirements Gathering', 5),
('xxx7', 3, 4, 15, 'Web Programming', 5),
('xxx8', 3, 4, 15, 'Web Implementation', 5);

-- --------------------------------------------------------

--
-- Table structure for table `coursebooking`
--

CREATE TABLE IF NOT EXISTS `coursebooking` (
`coursebookingid` int(25) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `coursename` varchar(25) NOT NULL,
  `classstarttime` varchar(10) NOT NULL,
  `classendtime` varchar(10) NOT NULL,
  `tutorid` int(40) NOT NULL,
  `roomid` varchar(25) NOT NULL,
  `daySat` tinyint(1) NOT NULL DEFAULT '0',
  `dayMon` tinyint(1) NOT NULL DEFAULT '0',
  `dayTue` tinyint(1) NOT NULL DEFAULT '0',
  `dayWed` tinyint(1) NOT NULL DEFAULT '0',
  `dayThu` tinyint(1) NOT NULL DEFAULT '0',
  `dayFri` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coursebooking`
--

INSERT INTO `coursebooking` (`coursebookingid`, `startdate`, `enddate`, `coursename`, `classstarttime`, `classendtime`, `tutorid`, `roomid`, `daySat`, `dayMon`, `dayTue`, `dayWed`, `dayThu`, `dayFri`) VALUES
(28, '2016-04-04', '2016-06-16', '70116', '13:00', '17:00', 1, '1', 0, 1, 0, 1, 0, 0),
(31, '2016-05-30', '2016-06-17', '50316', '09:00', '11:00', 3, '1', 0, 1, 1, 1, 1, 1),
(32, '2016-06-27', '2016-07-01', '70116', '13:00', '17:00', 1, '1', 0, 0, 0, 1, 0, 0),
(33, '2016-07-04', '2016-10-20', '70116', '13:00', '17:00', 1, '1', 0, 1, 0, 1, 0, 0),
(36, '2016-04-04', '2016-05-20', 'IT6116 s1', '13:00', '15:00', 6, '2', 0, 1, 1, 1, 1, 1),
(37, '2016-05-23', '2016-07-29', 'IT6216', '09:00', '11:00', 6, '2', 0, 1, 1, 1, 1, 1),
(41, '2016-11-21', '2016-12-23', '50316 A s2', '09:00', '11:00', 3, '2', 0, 1, 1, 1, 1, 1),
(42, '2016-08-01', '2016-09-02', 'IT6216', '11:00', '13:00', 6, '2', 0, 1, 1, 1, 1, 1),
(47, '2016-08-22', '2016-12-09', 'IT6316', '15:00', '17:00', 6, '2', 0, 1, 1, 1, 1, 1),
(65, '2016-04-18', '2016-08-24', '70615 s2', '13:00', '17:00', 4, '5', 0, 1, 0, 1, 0, 0),
(66, '2016-04-04', '2016-06-24', 'NCC3 N', '09:00', '13:00', 11, '6', 0, 1, 1, 1, 1, 1),
(70, '2016-06-27', '2016-07-22', 'IT6215 s4', '13:00', '15:00', 6, '6', 0, 1, 1, 1, 1, 1),
(79, '2016-04-04', '2016-06-17', '50615', '09:00', '11:00', 3, '8', 0, 1, 1, 1, 1, 1),
(80, '2016-04-04', '2016-04-08', '50715', '11:00', '13:00', 3, '8', 0, 1, 1, 1, 1, 1),
(83, '2016-04-04', '2016-06-23', '70515', '13:00', '17:00', 1, '9', 0, 0, 1, 0, 1, 0),
(101, '2016-07-04', '2016-10-20', '70316', '17:00', '21:00', 4, '1', 0, 0, 1, 0, 1, 0),
(102, '2016-04-04', '2016-04-07', '70415', '17:00', '21:00', 4, '5', 0, 1, 0, 1, 0, 0),
(103, '2016-04-04', '2016-04-07', '70315', '17:00', '21:00', 4, '5', 0, 0, 1, 0, 1, 0),
(104, '2016-04-11', '2016-05-04', '70415', '17:00', '21:00', 4, '5', 0, 1, 0, 1, 0, 0),
(105, '2016-05-30', '2016-09-07', '70715 s2', '17:00', '21:00', 1, '5', 0, 1, 0, 1, 0, 0),
(106, '2016-07-04', '2016-10-20', '70316', '17:00', '21:00', 4, '6', 0, 0, 1, 0, 1, 0),
(108, '2016-04-11', '2016-06-03', '50116', '09:00', '11:00', 8, '4.1', 0, 1, 1, 1, 1, 1),
(109, '2016-06-20', '2016-10-07', '50116', '09:00', '11:00', 8, '4.1', 0, 1, 1, 1, 1, 1),
(110, '2016-10-10', '2016-12-23', 'IT50416A', '09:00', '11:00', 8, '4.1', 0, 1, 1, 1, 1, 1),
(111, '2016-09-12', '2016-11-04', 'IT50316', '11:00', '13:00', 9, '4.1', 0, 1, 1, 1, 1, 1),
(112, '2016-11-21', '2016-12-23', '50316', '11:00', '13:00', 3, '4.1', 0, 1, 1, 1, 1, 1),
(113, '2016-08-29', '2016-12-23', '70216 s2', '13:00', '17:00', 1, '4.1', 0, 0, 1, 0, 1, 0),
(114, '2016-09-05', '2016-12-21', '70416', '13:00', '17:00', 2, '4.1', 0, 1, 0, 1, 0, 0),
(115, '2016-04-11', '2016-05-27', 'IT6515 s2', '09:00', '11:00', 5, '4.2', 0, 1, 1, 1, 1, 1),
(116, '2016-05-30', '2016-06-17', 'IT6515 s2', '09:00', '11:00', 6, '4.2', 0, 1, 1, 1, 1, 1),
(117, '2016-06-20', '2016-07-08', 'IT6515 s2', '09:00', '11:00', 7, '4.2', 0, 1, 1, 1, 1, 1),
(118, '2016-09-12', '2016-12-23', 'NDC5216A', '09:00', '11:00', 3, '4.2', 0, 1, 1, 1, 1, 1),
(119, '2016-04-11', '2016-04-22', '50216m', '11:00', '13:00', 8, '4.2', 0, 1, 1, 1, 1, 1),
(120, '2016-04-25', '2016-05-20', '50216m', '11:00', '13:00', 3, '4.2', 0, 1, 1, 1, 1, 1),
(121, '2016-05-23', '2016-06-17', '50216m', '11:00', '13:00', 8, '4.2', 0, 1, 1, 1, 1, 1),
(122, '2016-06-20', '2016-07-01', '50216m', '11:00', '13:00', 3, '4.2', 0, 1, 1, 1, 1, 1),
(123, '2016-07-18', '2016-11-04', '50216m s2', '11:00', '13:00', 3, '4.2', 0, 1, 1, 1, 1, 1),
(124, '2016-11-21', '2016-12-21', '70516', '13:00', '17:00', 4, '4.2', 0, 1, 0, 1, 0, 0),
(125, '2016-04-11', '2016-05-06', 'IT6315 s2', '15:00', '17:00', 5, '4.2', 0, 1, 1, 1, 1, 1),
(131, '2016-11-21', '2016-12-23', 'DC70516 S1 (DC100)', '13:00', '17:00', 2, '1', 0, 1, 0, 1, 0, 0),
(132, '2017-01-09', '2017-02-24', 'DC70516 S1 (DC211/212)', '13:00', '17:00', 2, '1', 0, 1, 0, 1, 0, 0),
(133, '2017-02-27', '2017-03-24', 'DC70516 S1 (DC221)', '13:00', '17:00', 2, '1', 0, 1, 0, 1, 0, 0),
(134, '2017-04-10', '2017-05-05', 'DC70516 S2 (DC231)', '13:00', '17:00', 9, '1', 0, 1, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE IF NOT EXISTS `holiday` (
`holidayid` int(50) NOT NULL,
  `holidayname` varchar(30) NOT NULL,
  `holidaydate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

CREATE TABLE IF NOT EXISTS `programme` (
`programmeid` int(3) NOT NULL,
  `duration` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `credits` int(3) NOT NULL,
  `schoolid` int(3) NOT NULL,
  `semesters` int(3) NOT NULL,
  `level` int(3) NOT NULL,
  `classDuration` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programme`
--

INSERT INTO `programme` (`programmeid`, `duration`, `name`, `credits`, `schoolid`, `semesters`, `level`, `classDuration`) VALUES
(1, 17, 'New Zealand Certificate in Business Administration', 60, 1, 4, 4, 2),
(2, 16, 'New Zealand Certificate in Computing Level 3', 60, 2, 4, 3, 2),
(3, 52, 'New Zealand Diploma in Web Development & Design Le', 120, 2, 4, 4, 2),
(4, 14, 'Certificate in Computer Servicing Level 5', 63, 2, 4, 5, 2),
(5, 32, 'National Diploma in Computing Level 5', 120, 2, 4, 5, 2),
(6, 16, 'New Zealand Certificate in Information Technology ', 60, 2, 4, 4, 2),
(7, 32, 'New Zealand Diploma in IT Technical Support Level ', 120, 2, 4, 4, 2),
(8, 104, 'New Zealand Diploma in Networking Level 6', 120, 2, 4, 6, 2),
(9, 104, 'Diploma in Information Technology Level 6', 270, 2, 4, 6, 2),
(10, 52, 'Diploma in Computing Level 7', 122, 2, 4, 7, 2),
(11, 104, 'New Zealand Diploma in Business Level 6', 240, 1, 4, 6, 2),
(12, 38, 'New Zealand Diploma in Business Level 5', 120, 1, 4, 5, 2),
(13, 52, 'National Diploma in Business Level 5', 124, 1, 4, 5, 2),
(14, 52, 'Diploma in Business Level 7', 180, 1, 4, 7, 2),
(15, 39, 'Diploma in Hospitality Management Level 7', 120, 1, 4, 7, 2),
(16, 34, 'Diploma in Health Care Level 7', 120, 1, 4, 7, 2),
(17, 21, 'National Certificate in Early Childhood Education ', 63, 3, 4, 4, 2),
(18, 52, 'New Zealand Diploma in Early Childhood & Care Leve', 120, 3, 4, 4, 2),
(19, 17, 'New Zealand Certificate in Design & Arts Level 3', 60, 4, 4, 3, 2),
(20, 17, 'Certificate in Foundation Studies Level 3', 60, 4, 4, 3, 2),
(21, 17, 'Certificate in Academic Skills - Level 4 (STEM Sub', 60, 4, 4, 4, 2),
(22, 16, 'New Zealand Certificate in English Language Academ', 60, 4, 4, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `programme_course`
--

CREATE TABLE IF NOT EXISTS `programme_course` (
`pcid` int(3) NOT NULL,
  `programmeid` int(3) NOT NULL,
  `courseid` varchar(10) NOT NULL,
  `semester` int(3) NOT NULL,
  `priority` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programme_course`
--

INSERT INTO `programme_course` (`pcid`, `programmeid`, `courseid`, `semester`, `priority`) VALUES
(1, 3, 'xxx2', 1, 11),
(2, 3, 'xxx1', 1, 12),
(3, 3, 'xxx1', 1, 13),
(4, 3, 'xxx1', 1, 14),
(5, 3, 'xxx1', 1, 15),
(6, 3, 'xxx1', 1, 16),
(7, 3, 'xxx1', 2, 21),
(8, 3, 'xxx1', 2, 22),
(9, 3, 'xxx1', 2, 23),
(10, 3, 'xxx1', 2, 24),
(11, 3, 'xxx2', 2, 25),
(12, 3, 'xxx1', 3, 31),
(13, 3, 'xxx1', 3, 32),
(14, 3, 'xxx1', 3, 33),
(15, 3, 'xxx1', 3, 34);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
`roomid` int(20) NOT NULL,
  `roomname` text NOT NULL,
  `roomtype` tinyint(7) NOT NULL,
  `buildingid` int(20) NOT NULL,
  `floornumber` varchar(10) NOT NULL,
  `capacity` int(50) NOT NULL,
  `disability` tinyint(1) DEFAULT NULL,
  `fixedresources` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomid`, `roomname`, `roomtype`, `buildingid`, `floornumber`, `capacity`, `disability`, `fixedresources`) VALUES
(1, 'RED', 0, 3, '1', 50, 0, ''),
(2, 'YELLOW', 0, 3, '1', 50, 0, ''),
(4, 'Green', 1, 3, '1', 50, 0, ''),
(5, 'Class rm 1', 0, 1, '1', 50, 0, ''),
(6, 'Class rm 2', 0, 1, '2', 50, 0, ''),
(8, 'Class rm3', 0, 1, '2', 50, 0, ''),
(10, 'Class rm1', 0, 4, '1', 50, 0, ''),
(11, 'Class rm2', 0, 4, '1', 50, 0, ''),
(12, 'Lab 2', 0, 4, '1', 50, 0, ''),
(13, 'Learning Commons', 0, 3, '1', 80, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
`schoolid` int(3) NOT NULL,
  `name` varchar(65) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`schoolid`, `name`) VALUES
(1, 'School of Business'),
(2, 'School of IT'),
(3, 'School of Education'),
(4, 'School of Foundation Studies and Languages');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE IF NOT EXISTS `semester` (
`semesterid` int(10) NOT NULL,
  `cohortid` varchar(10) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `semestername` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semesterid`, `cohortid`, `startdate`, `enddate`, `semestername`) VALUES
(1, 'IT6217', '2017-04-03', '2017-07-15', 1),
(2, 'IT6117', '2017-08-15', '2018-04-15', 2),
(3, 'IT6217', '2017-08-25', '2018-04-12', 4),
(4, 'IT6117', '2017-05-26', '2018-04-15', 1),
(5, 'IT6117', '2017-05-15', '2018-04-28', 4),
(10, '70118', '2017-05-11', '2017-09-08', 1),
(15, '70118', '2017-05-11', '2017-09-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE IF NOT EXISTS `tutor` (
`tutorid` int(40) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`tutorid`, `firstname`, `lastname`, `email`) VALUES
(1, 'Rajika', 'Vyas', 'Rajika@nzse.ac.nz'),
(2, 'a', 'asd', 'dasd'),
(3, 'Jimmy', 'Saha', 'jimmy@nzse.ac.nz'),
(4, 'Dan', 'Sy', 'Dan@nzse.ac.nz'),
(5, 'a', 'asd', 'dasd'),
(6, 'a', 'asd', 'dasd'),
(7, 'a', 'asd', 'dasd'),
(8, 'Glen', 'Archer', 'Glen@nzse.ac.nz'),
(9, 'TBA', 'TBA', 'TBA@nzse.ac.nz'),
(10, 'a', 'asd', 'dasd'),
(11, 'Kabas', 'Albakry', 'Kabas@nzse.ac.nz'),
(12, 'Rajesh', 'Ampani', 'Rajesh@nzse.ac.nz'),
(13, 'Yang', 'Wang', 'Yang@nzse.ac.nz'),
(14, 'a', 'asd', 'dasd'),
(15, 'Burjiz', 'Soorty', 'Burjiz@nzse.ac.nz'),
(16, 'Feroze ', 'Ashraff', 'feroze@nzse.ac.nz');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` int(10) DEFAULT '0',
  `email` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `password`, `usertype`, `email`) VALUES
('admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, 'mae02197@naver.com'),
('jimmy', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 0, 'jimmy@nzse.ac.nz'),
('manager', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 2, 'manager@nzse.ac.nz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
 ADD PRIMARY KEY (`bookingid`);

--
-- Indexes for table `bookinginfo`
--
ALTER TABLE `bookinginfo`
 ADD PRIMARY KEY (`bookinginfoid`);

--
-- Indexes for table `bookinglog`
--
ALTER TABLE `bookinglog`
 ADD PRIMARY KEY (`bookinglogid`);

--
-- Indexes for table `building`
--
ALTER TABLE `building`
 ADD PRIMARY KEY (`buildingid`), ADD KEY `campusid` (`campusid`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
 ADD PRIMARY KEY (`campusid`);

--
-- Indexes for table `campus_programme`
--
ALTER TABLE `campus_programme`
 ADD PRIMARY KEY (`cpid`), ADD KEY `programmeid` (`programmeid`), ADD KEY `campusid` (`campusid`);

--
-- Indexes for table `cohort`
--
ALTER TABLE `cohort`
 ADD PRIMARY KEY (`cohortid`), ADD KEY `roomid` (`roomid`), ADD KEY `programmeid` (`programmeid`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
 ADD PRIMARY KEY (`courseid`), ADD KEY `programmeid` (`programmeid`);

--
-- Indexes for table `coursebooking`
--
ALTER TABLE `coursebooking`
 ADD PRIMARY KEY (`coursebookingid`), ADD KEY `tutorid` (`tutorid`), ADD KEY `roomid` (`roomid`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
 ADD PRIMARY KEY (`holidayid`);

--
-- Indexes for table `programme`
--
ALTER TABLE `programme`
 ADD PRIMARY KEY (`programmeid`), ADD KEY `schoolid` (`schoolid`);

--
-- Indexes for table `programme_course`
--
ALTER TABLE `programme_course`
 ADD PRIMARY KEY (`pcid`), ADD KEY `programmeid` (`programmeid`), ADD KEY `courseid` (`courseid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
 ADD PRIMARY KEY (`roomid`), ADD KEY `buildingid` (`buildingid`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
 ADD PRIMARY KEY (`schoolid`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
 ADD PRIMARY KEY (`semesterid`), ADD KEY `cohortid` (`cohortid`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
 ADD PRIMARY KEY (`tutorid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
MODIFY `bookingid` int(25) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bookinginfo`
--
ALTER TABLE `bookinginfo`
MODIFY `bookinginfoid` int(40) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bookinglog`
--
ALTER TABLE `bookinglog`
MODIFY `bookinglogid` int(40) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
MODIFY `buildingid` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
MODIFY `campusid` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `campus_programme`
--
ALTER TABLE `campus_programme`
MODIFY `cpid` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `coursebooking`
--
ALTER TABLE `coursebooking`
MODIFY `coursebookingid` int(25) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=135;
--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
MODIFY `holidayid` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `programme`
--
ALTER TABLE `programme`
MODIFY `programmeid` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `programme_course`
--
ALTER TABLE `programme_course`
MODIFY `pcid` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
MODIFY `roomid` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
MODIFY `schoolid` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
MODIFY `semesterid` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
MODIFY `tutorid` int(40) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
ADD CONSTRAINT `building_ibfk_1` FOREIGN KEY (`campusid`) REFERENCES `campus` (`campusid`);

--
-- Constraints for table `campus_programme`
--
ALTER TABLE `campus_programme`
ADD CONSTRAINT `campus_programme_ibfk_1` FOREIGN KEY (`programmeid`) REFERENCES `programme` (`programmeid`),
ADD CONSTRAINT `campus_programme_ibfk_2` FOREIGN KEY (`campusid`) REFERENCES `campus` (`campusid`);

--
-- Constraints for table `cohort`
--
ALTER TABLE `cohort`
ADD CONSTRAINT `cohort_ibfk_1` FOREIGN KEY (`roomid`) REFERENCES `room` (`roomid`),
ADD CONSTRAINT `cohort_ibfk_2` FOREIGN KEY (`programmeid`) REFERENCES `programme` (`programmeid`);

--
-- Constraints for table `coursebooking`
--
ALTER TABLE `coursebooking`
ADD CONSTRAINT `coursebooking_ibfk_1` FOREIGN KEY (`tutorid`) REFERENCES `tutor` (`tutorid`);

--
-- Constraints for table `programme`
--
ALTER TABLE `programme`
ADD CONSTRAINT `programme_ibfk_1` FOREIGN KEY (`schoolid`) REFERENCES `school` (`schoolid`);

--
-- Constraints for table `programme_course`
--
ALTER TABLE `programme_course`
ADD CONSTRAINT `programme_course_ibfk_1` FOREIGN KEY (`programmeid`) REFERENCES `programme` (`programmeid`),
ADD CONSTRAINT `programme_course_ibfk_2` FOREIGN KEY (`courseid`) REFERENCES `course` (`courseid`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`buildingid`) REFERENCES `building` (`buildingid`);

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`cohortid`) REFERENCES `cohort` (`cohortid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
