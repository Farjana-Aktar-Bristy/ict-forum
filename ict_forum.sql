-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2020 at 12:07 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ict_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `answer_body` varchar(10000) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `question_id`, `user_name`, `answer_body`, `date`) VALUES
(1, 7, 'mamun-ict', '<p>Hello answer</p>\r\n', '2020-04-26'),
(2, 7, 'mamun-teacher', '<p>hello 2 from mamun-teacher</p>\r\n', '2020-04-26'),
(3, 8, 'mamun-ict', '<p>test answer</p>\r\n', '2020-04-26'),
(4, 9, 'bristy', '<p>hello test</p>\r\n', '2020-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `answer_down_vote`
--

CREATE TABLE `answer_down_vote` (
  `answer_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer_down_vote`
--

INSERT INTO `answer_down_vote` (`answer_id`, `user_name`) VALUES
(2, 'mamun-teacher'),
(2, 'mamun-ict');

-- --------------------------------------------------------

--
-- Table structure for table `answer_up_vote`
--

CREATE TABLE `answer_up_vote` (
  `answer_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer_up_vote`
--

INSERT INTO `answer_up_vote` (`answer_id`, `user_name`) VALUES
(1, 'mamun-teacher'),
(1, 'mamun-ict');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `notice_body` varchar(5000) NOT NULL,
  `batch` varchar(5) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`notice_id`, `user_name`, `title`, `notice_body`, `batch`, `date`) VALUES
(4, 'mamun-teacher', 'new notice', '<p>notice from mamunur rashid. java class at 10 am tomorrow.</p>\r\n', '13th', '2020-05-02'),
(6, 'mamun-teacher', 'notice latest', '<p>new notice for testing</p>\r\n', '13th', '2020-05-02'),
(11, 'mamun-teacher', 'java class canceled', '<p>java class canceled</p>\r\n', '11th', '2020-05-02'),
(12, 'mamun-teacher', 'java class canceled', '<p>java class canceled</p>\r\n', '11th', '2020-05-02'),
(13, 'mamun-teacher', 'Thesis related discussion', '<p>Tomorrw at 10 am thesis related discussion will be held in ICT 205.</p>\r\n', '13th', '2020-05-02');

-- --------------------------------------------------------

--
-- Table structure for table `notice_unviewed`
--

CREATE TABLE `notice_unviewed` (
  `unviewed_id` int(11) NOT NULL,
  `notice_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_recovery`
--

CREATE TABLE `password_recovery` (
  `email` varchar(100) NOT NULL,
  `token` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `title` varchar(2000) NOT NULL,
  `question_body` varchar(10000) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `user_name`, `title`, `question_body`, `date`) VALUES
(7, 'mamun-ict', 'What does System.out.println mean in java', '<p>à¦†à¦®à¦°à¦¾ à¦¸à¦¬à¦¾à¦‡ à¦¹à§Ÿà¦¤à§‹ à¦†à¦®à¦¾à¦¦à§‡à¦° à¦ªà§à¦°à¦¥à¦® à¦œà¦¾à¦­à¦¾ à¦ªà§à¦°à§‹à¦—à§à¦°à¦¾à¦® à¦²à§‡à¦–à¦¾à¦° à¦¸à¦®à§Ÿ System.out.println(); à¦¸à§à¦Ÿà§‡à¦Ÿà¦®à§‡à¦¨à§à¦Ÿà¦Ÿà¦¿ à¦¬à§à¦¯à¦¬à¦¹à¦¾à¦° à¦•à¦°à§‡ à¦¥à¦¾à¦•à¦¿à¥¤ à¦•à¦¿à¦¨à§à¦¤à§ à¦†à¦®à¦°à¦¾ à¦•à¦¿ à¦œà¦¾à¦¨à¦¿ System, out, println() à¦à¦—à§à¦²à§‹ à¦†à¦¸à¦²à§‡ à¦•à¦¿?</p>\r\n\r\n<p>à¦†à¦¸à§à¦¨ à¦œà§‡à¦¨à§‡ à¦¨à§‡à¦‡à¥¤</p>\r\n\r\n<p>à§§à¥¤ <strong>System</strong> à¦¹à¦²à§‹ <strong>java.lang</strong> package à¦à¦° à¦à¦•à¦Ÿà¦¿ à¦¬à¦¿à¦²à§à¦Ÿ à¦‡à¦¨ à¦•à§à¦²à¦¾à¦¸à¥¤ à¦à¦‡ à¦•à§à¦²à¦¾à¦¸ à¦‡à¦¨à¦ªà§à¦Ÿ à¦“ à¦†à¦‰à¦Ÿà¦ªà§à¦Ÿà§‡à¦° à¦œà¦¨à§à¦¯ à¦¯à¦¾à¦¬à¦¤à§€à§Ÿ à¦¸à§à¦¬à¦¿à¦§à¦¾ à¦ªà§à¦°à¦¦à¦¾à¦¨ à¦•à¦°à§‡à¥¤</p>\r\n\r\n<p>à§¨à¥¤ <strong>out</strong> à¦¹à¦²à§‹ <strong>System</strong> à¦•à§à¦²à¦¾à¦¸à§‡à¦° à¦à¦•à¦Ÿà¦¿ <strong>static variable.</strong> <strong>out</strong> à¦®à§à¦²à¦¤<strong> PrintStream</strong> à¦Ÿà¦¾à¦‡à¦ªà§‡à¦° à¦­à§à¦¯à¦¾à¦°à¦¿à§Ÿà§‡à¦¬à¦²à¥¤ <strong>PrinStream</strong> à¦¹à¦²à§‹ à¦à¦•à¦Ÿà¦¿ à¦•à§à¦²à¦¾à¦¸ à¦¯à¦¾à¦¤à§‡ à¦¬à¦¿à¦­à¦¿à¦¨à§à¦¨ à¦¡à¦¾à¦Ÿà¦¾ à¦ªà§à¦°à¦¿à¦¨à§à¦Ÿ à¦•à¦°à¦¾à¦° à¦®à§‡à¦¥à¦¡ à¦¬à¦°à§à¦¨à¦¨à¦¾ à¦•à¦°à¦¾ à¦†à¦›à§‡à¥¤ à¦¯à§‡à¦¹à§‡à¦¤à§ <strong>out</strong> à¦à¦•à¦Ÿà¦¿ <strong>static</strong> à¦­à§à¦¯à¦¾à¦°à¦¿à§Ÿà§‡à¦¬à¦² à¦¸à§‡à¦¹à§‡à¦¤à§ à¦à¦•à§‡ à¦…à¦¬à¦œà§‡à¦•à§à¦Ÿ à¦¡à¦¿à¦•à§à¦²à§‡à§Ÿà¦¾à¦° à¦•à¦°à¦¾ à¦›à¦¾à§œà¦¾ à¦¶à§à¦§à§à¦®à¦¾à¦¤à§à¦° à¦•à§à¦²à¦¾à¦¸à§‡à¦° à¦®à¦¾à¦§à§à¦¯à¦®à§‡à¦‡ à¦¬à§à¦¯à¦¬à¦¹à¦¾à¦° à¦•à¦°à¦¾ à¦¯à¦¾à§Ÿà¥¤ à¦¯à§‡à¦®à¦¨à¦ƒ<strong> System.out</strong></p>\r\n\r\n<p>à§©à¥¤ <strong>out</strong> à¦•à§‡ <strong>PrintStream</strong> à¦•à§à¦²à¦¾à¦¸à§‡à¦° <strong>reference variable</strong> à¦“ à¦¬à¦²à¦¾ à¦¯à¦¾à§Ÿà¥¤</p>\r\n\r\n<p>à§ªà¥¤<strong> println()</strong> à¦¹à¦²à§‹ <strong>PrintStream</strong> à¦•à§à¦²à¦¾à¦¸à§‡à¦° à¦à¦•à¦Ÿà¦¿ à¦®à§‡à¦¥à¦¡ à¦¯à¦¾ à¦¬à¦¿à¦­à¦¿à¦¨à§à¦¨ à¦¡à¦¾à¦Ÿà¦¾ à¦ªà§à¦°à¦¿à¦¨à§à¦Ÿ à¦•à¦°à¦¾à¦° à¦•à¦¾à¦œà§‡ à¦¬à§à¦¯à¦¬à¦¹à§ƒà¦¤ à¦¹à§Ÿà¥¤ à¦¯à§‡à¦¹à§‡à¦¤à§ <strong>non static</strong> à¦­à§à¦¯à¦¾à¦°à¦¿à§Ÿà§‡à¦¬à¦²à¦•à§‡ <strong>reference variable</strong> à¦à¦° à¦®à¦¾à¦§à§à¦¯à§‡à¦®à§‡ à¦…à§à¦¯à¦¾à¦•à¦¸à§‡à¦¸ à¦•à¦°à¦¾ à¦¯à¦¾à§Ÿ à¦¤à¦¾à¦‡ à¦†à¦®à¦°à¦¾ <strong>out.println()</strong> à¦²à¦¿à¦–à§‡ <strong>println()</strong> à¦®à§‡à¦¥à¦¡à¦•à§‡ à¦…à§à¦¯à¦¾à¦•à¦¸à§‡à¦¸ à¦•à¦°à¦¤à§‡ à¦ªà¦¾à¦°à¦¿à¥¤ à¦à¦–à¦¾à¦¨à§‡ <strong>out</strong> à¦à¦•à¦Ÿà¦¿<strong> reference variable</strong> à¦†à¦° <strong>println()</strong> à¦à¦•à¦Ÿà¦¿ <strong>non static method.</strong></p>\r\n\r\n<p>à¦‰à¦ªà¦°à¦¿à¦‰à¦•à§à¦¤ à¦†à¦²à§‹à¦šà¦¨à¦¾ à¦¥à§‡à¦•à§‡ à¦¦à§‡à¦–à¦¾ à¦¯à¦¾à¦šà§à¦›à§‡ à¦¯à§‡ <strong>System.out.println()</strong> à¦¬à¦¿à¦­à¦¿à¦¨à§à¦¨ à¦¡à¦¾à¦Ÿà¦¾ à¦ªà§à¦°à¦¿à¦¨à§à¦Ÿ à¦•à¦°à¦¾à¦° à¦œà¦¨à§à¦¯ à¦¬à§à¦¯à¦¬à¦¹à§ƒà¦¤ à¦¹à§Ÿà¥¤ à¦¤à¦¾à¦‡ <strong>System.out.println()</strong> à¦•à§‡ <strong>Standard output function</strong> à¦“ à¦¬à¦²à¦¾ à¦šà¦²à§‡à¥¤</p>\r\n\r\n<p><img alt=\"\" src=\"ckeditor/uploads/463002067.png\" style=\"border-style:solid; border-width:1px; height:82px; margin:20px 5px; width:200px\" /></p>\r\n', '2020-04-22'),
(8, 'mamun-ict', 'new title', '<p>this is new post to test top question</p>\r\n', '2020-04-26'),
(9, 'mamun-teacher', 'How to write on console using java', '<p>java console input.</p>\r\n\r\n<pre>\r\n<code class=\"language-java\">Scanner sc = new Scanner(System.in);\r\nsc.nextLine()</code></pre>\r\n\r\n<p>&nbsp;</p>\r\n', '2020-04-26'),
(10, 'bristy', 'hello test', '<p>hello test from bristy</p>\r\n', '2020-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `question_down_vote`
--

CREATE TABLE `question_down_vote` (
  `question_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_down_vote`
--

INSERT INTO `question_down_vote` (`question_id`, `user_name`) VALUES
(8, 'mamun-teacher');

-- --------------------------------------------------------

--
-- Table structure for table `question_tag_mapping`
--

CREATE TABLE `question_tag_mapping` (
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_tag_mapping`
--

INSERT INTO `question_tag_mapping` (`question_id`, `tag_id`) VALUES
(7, 1),
(7, 2),
(7, 4),
(8, 3),
(9, 1),
(10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `question_up_vote`
--

CREATE TABLE `question_up_vote` (
  `question_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_up_vote`
--

INSERT INTO `question_up_vote` (`question_id`, `user_name`) VALUES
(8, 'mamun-ict'),
(7, 'mamun-ict'),
(9, 'mamun-teacher'),
(7, 'mamun-teacher'),
(10, 'bristy');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `tag_description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`, `tag_description`) VALUES
(1, 'java', 'Best programming language'),
(2, 'programming', ''),
(3, 'ict', ''),
(4, 'coding', ''),
(5, 'php', ''),
(6, 'photo', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `fullname` varchar(100) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `role` varchar(15) NOT NULL,
  `expert_in` varchar(3000) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `batch` varchar(25) NOT NULL,
  `designation` varchar(256) NOT NULL,
  `profile_picture` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`fullname`, `student_id`, `user_name`, `email`, `password`, `role`, `expert_in`, `description`, `batch`, `designation`, `profile_picture`) VALUES
('Farzana Aktar Bristy', 'IT-16060', 'bristy', 'farzanaaktarbristy60@gmail.com', 'bristy1', 'STUDENT', '', '', '13th', '', ''),
('Mamunur Rashid', 'IT-14011', 'mamun-ict', 'mamun0589@gmail.com', 'mamun321', 'STUDENT', 'Java, Spring framework, Database', 'I am an Enthusiastic Java Programmer', '11th', '', '1586796674.png'),
('Mamun-teacher', '', 'mamun-teacher', 'mamun-teacher@gmail.com', 'mamun123', 'TEACHER', 'JSP, Oracle', 'I am programmer at DSI', '', 'Professor', '1586859426.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `answer_down_vote`
--
ALTER TABLE `answer_down_vote`
  ADD KEY `user_name` (`user_name`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Indexes for table `answer_up_vote`
--
ALTER TABLE `answer_up_vote`
  ADD KEY `answer_id` (`answer_id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`notice_id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `notice_unviewed`
--
ALTER TABLE `notice_unviewed`
  ADD PRIMARY KEY (`unviewed_id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `notice_id` (`notice_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `question_down_vote`
--
ALTER TABLE `question_down_vote`
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `question_up_vote`
--
ALTER TABLE `question_up_vote`
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notice_unviewed`
--
ALTER TABLE `notice_unviewed`
  MODIFY `unviewed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`),
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Constraints for table `answer_down_vote`
--
ALTER TABLE `answer_down_vote`
  ADD CONSTRAINT `answer_down_vote_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`),
  ADD CONSTRAINT `answer_down_vote_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`answer_id`);

--
-- Constraints for table `answer_up_vote`
--
ALTER TABLE `answer_up_vote`
  ADD CONSTRAINT `answer_up_vote_ibfk_1` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`answer_id`),
  ADD CONSTRAINT `answer_up_vote_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`);

--
-- Constraints for table `notice`
--
ALTER TABLE `notice`
  ADD CONSTRAINT `notice_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`);

--
-- Constraints for table `notice_unviewed`
--
ALTER TABLE `notice_unviewed`
  ADD CONSTRAINT `notice_unviewed_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`),
  ADD CONSTRAINT `notice_unviewed_ibfk_2` FOREIGN KEY (`notice_id`) REFERENCES `notice` (`notice_id`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`);

--
-- Constraints for table `question_down_vote`
--
ALTER TABLE `question_down_vote`
  ADD CONSTRAINT `question_down_vote_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `question_down_vote_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`);

--
-- Constraints for table `question_up_vote`
--
ALTER TABLE `question_up_vote`
  ADD CONSTRAINT `question_up_vote_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `question_up_vote_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
