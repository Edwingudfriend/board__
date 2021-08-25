-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2021 at 12:35 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `board`
--
DROP DATABASE IF EXISTS `board`;
CREATE DATABASE IF NOT EXISTS `board` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `board`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `getSenderPost`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getSenderPost` (IN `senderId` VARCHAR(100))  BEGIN
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
	from post_level where sender=senderId and  receiver_status='level' 
    
union 
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
 from post_coarse where sender=senderId and  receiver_status='coarse'
 
union 
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
 from post_department where sender=senderId and  receiver_status='department'
 
union 
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
 from post_college where sender=senderId and  receiver_status='college'
 
 ORDER BY post_time DESC limit 3;
END$$

DROP PROCEDURE IF EXISTS `getStaffContact`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getStaffContact` (`department` INT)  BEGIN
if department = 3 then 
select phone_number from all_staff;
else select phone_number from all_staff where iddepartment=department;
end if;
END$$

DROP PROCEDURE IF EXISTS `getStaffInfo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getStaffInfo` (IN `userid` INT)  BEGIN
select * from all_staff where uid=userid;
END$$

DROP PROCEDURE IF EXISTS `getStaffPost`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getStaffPost` (IN `department` INT)  BEGIN

select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
 from post_department where iddepartment=department and  receiver_status='department' and iddepartment>2 || iddepartment=3
 ORDER by time DESC limit 6;
 
END$$

DROP PROCEDURE IF EXISTS `getStudentContact`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentContact` (IN `level` INT, `coarse` INT, `department` INT, `college` INT)  BEGIN
select phone_number from all_student where idlevel=level or idcoarse=coarse or iddepartment=department or idcollege=college;
END$$

DROP PROCEDURE IF EXISTS `getStudentInfo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentInfo` (IN `userid` INT)  BEGIN
select * from all_student where uid=userid;
END$$

DROP PROCEDURE IF EXISTS `getStudentPost`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentPost` (IN `level` INT, IN `coarse` INT, IN `department` INT, IN `college` INT)  BEGIN
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
	from post_level where idlevel=level and  receiver_status='level' 
    
union 
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
 from post_coarse where idcoarse=coarse and  receiver_status='coarse'
 
union 
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
 from post_department where iddepartment=department and  receiver_status='department' and iddepartment<3
 
union 
select 
idpost as post_id,
post_head as post_head,
post_body as post_body,
file as post_file,
time as post_time,
sender As sender,
tag As tag,
postlevel as level
 from post_college where idcollege=college and  receiver_status='college'
 
 ORDER BY post_time DESC limit 6;
END$$

DROP PROCEDURE IF EXISTS `makePost`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `makePost` (IN `head` VARCHAR(50), `body` VARCHAR(255), `sender` INT, `tag` VARCHAR(25), `fname` VARCHAR(30), `post_lev` VARCHAR(25))  BEGIN
insert into board.post(head, body, sender,posttag,file_name,postlevel) value (head,body,sender,tag,fname,post_lev);
select last_insert_id();
END$$

DROP PROCEDURE IF EXISTS `postIds`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `postIds` (IN `receiver_id` INT, `post_id` INT, `receiver_group` VARCHAR(25))  BEGIN
if receiver_group = 'college' then
INSERT INTO board.posts_ids(postid, receiver_status, posts_college) VALUES (post_id,receiver_group,receiver_id);
elseif receiver_group = 'coarse' then
INSERT INTO board.posts_ids(postid, receiver_status, posts_coarse) VALUES (post_id,receiver_group,receiver_id);
elseif receiver_group = 'department' then
INSERT INTO board.posts_ids(postid, receiver_status, posts_department) VALUES (post_id,receiver_group,receiver_id);
elseif receiver_group = 'level' then
INSERT INTO board.posts_ids(postid, receiver_status, posts_level) VALUES (post_id,receiver_group,receiver_id);
end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `all_staff`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `all_staff`;
CREATE TABLE `all_staff` (
`staffid` int(10)
,`fullname` varchar(91)
,`phone_number` varchar(255)
,`iddepartment` int(11)
,`department_name` varchar(255)
,`idcollege` int(11)
,`college_name` varchar(255)
,`uid` int(11)
,`username` varchar(16)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `all_student`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `all_student`;
CREATE TABLE `all_student` (
`uid` int(10)
,`fullname` varchar(91)
,`phone_number` varchar(255)
,`iddepartment` int(11)
,`department_name` varchar(255)
,`idcollege` int(11)
,`college_name` varchar(255)
,`idlevel` int(11)
,`level_name` varchar(255)
,`idcoarse` int(11)
,`coarse_name` varchar(255)
,`username` varchar(16)
);

-- --------------------------------------------------------

--
-- Table structure for table `coarse`
--

DROP TABLE IF EXISTS `coarse`;
CREATE TABLE `coarse` (
  `idcoarse` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coarse`
