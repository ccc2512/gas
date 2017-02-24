-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ����� ��������: ��� 15 2010 �., 17:26
-- ������ �������: 5.1.44
-- ������ PHP: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- ���� ������: `gas_db`
--

-- --------------------------------------------------------

--
-- ��������� ������� `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=4 ;

--
-- ���� ������ ������� `accounts`
--

INSERT INTO `accounts` (`id`, `status`, `name`) VALUES
(0, 1, ' '),
(1, 1, ' ������'),
(2, 1, ' �������� ���-�����');

-- --------------------------------------------------------

--
-- ��������� ������� `cat`
--

CREATE TABLE IF NOT EXISTS `cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT ' ',
  `op` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=11 ;

--
-- ���� ������ ������� `cat`
--

INSERT INTO `cat` (`id`, `uid`, `status`, `name`, `op`) VALUES
(1, 1, 1, ' ��� � ��������', 1),
(2, 1, 1, ' ������ � �����', 1),
(3, 1, 1, '��������', 1),
(4, 1, 1, ' ���', 1),
(5, 1, 1, ' ����', 1),
(6, 1, 1, '� ����', 1),
(7, 1, 1, ' ��������', 2),
(8, 1, 1, ' ������', 2),
(9, 1, 1, ' �����', 2),
(10, 1, 1, ' ������ ������', 2);

-- --------------------------------------------------------

--
-- ��������� ������� `op`
--

CREATE TABLE IF NOT EXISTS `op` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `op_date` int(11) NOT NULL DEFAULT '0',
  `op_vid` int(1) NOT NULL DEFAULT '0',
  `op_summ` decimal(18,2) NOT NULL DEFAULT '0.00',
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `sub_id` int(11) NOT NULL DEFAULT '0',
  `acc_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=8 ;

--
-- ���� ������ ������� `op`
--

INSERT INTO `op` (`id`, `status`, `op_date`, `op_vid`, `op_summ`, `cat_id`, `sub_id`, `acc_id`) VALUES
(1, 1, 1284551084, 1, 1000.00, 2, 16, 1),
(2, 1, 1284551197, 1, 500.00, 2, 7, 2),
(3, 1, 1284551224, 2, 10000.00, 10, -1, 2),
(4, 1, 1284552585, 1, 1.00, 2, 16, 2),
(5, 1, 1284552627, 2, 1.00, 10, -1, 2),
(6, 1, 1284554070, 1, 1.00, 5, 13, 1),
(7, 1, 1284559630, 2, 6000.00, 9, -1, 2);

-- --------------------------------------------------------

--
-- ��������� ������� `subcat`
--

CREATE TABLE IF NOT EXISTS `subcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT ' ',
  `cat_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=17 ;

--
-- ���� ������ ������� `subcat`
--

INSERT INTO `subcat` (`id`, `uid`, `status`, `name`, `cat_id`) VALUES
(1, 1, 1, ' ������, �����', 1),
(2, 1, 1, ' ����, �������', 1),
(3, 1, 1, '������ �����', 1),
(4, 1, 1, ' � ���', 1),
(5, 1, 1, ' ����, ������������', 1),
(6, 1, 1, '������ �����', 2),
(7, 1, 1, ' ���������', 2),
(8, 1, 1, '�����������', 3),
(9, 1, 1, '��������', 3),
(10, 1, 1, ' ������� �����', 4),
(11, 1, 1, ' ������ ��������', 4),
(12, 1, 1, ' ��������', 5),
(13, 1, 1, '������ �������', 5),
(14, 1, 1, ' �����', 6),
(15, 1, 1, ' ������ ����', 6),
(16, 1, 1, ' ������ �����', 2);
