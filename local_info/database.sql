
----INFORMATION HAS BEEN REMOVED! REBUILD FOR YOUR OWN PURPOSES!

--
-- Table structure for table `agencies`
--
-----agencies allows special permissions for admin and would support special requests per agency
DROP TABLE IF EXISTS `agencies`;

CREATE TABLE `agencies` (
  `agency_name` varchar(40) NOT NULL,
  PRIMARY KEY (`agency_name`),
  UNIQUE KEY `agency_name` (`agency_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `agencies`
--

LOCK TABLES `agencies` WRITE;
/*!40000 ALTER TABLE `agencies` DISABLE KEYS */;
INSERT INTO `agencies` VALUES ('ADMIN');
/*!40000 ALTER TABLE `agencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cases`
--
-----cases documents goal total_hours, and updates hours_served from reports
DROP TABLE IF EXISTS `cases`;

CREATE TABLE `cases` (
  `cause_number` varchar(40) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `hours_served` int(11) NOT NULL,
  `total_hours` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cause_number`),
  UNIQUE KEY `cause_number` (`cause_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Table structure for table `reports`
--
-----reports documents hours earned to associate with cause_number in cases
-----see related trigger
DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `username` varchar(40) NOT NULL,
  `agency_name` varchar(40) NOT NULL,
  `cause_number` varchar(40) NOT NULL,
  `hours_performed` int(11) NOT NULL,
  `date_performed` date NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cause_number`,`date_performed`),
  CONSTRAINT `report_cfk1` FOREIGN KEY (`cause_number`) REFERENCES `cases` (`cause_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reports`
--

DELIMITER ;;
------when report is inserted update cases
/*!50003 CREATE*/ /*!50017 DEFINER=``@`localhost`*/ /*!50003 TRIGGER update_cases_when_insert_reports
AFTER INSERT ON reports
FOR EACH ROW
BEGIN
    UPDATE cases
    SET hours_served = (
        SELECT SUM(hours_performed)
        FROM reports
        WHERE cause_number = NEW.cause_number
    )
    WHERE cause_number = NEW.cause_number;
END */;;
DELIMITER ;

DELIMITER ;;
------when report is updated update cases
/*!50003 CREATE*/ /*!50017 DEFINER=``@`localhost`*/ /*!50003 TRIGGER update_cases_when_update_reports
AFTER update ON reports
FOR EACH ROW
BEGIN
    UPDATE cases
    SET hours_served = (
        SELECT SUM(hours_performed)
        FROM reports
        WHERE cause_number = NEW.cause_number
    )
    WHERE cause_number = NEW.cause_number;
END */;;
DELIMITER ;


--
-- Table structure for table `representatives`
--
----representatives documents users marked by agencies to add hours on their behalf
DROP TABLE IF EXISTS `representatives`;

CREATE TABLE `representatives` (
  `username` varchar(40) NOT NULL,
  `agency_name` varchar(40) NOT NULL,
  PRIMARY KEY (`username`,`agency_name`),
  KEY `representatives_cfk2` (`agency_name`),
  CONSTRAINT `representatives_cfk1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  CONSTRAINT `representatives_cfk2` FOREIGN KEY (`agency_name`) REFERENCES `agencies` (`agency_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Table structure for table `users`
--
----username documents usernames for login purposes
---- did not have access to e-mail verification. I recommend adding a field for authentication code
---- randomly fill field and email via insert or update trigger
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `username` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

