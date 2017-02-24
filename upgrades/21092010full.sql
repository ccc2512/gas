-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ����� ��������: ��� 21 2010 �., 20:04
-- ������ �������: 5.1.48
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
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- ���� ������ ������� `accounts`
--

INSERT INTO `accounts` (`id`, `status`, `user_id`, `name`) VALUES
(0, 1, 1, ' '),
(1, 1, 1, ' ������'),
(2, 1, 1, ' ����� ���-�����');

-- --------------------------------------------------------

--
-- ��������� ������� `balance`
--

CREATE TABLE IF NOT EXISTS `balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `acc_id` int(11) NOT NULL DEFAULT '0',
  `bal_date` int(11) NOT NULL DEFAULT '0',
  `bx` decimal(18,2) NOT NULL DEFAULT '0.00',
  `debet` decimal(18,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(18,2) NOT NULL DEFAULT '0.00',
  `isx` decimal(18,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=38 ;

--
-- ���� ������ ������� `balance`
--

INSERT INTO `balance` (`id`, `status`, `user_id`, `acc_id`, `bal_date`, `bx`, `debet`, `credit`, `isx`) VALUES
(32, 1, 1, 1, 1284670800, 200.00, 50.00, 0.00, 150.00),
(33, 1, 1, 2, 1285016400, 16268.74, 4203.89, 0.00, 12064.85),
(34, 1, 1, 1, 1284843600, 150.00, 50.00, 0.00, 100.00),
(35, 1, 1, 2, 1284670800, 6158.76, 1150.51, 11910.49, 16918.74),
(36, 1, 1, 2, 1284930000, 16918.74, 650.00, 0.00, 16268.74),
(37, 1, 1, 2, 1284584400, 158.76, 0.00, 6000.00, 6158.76);

-- --------------------------------------------------------

--
-- ��������� ������� `cat`
--

CREATE TABLE IF NOT EXISTS `cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT ' ',
  `op` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=99 ;

--
-- ���� ������ ������� `cat`
--

INSERT INTO `cat` (`id`, `user_id`, `status`, `rating`, `name`, `op`) VALUES
(1, 1, 1, 3, ' ��� � ��������', 1),
(2, 1, 1, 0, ' ������ � �����', 1),
(3, 1, 1, 0, '��������', 1),
(4, 1, 1, 0, ' ���', 1),
(5, 1, 1, 0, ' ����', 1),
(6, 1, 1, 0, '� ����', 1),
(7, 1, 1, 0, ' ��������', 2),
(8, 1, 1, 0, ' ������', 2),
(9, 1, 1, 0, ' �����', 2),
(10, 1, 1, 0, ' ������ ������', 2),
(22, 1, 1, 0, '���������', 2),
(23, 1, 1, 1, '������� ��������', 1),
(93, 1, 1, 0, '��������', 1),
(95, 1, 1, 0, '������', 1),
(97, 1, 1, 0, '���� � ����', 2),
(98, 1, 1, 2, '��� ��������', 1);

-- --------------------------------------------------------

--
-- ��������� ������� `op`
--

CREATE TABLE IF NOT EXISTS `op` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `op_date` int(11) NOT NULL DEFAULT '0',
  `op_vid` int(1) NOT NULL DEFAULT '0',
  `op_summ` decimal(18,2) NOT NULL DEFAULT '0.00',
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `sub_id` int(11) NOT NULL DEFAULT '0',
  `acc_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=40 ;

--
-- ���� ������ ������� `op`
--

INSERT INTO `op` (`id`, `status`, `user_id`, `op_date`, `op_vid`, `op_summ`, `cat_id`, `sub_id`, `acc_id`) VALUES
(18, 1, 1, 1284584400, 2, 6000.00, 9, -1, 2),
(22, 1, 1, 1284670800, 2, 11910.49, 22, -1, 2),
(25, 1, 1, 1284670800, 1, 920.00, 5, 27, 2),
(26, 1, 1, 1284670800, 1, 230.51, 1, 28, 2),
(28, 1, 1, 1284670800, 1, 50.00, 95, 65, 1),
(33, 1, 1, 1284843600, 1, 50.00, 1, 4, 1),
(37, 1, 1, 1285016400, 1, 4203.89, 23, 60, 2),
(39, 1, 1, 1284930000, 1, 650.00, 98, 74, 2);

-- --------------------------------------------------------

--
-- ��������� ������� `subcat`
--

CREATE TABLE IF NOT EXISTS `subcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT ' ',
  `cat_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=75 ;

--
-- ���� ������ ������� `subcat`
--

INSERT INTO `subcat` (`id`, `user_id`, `status`, `rating`, `name`, `cat_id`) VALUES
(1, 1, 1, 0, ' ������, �����', 1),
(2, 1, 1, 0, ' ����, �������', 1),
(3, 1, 1, 0, '������ �����', 1),
(4, 1, 1, 3, ' � ���', 1),
(5, 1, 1, 0, ' ����, ������������', 1),
(6, 1, 1, 0, '������ �����', 2),
(7, 1, 1, 0, ' ���������', 2),
(8, 1, 1, 0, '�����������', 3),
(9, 1, 1, 0, '��������', 3),
(10, 1, 1, 0, ' ������� �����', 4),
(11, 1, 1, 0, ' ������ ��������', 4),
(12, 1, 1, 0, ' ��������', 5),
(13, 1, 1, 0, '������ �������', 5),
(16, 1, 1, 0, ' ������ �����', 2),
(21, 1, 1, 0, 'Nike', 2),
(23, 1, 1, 0, 'Adidas', 2),
(24, 1, 1, 0, 'Puma', 2),
(25, 1, 1, 0, '�������� ��������', 23),
(27, 1, 1, 0, '������', 5),
(28, 1, 1, 0, '�����', 1),
(60, 1, 1, 1, '��� ����', 23),
(61, 1, 1, 0, '������', 93),
(65, 1, 1, 0, '�� ��� ��������', 95),
(72, 1, 1, 0, '� �����', 97),
(73, 1, -1, 0, '�����', 98),
(74, 1, 1, 2, '����� ������', 98);
