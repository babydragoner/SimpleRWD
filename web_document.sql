-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 02, 2015 at 04:42 AM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a1037597_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Web_Document`
--

CREATE TABLE `Web_Document` (
  `DocNum` int(11) NOT NULL AUTO_INCREMENT,
  `DocType` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `DocTitle` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `DocDescription` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `DocContent` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `VisitNum` int(11) DEFAULT NULL,
  `CreUser` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `CreDate` datetime NOT NULL,
  `UpdUser` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `UpdDate` datetime DEFAULT NULL,
  `DBSTS` char(1) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`DocNum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `Web_Document`
--

INSERT INTO `Web_Document` VALUES(1, 'Doc Type', 'Doc Title', 'Document Content', 25, 'Create User', 'Create Date', NULL, NULL, 'A');
I
