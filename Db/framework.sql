-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 05, 2008 at 07:00 AM
-- Server version: 5.0.27
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `framework`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `blog`
-- 

CREATE TABLE `blog` (
  `BlogId` int(11) NOT NULL auto_increment,
  `UserId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `EnteDate` datetime NOT NULL,
  PRIMARY KEY  (`BlogId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `blog`
-- 

INSERT INTO `blog` (`BlogId`, `UserId`, `Title`, `Description`, `EnteDate`) VALUES 
(1, 2, 'Ttile', 'descx', '2008-08-05 04:43:56'),
(2, 2, 'Blog title', 'dgdfgfdh sdr sh hg', '2008-08-05 04:46:48'),
(3, 2, 'Ttile 2', 'dfksjf ksdaf klasd fksaj fk asdkfjsdkl', '2008-08-05 05:31:51'),
(4, 3, 'ffff', 'sdfs dfsdf sdf', '2008-08-05 06:43:25');

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `UserId` int(11) NOT NULL auto_increment,
  `Username` varchar(20) NOT NULL,
  `Passwd` varchar(40) NOT NULL,
  PRIMARY KEY  (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `user`
-- 

INSERT INTO `user` (`UserId`, `Username`, `Passwd`) VALUES 
(1, 'vinod', '9e3669d19b675bd57058fd4664205d2a'),
(2, 'jitu', 'c4ca4238a0b923820dcc509a6f75849b'),
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

-- 
-- Table structure for table `userInfo`
-- 

CREATE TABLE `userInfo` (
  `UserInfoId` int(11) NOT NULL auto_increment,
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  PRIMARY KEY  (`UserInfoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `userInfo`
-- 

INSERT INTO `userInfo` (`UserInfoId`, `UserId`, `FirstName`, `LastName`) VALUES 
(1, 1, 'v', 'v'),
(2, 2, 'Jitendra', 'Saklani'),
(3, 3, 'admin', 'admin');
