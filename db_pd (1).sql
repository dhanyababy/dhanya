-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2022 at 11:43 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pd`
--

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicineID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicineID`, `name`) VALUES
(1, 'Medicine 1'),
(2, 'Medicine 2');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `noteID` int(11) NOT NULL,
  `Test_Session_IDtest_session` int(11) NOT NULL,
  `note` longtext NOT NULL,
  `User_IDmed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`noteID`, `Test_Session_IDtest_session`, `note`, `User_IDmed`) VALUES
(1, 1, 'Well this is interesting.', 2),
(2, 1, 'This seams a bit weird.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organizationID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organizationID`, `name`) VALUES
(1, 'Hospital'),
(2, 'LNU University');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleID`, `name`, `type`) VALUES
(1, 'patient', '1'),
(2, 'physician', '2'),
(3, 'researcher', '3'),
(4, 'junior researcher', '3');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `testID` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `Therapy_IDtherapy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`testID`, `dateTime`, `Therapy_IDtherapy`) VALUES
(1, '2009-12-01 18:00:00', 1),
(2, '2009-12-02 18:00:00', 1),
(3, '2009-12-02 18:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `test_session`
--

CREATE TABLE `test_session` (
  `test_SessionID` int(11) NOT NULL,
  `test_type` int(11) NOT NULL,
  `Test_IDtest` int(11) NOT NULL,
  `DataURL` varchar(255) NOT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_session`
--

INSERT INTO `test_session` (`test_SessionID`, `test_type`, `Test_IDtest`, `DataURL`, `datetime`) VALUES
(1, 1, 1, 'data1', '2022-10-05 12:30:00'),
(2, 2, 1, 'data2', '2022-10-08 11:21:00'),
(3, 1, 2, 'data3', '2022-10-10 10:30:00'),
(4, 2, 2, 'data4', '2022-10-12 11:00:00'),
(5, 1, 3, 'data5', '2022-10-14 12:00:00'),
(6, 2, 3, 'data6', '2022-10-16 11:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `therapy`
--

CREATE TABLE `therapy` (
  `therapyID` int(11) NOT NULL,
  `User_IDpatient` int(11) NOT NULL,
  `User_IDmed` int(11) NOT NULL,
  `TherapyList_IDtherapylist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `therapy`
--

INSERT INTO `therapy` (`therapyID`, `User_IDpatient`, `User_IDmed`, `TherapyList_IDtherapylist`) VALUES
(1, 3, 1, 1),
(2, 4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `therapy_list`
--

CREATE TABLE `therapy_list` (
  `therapy_listID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `Medicine_IDmedicine` int(11) NOT NULL,
  `Dosage` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `therapy_list`
--

INSERT INTO `therapy_list` (`therapy_listID`, `name`, `Medicine_IDmedicine`, `Dosage`) VALUES
(1, 'Therapy trials with Medicine 1', 1, '400 ml');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Role_IDrole` int(11) NOT NULL,
  `Organization` int(11) NOT NULL,
  `Lat` float DEFAULT NULL,
  `Long` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `email`, `Role_IDrole`, `Organization`, `Lat`, `Long`) VALUES
(1, 'doc', 'dhanyababy194@gmail.com', 2, 1, NULL, NULL),
(2, 'researcher', 'blissjohn92@gmail.com ', 3, 2, NULL, NULL),
(3, 'Patient1', 'dhanyastudies194@gmail.com', 1, 1, 59.6567, 16.6709),
(4, 'patient2', 'y@happyemail.com', 1, 1, 57.3365, 12.5164);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `published` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `video_url`, `title`, `published`) VALUES
(1, 'https://www.youtube.com/embed/3n8UjH9h_8I?list=PLbKSbFnKYVY0gSY9_6d4iVKk-p6sfHoA7', 'Exercises - Parkinsons Disease', '2022-10-25 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicineID`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`noteID`),
  ADD KEY `fk_Test_SessionID_idx` (`Test_Session_IDtest_session`),
  ADD KEY `fk_UserID_idx` (`User_IDmed`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`organizationID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`testID`),
  ADD KEY `fk_TherapyID_idx` (`Therapy_IDtherapy`);

--
-- Indexes for table `test_session`
--
ALTER TABLE `test_session`
  ADD PRIMARY KEY (`test_SessionID`),
  ADD KEY `fk_TestID_idx` (`Test_IDtest`);

--
-- Indexes for table `therapy`
--
ALTER TABLE `therapy`
  ADD PRIMARY KEY (`therapyID`),
  ADD KEY `fk_UserID_Patient_idx` (`User_IDpatient`),
  ADD KEY `fk_UserID_medic_idx` (`User_IDmed`),
  ADD KEY `fk_Therapy_ListID_idx` (`TherapyList_IDtherapylist`);

--
-- Indexes for table `therapy_list`
--
ALTER TABLE `therapy_list`
  ADD PRIMARY KEY (`therapy_listID`),
  ADD KEY `fk_medicineID_idx` (`Medicine_IDmedicine`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `roleID_idx` (`Role_IDrole`),
  ADD KEY `fk_User_Organization_idx` (`Organization`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `noteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organizationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `testID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test_session`
--
ALTER TABLE `test_session`
  MODIFY `test_SessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `therapy`
--
ALTER TABLE `therapy`
  MODIFY `therapyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `therapy_list`
--
ALTER TABLE `therapy_list`
  MODIFY `therapy_listID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `fk_Test_SessionID` FOREIGN KEY (`Test_Session_IDtest_session`) REFERENCES `test_session` (`test_SessionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UserID` FOREIGN KEY (`User_IDmed`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `fk_TherapyID` FOREIGN KEY (`Therapy_IDtherapy`) REFERENCES `therapy` (`therapyID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test_session`
--
ALTER TABLE `test_session`
  ADD CONSTRAINT `fk_TestID` FOREIGN KEY (`Test_IDtest`) REFERENCES `test` (`testID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `therapy`
--
ALTER TABLE `therapy`
  ADD CONSTRAINT `fk_Therapy_ListID` FOREIGN KEY (`TherapyList_IDtherapylist`) REFERENCES `therapy_list` (`therapy_listID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UserID_Patient` FOREIGN KEY (`User_IDpatient`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UserID_medic` FOREIGN KEY (`User_IDmed`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `therapy_list`
--
ALTER TABLE `therapy_list`
  ADD CONSTRAINT `fk_MedicineID` FOREIGN KEY (`Medicine_IDmedicine`) REFERENCES `medicine` (`medicineID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_Organization` FOREIGN KEY (`Organization`) REFERENCES `organization` (`organizationID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_Role` FOREIGN KEY (`Role_IDrole`) REFERENCES `role` (`roleID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
