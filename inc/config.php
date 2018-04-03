<?php 
// Database
DEFINE('DBNAME', 'ccapp');
DEFINE('DBHOST', 'localhost');
DEFINE('DBUSER', 'root');
DEFINE('DBPASS', '');

// az adatb�zis l�trehoz�s�hoz

/*
--
-- Adatb�zis: `ccapp`

CREATE DATABASE ccapp;
--

-- --------------------------------------------------------

--
-- T�bla szerkezet: `companycar`
--

CREATE TABLE IF NOT EXISTS `CompanyCar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Brand` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `LPNumber` varchar(7) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- T�bla szerkezet: `department`
--

CREATE TABLE IF NOT EXISTS `Department` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `NoOfMembers` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- T�bla szerkezet: `employee`
--

CREATE TABLE IF NOT EXISTS `Employee` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Note` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- T�bla szerkezet: `relempcar`
--

CREATE TABLE IF NOT EXISTS `RelEmpCar` (
  `EmployeeID` int(11) NOT NULL,
  `CarID` int(11) NOT NULL,
  PRIMARY KEY (`EmployeeID`,`CarID`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- T�bla szerkezet: `relempdep`
--

CREATE TABLE IF NOT EXISTS `RelEmpDep` (
  `EmployeeID` int(11) NOT NULL DEFAULT '0',
  `DepartmentID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`DepartmentID`,`EmployeeID`)
) ENGINE=MyISAM ;
*/
?>
