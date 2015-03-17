-- phpMyAdmin SQL Dump
-- version 4.2.13
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 09, 2014 at 04:14 PM
-- Server version: 5.5.39-MariaDB
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `schoolSys`
--
CREATE DATABASE IF NOT EXISTS `schoolSys` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `schoolSys`;

-- --------------------------------------------------------

--
-- Table structure for table `accountDetails`
--

DROP TABLE IF EXISTS `accountDetails`;
CREATE TABLE IF NOT EXISTS `accountDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `screenname` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `accessLevel` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accountDetails`
--

INSERT INTO `accountDetails` (`uniqueID`, `screenname`, `email`, `password`, `status`, `accessLevel`) VALUES
('G67BA', 'admin', 'admin@ibrahimngeno.me.ke', '020763de46dfb2a37001c0f129b61104', 1, 0),
('Y6D2K', 'eebrah', 'eebrah@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 2);

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
  `dateOfEmployment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When was this person employed at this organisation?'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personDetails`
--

DROP TABLE IF EXISTS `personDetails`;
CREATE TABLE IF NOT EXISTS `personDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `surName` varchar(80) NOT NULL,
  `otherNames` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personDetails`
--

INSERT INTO `personDetails` (`uniqueID`, `surName`, `otherNames`) VALUES
('09E5E', 'Muriithi', 'Frederick '),
('94OX4', 'Onyango', 'Dennis Mungai'),
('U8GHR', 'Mwangi', 'Peter Wachira');

-- --------------------------------------------------------

--
-- Table structure for table `streamDetails`
--

DROP TABLE IF EXISTS `streamDetails`;
CREATE TABLE IF NOT EXISTS `streamDetails` (
  `uniqueID` varchar(5) NOT NULL,
  `name` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `startYear` int(11) NOT NULL DEFAULT '1',
  `stopYear` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `streamDetails`
--

INSERT INTO `streamDetails` (`uniqueID`, `name`, `description`, `startYear`, `stopYear`) VALUES
('NX8ZU', 'South', 'Compass', 1, 4),
('UQZ4F', 'North', 'Compass directions', 1, 4);

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
  `entryScore` int(11) NOT NULL DEFAULT '0',
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `yearOfStudyAtAdmission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentDetails`
--

INSERT INTO `studentDetails` (`uniqueID`, `schoolID`, `dateOfBirth`, `dateOfAdmission`, `entryScore`, `gender`, `yearOfStudyAtAdmission`) VALUES
('09E5E', '1237', '0000-00-00', '2014-11-15 21:00:00', 100, 0, 1),
('94OX4', '1234', '1998-01-02', '2012-10-27 18:00:00', 0, 0, 1),
('U8GHR', '1235', '1998-06-12', '2012-10-27 18:00:00', 0, 1, 1);

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
  `stopYear` tinyint(4) NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjectDetails`
--

INSERT INTO `subjectDetails` (`uniqueID`, `code`, `name`, `description`, `startYear`, `stopYear`) VALUES
('0KEK5', '102', 'Kiswahili', 'Lugha ya Kiswahili', 1, 4),
('D2N41', '230', 'Chemistry', 'The study of the science of chemistry', 1, 4),
('FHHTD', '103', 'Physics', 'Physics is awesome!', 1, 4),
('R3GGY', '131', 'Mathematics', 'Mathematical concepts and calculations', 1, 4),
('R9WUV', '101', 'English', 'English language grammar and literature', 1, 4);

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
  `stopYear` tinyint(4) NOT NULL
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
  `name` varchar(80) NOT NULL,
  `dateJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userDetails`
--

INSERT INTO `userDetails` (`uniqueID`, `name`, `dateJoined`) VALUES
('G67BA', 'Administrator', '2013-09-17 18:00:00'),
('Y6D2K', 'Ibrahim Ngeno', '2013-09-20 11:54:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountDetails`
--
ALTER TABLE `accountDetails`
 ADD PRIMARY KEY (`uniqueID`), ADD UNIQUE KEY `screenname` (`screenname`);

--
-- Indexes for table `employeeDetails`
--
ALTER TABLE `employeeDetails`
 ADD PRIMARY KEY (`uniqueID`), ADD UNIQUE KEY `IDNumber` (`IDNumber`);

--
-- Indexes for table `personDetails`
--
ALTER TABLE `personDetails`
 ADD PRIMARY KEY (`uniqueID`);

--
-- Indexes for table `streamDetails`
--
ALTER TABLE `streamDetails`
 ADD PRIMARY KEY (`uniqueID`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `studentDetails`
--
ALTER TABLE `studentDetails`
 ADD PRIMARY KEY (`uniqueID`), ADD UNIQUE KEY `schoolID` (`schoolID`);

--
-- Indexes for table `subjectDetails`
--
ALTER TABLE `subjectDetails`
 ADD PRIMARY KEY (`uniqueID`), ADD UNIQUE KEY `name` (`name`), ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `testDetails`
--
ALTER TABLE `testDetails`
 ADD PRIMARY KEY (`uniqueID`);

--
-- Indexes for table `userDetails`
--
ALTER TABLE `userDetails`
 ADD PRIMARY KEY (`uniqueID`);
