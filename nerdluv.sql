---
--- Table structure for table `user`
---

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `gender` varchar(1) DEFAULT NULL,
    `age` int(11) UNSIGNED DEFAULT 0,
    `created_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES (1, 'Oldspice Guy', 'M', 36, NULL);


--
-- Table structure for user personality
--

DROP TABLE IF EXISTS `personalities`;
CREATE TABLE `personalities` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(4) NOT NULL,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2;


--
-- Dumping data for table `personalities`
--

INSERT INTO `personalities` VALUES(1, 'ENTJ', 1);


--
-- Table structure for table `fav_os`
--

DROP TABLE IF EXISTS `fav_os`;
CREATE TABLE `fav_os` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB;


--
-- Dumping data for table `fav_os`
--

INSERT INTO `fav_os` VALUES(1, 'Windows', 1);


--
-- Table structure for table `seeking_age`
--

DROP TABLE IF EXISTS `seeking_age`;
CREATE TABLE `seeking_age` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `min_age` int(11) DEFAULT 0,
    `max_age` int(11) DEFAULT 200,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB;


--
-- Dumping data for table `seeking_age`
--

INSERT INTO `seeking_age` VALUES(1, 22, 42, 1);


