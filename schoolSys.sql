-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2012 at 11:40 PM
-- Server version: 5.5.24
-- PHP Version: 5.4.4-7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `schoolSys`
--

-- --------------------------------------------------------

--
-- Table structure for table `employeeDetails`
--

DROP TABLE IF EXISTS `employeeDetails`;
CREATE TABLE IF NOT EXISTS `employeeDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `IDNumber` varchar(20) NOT NULL,
  `KRAPIN` varchar(20) NOT NULL DEFAULT '00000',
  `employeeType` varchar(5) NOT NULL,
  `dateOfEmployment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When was this person employed at this organisation?',
  PRIMARY KEY (`uniqueID`),
  UNIQUE KEY `IDNumber` (`IDNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personDetails`
--

DROP TABLE IF EXISTS `personDetails`;
CREATE TABLE IF NOT EXISTS `personDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `surName` varchar(80) NOT NULL,
  `otherNames` varchar(80) NOT NULL,
  PRIMARY KEY (`uniqueID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personDetails`
--

INSERT INTO `personDetails` (`uniqueID`, `surName`, `otherNames`) VALUES
('94OX4', 'Onyango', 'Dennis Mungai'),
('U8GHR', 'Mwangi', 'Peter Wachira');

-- --------------------------------------------------------

--
-- Table structure for table `studentDetails`
--

DROP TABLE IF EXISTS `studentDetails`;
CREATE TABLE IF NOT EXISTS `studentDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `schoolID` varchar(20) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `dateOfAdmission` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `yearOfStudyAtAdmission` int(11) NOT NULL,
  PRIMARY KEY (`uniqueID`),
  UNIQUE KEY `schoolID` (`schoolID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentDetails`
--

INSERT INTO `studentDetails` (`uniqueID`, `schoolID`, `dateOfBirth`, `dateOfAdmission`, `gender`, `yearOfStudyAtAdmission`) VALUES
('94OX4', '1234', '1998-01-02', '2012-10-27 21:00:00', 0, 1),
('U8GHR', '1235', '1998-06-12', '2012-10-27 21:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `studentSubjects`
--

DROP TABLE IF EXISTS `studentSubjects`;
CREATE TABLE IF NOT EXISTS `studentSubjects` (
  `studentID` varchar(5) NOT NULL,
  `subjectCode` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjectDetails`
--

DROP TABLE IF EXISTS `subjectDetails`;
CREATE TABLE IF NOT EXISTS `subjectDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `startYear` tinyint(4) NOT NULL DEFAULT '1',
  `stopYear` tinyint(4) NOT NULL DEFAULT '4',
  PRIMARY KEY (`uniqueID`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjectDetails`
--

INSERT INTO `subjectDetails` (`uniqueID`, `code`, `name`, `description`, `startYear`, `stopYear`) VALUES
('0KEK5', '102', 'Kiswahili', 'Lugha ya Kiswahili', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `testDetails`
--

DROP TABLE IF EXISTS `testDetails`;
CREATE TABLE IF NOT EXISTS `testDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `startDate` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `type` tinyint(1) NOT NULL,
  `startYear` tinyint(1) NOT NULL,
  `stopYear` tinyint(4) NOT NULL,
  PRIMARY KEY (`uniqueID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testDetails`
--

INSERT INTO `testDetails` (`uniqueID`, `startDate`, `type`, `startYear`, `stopYear`) VALUES
('NJ2UQ', '2012-11-04 00:00:00', 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `userDetails`
--

DROP TABLE IF EXISTS `userDetails`;
CREATE TABLE IF NOT EXISTS `userDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `screenName` varchar(80) NOT NULL,
  `passwordHash` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uniqueID`),
  UNIQUE KEY `screenName` (`screenName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userDetails`
--

INSERT INTO `userDetails` (`uniqueID`, `screenName`, `passwordHash`, `status`) VALUES
('00001', 'admin', '020763de46dfb2a37001c0f129b61104', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