--

INSERT INTO `coarse` (`idcoarse`, `name`, `department`) VALUES
(2, 'Computer Engineering', 1),
(1, 'Computer Science', 1),
(3, 'ICT', 2);

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

DROP TABLE IF EXISTS `college`;
CREATE TABLE `college` (
  `idcollege` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`idcollege`, `name`) VALUES
(1, 'College of Information Communication and Technology');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `iddepartment` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `college` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`iddepartment`, `name`, `college`) VALUES
(3, 'all staff', 1),
(1, 'Computer Science and Engineering', 1),
(5, 'Computer Science and Engineering Staff', 1),
(2, 'ICT', 1),
(4, 'ICT Staff', 1);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

DROP TABLE IF EXISTS `level`;
CREATE TABLE `level` (
  `idlevel` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  `coarseid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`idlevel`, `level_name`, `coarseid`) VALUES
(1, 'NTA 4', 1),
(4, 'NTA 5', 1),
(7, 'NTA 6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `idpost` int(11) NOT NULL,
  `head` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `file_name` varchar(45) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender` int(11) NOT NULL,
  `posttag` varchar(45) NOT NULL,
  `postlevel` enum('argent','normal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`idpost`, `head`, `body`, `file_name`, `time`, `sender`, `posttag`, `postlevel`) VALUES
(46, 'Mabadiliko ya presentation', 'habari staff presentation ya mwaka mwisho sogezwa mbele mpaka alhamis na ijumaa kwaiyo staff wote mjiandae kwa hilo.', 'null', '2021-08-13 06:42:00', 3, 'All Staff', 'argent'),
(55, 'mabadiliko ya ratiba', 'presentation ya mwisho itafanyika alhamis na ijumaa baadala ya j3. ', 'null', '2021-08-13 07:14:28', 1, 'All NTA6', 'argent'),
(57, 'Computer Science na eng', 'Computer science eng wote mnatakiwa kuwepo kwenye kikao cha department. Leo saa 08:00 mchana.', 'null', '2021-08-13 07:25:11', 2, 'Cs and Comp eng dep', 'argent'),
(58, 'hello all student', 'i just miss you', 'null', '2021-08-16 16:19:38', 1, 'all student', 'normal');

--
-- Triggers `post`
--
DROP TRIGGER IF EXISTS `post_BEFORE_DELETE`;
DELIMITER $$
CREATE TRIGGER `post_BEFORE_DELETE` BEFORE DELETE ON `post` FOR EACH ROW BEGIN
delete from posts_ids where posts_ids.postid=OLD.idpost;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts_ids`
--

DROP TABLE IF EXISTS `posts_ids`;
CREATE TABLE `posts_ids` (
  `pid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `receiver_status` enum('level','coarse','department','college') NOT NULL,
  `posts_coarse` int(11) DEFAULT NULL,
  `posts_level` int(11) DEFAULT NULL,
  `posts_department` int(11) DEFAULT NULL,
  `posts_college` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts_ids`
--

INSERT INTO `posts_ids` (`pid`, `postid`, `receiver_status`, `posts_coarse`, `posts_level`, `posts_department`, `posts_college`) VALUES
(94, 46, 'department', NULL, NULL, 3, NULL),
(103, 55, 'level', NULL, 7, NULL, NULL),
(105, 57, 'department', NULL, NULL, 1, NULL),
(106, 57, 'level', NULL, 1, NULL, NULL),
(107, 58, 'college', NULL, NULL, NULL, 1),
(108, 58, 'level', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_coarse`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `post_coarse`;
CREATE TABLE `post_coarse` (
`idpost` int(11)
,`post_head` varchar(255)
,`post_body` varchar(255)
,`file` varchar(45)
,`receiver_status` enum('level','coarse','department','college')
,`time` timestamp
,`idcoarse` int(11)
,`sender` varchar(91)
,`tag` varchar(45)
,`postlevel` enum('argent','normal')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_college`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `post_college`;
CREATE TABLE `post_college` (
`idpost` int(11)
,`post_head` varchar(255)
,`post_body` varchar(255)
,`file` varchar(45)
,`receiver_status` enum('level','coarse','department','college')
,`time` timestamp
,`idcollege` int(11)
,`sender` varchar(91)
,`tag` varchar(45)
,`postlevel` enum('argent','normal')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_department`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `post_department`;
CREATE TABLE `post_department` (
`idpost` int(11)
,`post_head` varchar(255)
,`post_body` varchar(255)
,`file` varchar(45)
,`receiver_status` enum('level','coarse','department','college')
,`time` timestamp
,`iddepartment` int(11)
,`sender` varchar(91)
,`tag` varchar(45)
,`postlevel` enum('argent','normal')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_level`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `post_level`;
CREATE TABLE `post_level` (
`idpost` int(11)
,`post_head` varchar(255)
,`post_body` varchar(255)
,`file` varchar(45)
,`time` timestamp
,`idlevel` int(11)
,`receiver_status` enum('level','coarse','department','college')
,`sender` varchar(91)
,`tag` varchar(45)
,`postlevel` enum('argent','normal')
);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `uid` int(10) NOT NULL,
  `department` int(11) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `sname` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`uid`, `department`, `phone_number`, `fname`, `sname`) VALUES
(1, 5, '255767418811', 'Edwin', 'Nchia'),
(2, 4, '255713752428', 'Libetatus', 'Sago'),
(3, 5, '255652998504', 'Aneth', 'Maliseli');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `uid` int(10) NOT NULL,
  `level` int(11) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `sname` varchar(45) NOT NULL,
  `coarse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`uid`, `level`, `phone_number`, `fname`, `sname`, `coarse`) VALUES
(1, 1, '255776607136', 'Keneth', 'Mwakalinga', 1),
(2, 4, '255776607136', 'Jephason', 'Kasunga', 1),
(3, 7, '255776607136', 'Aneth', 'Maliseli', 1),
(4, 1, '255776607136', 'Omega', 'Seyongwe', 2),
(5, 4, '255621141754', 'Joshua', 'Laiza', 2),
(6, 7, '255621141754', 'Emmanuel', 'Mabula', 2),
(7, 1, '255621141754', 'Lordrey', 'Mwasha', 3),
(8, 4, '255759560502', 'Peter', 'Msele', 3),
(9, 7, '255759560502', 'Frank', 'John', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `iduser` int(11) NOT NULL,
  `status` enum('student','staff','admin') DEFAULT NULL,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `iduser`, `status`, `uid`) VALUES
('student01', '$2y$10$s/QnRixzlMyUAuCZ.hTfz.YuVb4I2GI4nbMP9lde9jyA1l7o8qNvO', 1, 'student', 1),
('student02', '$2y$10$a89N2bO6FCOXIMWndeLVv.pXR68l1x98tb94kZZV5oJtpAcjfU.1u', 2, 'student', 2),
('student03', '$2y$10$uODc6LGMoY0VCqEng68Bw./BNumCV25F8TOD1Io.i8n9bF.I1LcEW', 3, 'student', 3),
('student04', '$2y$10$CU/EXxeSsavytolNyFl8U.9uX6kj82AHBddZVPkFMclIX4E9S6SF.', 4, 'student', 4),
('student05', '$2y$10$Et56kiHw2oUhzqTM0LGkguK9s.h62hqTmKh24MziEY4vge5.Whohi', 5, 'student', 5),
('student066', '$2y$10$QHrqAcAajbc/3DKLwOLOFegJRFZFr.Cb6UWA5u1i2NQJrYpNZSMWG', 6, 'student', 6),
('student07', '$2y$10$J522M5oL5OJ1VXtKift8Y.rPFhyrqC122xWcLonQ6TA71xHLKTT4S', 7, 'student', 7),
('student08', '$2y$10$w9RrlNYJnLJKK/gkZvwxz.Q1AsazH0j7mFt3tGYg59PBWEV03KdYG', 8, 'student', 8),
('student09', '$2y$10$TZQ1ANJFAfnRAO2mwovYmejAzC.Pe4W.6ZtMryuzN4tjWyazkIhLG', 9, 'student', 9),
('annie', '$2y$10$uEQKT44PQc5GHL71tS6fL.qgFGT/M1lYc6iNQihefoT9k3d1VkNV.', 10, 'staff', 3),
('staff02', '$2y$10$zcSDXykq3tkHM0MUmyTiLO8hTowQZjkzNOf8iIH.QTYpqRruCEdBa', 11, 'staff', 2),
('admin01', '$2y$10$c6LktEZJvG9aVCZWmzitsexQ6u5HZz/sbqUA0l.KqCRtIc0E8bFkm', 12, 'admin', NULL),
('staff01', '$2y$10$bwLU00uRxb2/2vlILUcZbOIWs4QKLwdzvRAbd9eBnB4xbOnam1Hui', 16, 'staff', 1);

-- --------------------------------------------------------

--
-- Structure for view `all_staff`
--
DROP TABLE IF EXISTS `all_staff`;

DROP VIEW IF EXISTS `all_staff`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all_staff`  AS SELECT `staff`.`uid` AS `staffid`, concat(`staff`.`fname`,' ',`staff`.`sname`) AS `fullname`, `staff`.`phone_number` AS `phone_number`, `department`.`iddepartment` AS `iddepartment`, `department`.`name` AS `department_name`, `college`.`idcollege` AS `idcollege`, `college`.`name` AS `college_name`, `user`.`iduser` AS `uid`, `user`.`username` AS `username` FROM (((`staff` join `department` on(`staff`.`department` = `department`.`iddepartment`)) join `college` on(`department`.`college` = `college`.`idcollege`)) join `user` on(`user`.`uid` = `staff`.`uid`)) WHERE `user`.`status` = 'staff' ORDER BY `staff`.`uid` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `all_student`
--
DROP TABLE IF EXISTS `all_student`;

DROP VIEW IF EXISTS `all_student`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all_student`  AS SELECT `student`.`uid` AS `uid`, concat(`student`.`fname`,' ',`student`.`sname`) AS `fullname`, `student`.`phone_number` AS `phone_number`, `department`.`iddepartment` AS `iddepartment`, `department`.`name` AS `department_name`, `college`.`idcollege` AS `idcollege`, `college`.`name` AS `college_name`, `level`.`idlevel` AS `idlevel`, `level`.`level_name` AS `level_name`, `coarse`.`idcoarse` AS `idcoarse`, `coarse`.`name` AS `coarse_name`, `user`.`username` AS `username` FROM (((((`student` join `level` on(`student`.`level` = `level`.`idlevel`)) join `coarse` on(`student`.`coarse` = `coarse`.`idcoarse`)) join `department` on(`coarse`.`department` = `department`.`iddepartment`)) join `college` on(`department`.`college` = `college`.`idcollege`)) join `user` on(`user`.`uid` = `student`.`uid`)) WHERE `user`.`status` = 'student' ORDER BY `student`.`uid` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `post_coarse`
--
DROP TABLE IF EXISTS `post_coarse`;

DROP VIEW IF EXISTS `post_coarse`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_coarse`  AS SELECT `post`.`idpost` AS `idpost`, `post`.`head` AS `post_head`, `post`.`body` AS `post_body`, `post`.`file_name` AS `file`, `posts_ids`.`receiver_status` AS `receiver_status`, `post`.`time` AS `time`, `coarse`.`idcoarse` AS `idcoarse`, concat(`staff`.`fname`,' ',`staff`.`sname`) AS `sender`, `post`.`posttag` AS `tag`, `post`.`postlevel` AS `postlevel` FROM (((`post` join `posts_ids` on(`posts_ids`.`postid` = `post`.`idpost`)) join `coarse` on(`coarse`.`idcoarse` = `posts_ids`.`posts_coarse`)) join `staff` on(`staff`.`uid` = `post`.`sender`)) WHERE `posts_ids`.`receiver_status` = 'coarse' ORDER BY `post`.`time` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `post_college`
--
DROP TABLE IF EXISTS `post_college`;

DROP VIEW IF EXISTS `post_college`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_college`  AS SELECT `post`.`idpost` AS `idpost`, `post`.`head` AS `post_head`, `post`.`body` AS `post_body`, `post`.`file_name` AS `file`, `posts_ids`.`receiver_status` AS `receiver_status`, `post`.`time` AS `time`, `college`.`idcollege` AS `idcollege`, concat(`staff`.`fname`,' ',`staff`.`sname`) AS `sender`, `post`.`posttag` AS `tag`, `post`.`postlevel` AS `postlevel` FROM (((`post` join `posts_ids` on(`posts_ids`.`postid` = `post`.`idpost`)) join `college` on(`college`.`idcollege` = `posts_ids`.`posts_college`)) join `staff` on(`staff`.`uid` = `post`.`sender`)) WHERE `posts_ids`.`receiver_status` = 'college' ORDER BY `post`.`time` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `post_department`
--
DROP TABLE IF EXISTS `post_department`;

DROP VIEW IF EXISTS `post_department`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_department`  AS SELECT `post`.`idpost` AS `idpost`, `post`.`head` AS `post_head`, `post`.`body` AS `post_body`, `post`.`file_name` AS `file`, `posts_ids`.`receiver_status` AS `receiver_status`, `post`.`time` AS `time`, `department`.`iddepartment` AS `iddepartment`, concat(`staff`.`fname`,' ',`staff`.`sname`) AS `sender`, `post`.`posttag` AS `tag`, `post`.`postlevel` AS `postlevel` FROM (((`post` join `posts_ids` on(`posts_ids`.`postid` = `post`.`idpost`)) join `department` on(`posts_ids`.`posts_department` = `department`.`iddepartment`)) join `staff` on(`staff`.`uid` = `post`.`sender`)) WHERE `posts_ids`.`receiver_status` = 'department' OR `posts_ids`.`receiver_status` = 'staff' ORDER BY `post`.`time` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `post_level`
--
DROP TABLE IF EXISTS `post_level`;

DROP VIEW IF EXISTS `post_level`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_level`  AS SELECT `post`.`idpost` AS `idpost`, `post`.`head` AS `post_head`, `post`.`body` AS `post_body`, `post`.`file_name` AS `file`, `post`.`time` AS `time`, `level`.`idlevel` AS `idlevel`, `posts_ids`.`receiver_status` AS `receiver_status`, concat(`staff`.`fname`,' ',`staff`.`sname`) AS `sender`, `post`.`posttag` AS `tag`, `post`.`postlevel` AS `postlevel` FROM (((`post` join `posts_ids` on(`posts_ids`.`postid` = `post`.`idpost`)) join `level` on(`level`.`idlevel` = `posts_ids`.`posts_level`)) join `staff` on(`staff`.`uid` = `post`.`sender`)) WHERE `posts_ids`.`receiver_status` = 'level' ORDER BY `post`.`time` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coarse`
--
ALTER TABLE `coarse`
  ADD PRIMARY KEY (`idcoarse`),
  ADD KEY `coarse_idx` (`department`,`name`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`idcollege`),
  ADD KEY `collage_idx` (`name`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`iddepartment`),
  ADD KEY `department_idx` (`college`,`name`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`idlevel`),
  ADD KEY `level_coarse` (`coarseid`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`idpost`),
  ADD KEY `post_send_idx` (`sender`);

--
-- Indexes for table `posts_ids`
--
ALTER TABLE `posts_ids`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `posts_idx` (`postid`),
  ADD KEY `posts_level_idx` (`posts_level`),
  ADD KEY `posts_coarse_idx` (`posts_coarse`),
  ADD KEY `posts_department_idx` (`posts_department`),
  ADD KEY `posts_college_idx` (`posts_college`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `staff_idx` (`department`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `student_idx` (`level`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `user_idx` (`uid`,`status`,`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `idpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `posts_ids`
--
ALTER TABLE `posts_ids`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coarse`
--
ALTER TABLE `coarse`
  ADD CONSTRAINT `coarse_department` FOREIGN KEY (`department`) REFERENCES `department` (`iddepartment`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_collage` FOREIGN KEY (`college`) REFERENCES `college` (`idcollege`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `level`
--
ALTER TABLE `level`
  ADD CONSTRAINT `level_coarse` FOREIGN KEY (`coarseid`) REFERENCES `coarse` (`idcoarse`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_send` FOREIGN KEY (`sender`) REFERENCES `staff` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `posts_ids`
--
ALTER TABLE `posts_ids`
  ADD CONSTRAINT `posts_coarse` FOREIGN KEY (`posts_coarse`) REFERENCES `coarse` (`idcoarse`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_college` FOREIGN KEY (`posts_college`) REFERENCES `college` (`idcollege`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_department` FOREIGN KEY (`posts_department`) REFERENCES `department` (`iddepartment`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_level` FOREIGN KEY (`posts_level`) REFERENCES `level` (`idlevel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_post` FOREIGN KEY (`postid`) REFERENCES `post` (`idpost`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_department` FOREIGN KEY (`department`) REFERENCES `department` (`iddepartment`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_level` FOREIGN KEY (`level`) REFERENCES `level` (`idlevel`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `student_user` FOREIGN KEY (`uid`) REFERENCES `student` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
