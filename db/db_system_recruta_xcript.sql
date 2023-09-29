DROP DATABASE IF EXISTS `db_system_recruta`;
CREATE DATABASE `db_system_recruta`;

use `db_system_recruta`;

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tb_anounce`;

CREATE TABLE `tb_anounce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `direcion` varchar(25) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_anounce` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

UNLOCK TABLES;

DROP TABLE IF EXISTS `tb_candidato`;

CREATE TABLE `tb_candidato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ib_number` varchar(255) NOT NULL,
  `job` varchar(255) NOT NULL,
  `status` int(11) DEFAULT '0',
  `anounce_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefone` (`telefone`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `ib_number` (`ib_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tb_message`;

CREATE TABLE `tb_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` int(11) DEFAULT '0',
  `date_anounce` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`email`,`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
