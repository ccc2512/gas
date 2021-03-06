-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ����� ��������: ��� 29 2010 �., 10:50
-- ������ �������: 5.0.51
-- ������ PHP: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- ���� ������: `ccc_gas`
--

-- --------------------------------------------------------

--
-- ��������� ������� `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(1) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default ' ',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=4 ;

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
  `id` int(11) NOT NULL auto_increment,
  `status` int(1) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `acc_id` int(11) NOT NULL default '0',
  `bal_date` int(11) NOT NULL default '0',
  `bx` decimal(18,2) NOT NULL default '0.00',
  `debet` decimal(18,2) NOT NULL default '0.00',
  `credit` decimal(18,2) NOT NULL default '0.00',
  `isx` decimal(18,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=42 ;

--
-- ���� ������ ������� `balance`
--

INSERT INTO `balance` (`id`, `status`, `user_id`, `acc_id`, `bal_date`, `bx`, `debet`, `credit`, `isx`) VALUES
(32, 1, 1, 1, 1284670800, '200.00', '50.00', '0.00', '150.00'),
(33, 1, 1, 2, 1285016400, '16268.74', '4203.89', '0.00', '12064.85'),
(34, 1, 1, 1, 1284843600, '150.00', '50.00', '0.00', '100.00'),
(35, 1, 1, 2, 1284670800, '6158.76', '1150.51', '11910.49', '16918.74'),
(36, 1, 1, 2, 1284930000, '16918.74', '650.00', '0.00', '16268.74'),
(37, 1, 1, 2, 1284584400, '158.76', '0.00', '6000.00', '6158.76'),
(38, 1, 1, 2, 1285099200, '12064.85', '273.80', '0.00', '11791.05'),
(39, 1, 1, 2, 1285704000, '11791.05', '1800.00', '0.00', '9991.05'),
(40, 1, 1, 1, 1285704000, '1900.00', '0.00', '1800.00', '3700.00'),
(41, 1, 1, 1, 1285099200, '100.00', '0.00', '1800.00', '1900.00');

-- --------------------------------------------------------

--
-- ��������� ������� `cat`
--

CREATE TABLE IF NOT EXISTS `cat` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `rating` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default ' ',
  `op` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=102 ;

--
-- ���� ������ ������� `cat`
--

INSERT INTO `cat` (`id`, `user_id`, `status`, `rating`, `name`, `op`) VALUES
(1, 1, 1, 4, ' ��� � ��������', 1),
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
(98, 1, 1, 2, '��� ��������', 1),
(99, 1, -1, 0, '���������', 1),
(100, 1, 1, 2, '� ����� � ������', 1),
(101, 1, 1, 2, '� ������ � �����', 2);

-- --------------------------------------------------------

--
-- ��������� ������� `gas`
--

CREATE TABLE IF NOT EXISTS `gas` (
  `id` int(11) NOT NULL auto_increment,
  `prev_id` int(11) NOT NULL default '0',
  `next_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `z_date` int(11) NOT NULL default '0',
  `date_z` date NOT NULL default '1970-01-01',
  `summ` decimal(18,2) NOT NULL default '0.00',
  `litr` decimal(18,2) NOT NULL default '0.00',
  `odo` decimal(18,2) NOT NULL default '0.00',
  `next_odo` decimal(18,2) NOT NULL default '0.00',
  `rubl2litr` decimal(18,2) NOT NULL default '0.00',
  `km` decimal(18,2) NOT NULL default '0.00',
  `litr2100km` decimal(18,4) NOT NULL default '0.0000',
  `rubl2km` decimal(18,4) NOT NULL default '0.0000',
  `comment` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=115 ;

--
-- ���� ������ ������� `gas`
--

INSERT INTO `gas` (`id`, `prev_id`, `next_id`, `user_id`, `status`, `z_date`, `date_z`, `summ`, `litr`, `odo`, `next_odo`, `rubl2litr`, `km`, `litr2100km`, `rubl2km`, `comment`) VALUES
(1, 5, 4, 1, 1, 1282338000, '0000-00-00', '299.00', '13.00', '235990.00', '236090.00', '23.00', '100.00', '13.0000', '2.9900', ''),
(2, 3, 5, 1, 1, 1281128400, '0000-00-00', '690.00', '30.00', '235430.00', '235690.00', '23.00', '260.00', '11.5385', '2.6538', ''),
(3, 39, 2, 1, 1, 1280782800, '0000-00-00', '690.00', '30.00', '235175.00', '235430.00', '23.00', '255.00', '11.7647', '2.7059', ''),
(4, 1, 6, 1, 1, 1282770000, '0000-00-00', '299.00', '13.00', '236090.00', '236190.00', '23.00', '100.00', '13.0000', '2.9900', ''),
(5, 2, 1, 1, 1, 1281733200, '0000-00-00', '690.00', '30.00', '235690.00', '235990.00', '23.00', '300.00', '10.0000', '2.3000', ''),
(6, 4, 7, 1, 1, 1282856400, '0000-00-00', '690.00', '30.00', '236190.00', '236440.00', '23.00', '250.00', '12.0000', '2.7600', ''),
(7, 6, 0, 1, 1, 1283461200, '0000-00-00', '690.00', '30.00', '236440.00', '236610.00', '23.00', '170.00', '17.6471', '4.0588', ''),
(9, 81, 10, 1, 1, 1263168000, '0000-00-00', '690.00', '30.00', '228710.00', '228850.00', '23.00', '140.00', '21.4286', '4.9286', ''),
(10, 9, 11, 1, 1, 1264118400, '0000-00-00', '500.00', '21.73', '228850.00', '228960.00', '23.01', '110.00', '19.7545', '4.5455', ''),
(11, 10, 12, 1, 1, 1264464000, '0000-00-00', '300.00', '13.33', '228960.00', '229050.00', '22.51', '90.00', '14.8111', '3.3333', ''),
(12, 11, 13, 1, 1, 1265068800, '0000-00-00', '690.00', '30.00', '229050.00', '229228.00', '23.00', '178.00', '16.8539', '3.8764', ''),
(13, 12, 14, 1, 1, 1266105600, '0000-00-00', '247.00', '10.00', '229228.00', '229288.00', '24.70', '60.00', '16.6667', '4.1167', ''),
(14, 13, 15, 1, 1, 1268092800, '0000-00-00', '300.00', '13.04', '229288.00', '229360.00', '23.01', '72.00', '18.1111', '4.1667', ''),
(15, 14, 16, 1, 1, 1268784000, '0000-00-00', '500.00', '22.22', '229360.00', '229536.00', '22.50', '176.00', '12.6250', '2.8409', ''),
(16, 15, 17, 1, 1, 1269388800, '0000-00-00', '500.00', '21.73', '229536.00', '229700.00', '23.01', '164.00', '13.2500', '3.0488', ''),
(17, 16, 18, 1, 1, 1269727200, '0000-00-00', '230.00', '10.00', '229700.00', '229797.00', '23.00', '97.00', '10.3093', '2.3711', ''),
(18, 17, 19, 1, 1, 1270080000, '0000-00-00', '500.00', '21.73', '229797.00', '229940.00', '23.01', '143.00', '15.1958', '3.4965', ''),
(19, 18, 20, 1, 1, 1270684800, '0000-00-00', '500.00', '21.73', '229940.00', '230082.00', '23.01', '142.00', '15.3028', '3.5211', ''),
(20, 19, 21, 1, 1, 1271548800, '0000-00-00', '920.00', '40.00', '230082.00', '230430.00', '23.00', '348.00', '11.4943', '2.6437', ''),
(21, 20, 22, 1, 1, 1272153600, '0000-00-00', '920.00', '40.00', '230430.00', '230800.00', '23.00', '370.00', '10.8108', '2.4865', ''),
(22, 21, 23, 1, 1, 1273449600, '0000-00-00', '500.00', '21.73', '230800.00', '231000.00', '23.01', '200.00', '10.8650', '2.5000', ''),
(23, 22, 24, 1, 1, 1273795200, '0000-00-00', '400.00', '20.00', '231000.00', '231200.00', '20.00', '200.00', '10.0000', '2.0000', ''),
(24, 23, 25, 1, 1, 1273795200, '0000-00-00', '685.00', '31.83', '231200.00', '231490.00', '21.52', '290.00', '10.9759', '2.3621', ''),
(25, 24, 26, 1, 1, 1273881600, '0000-00-00', '500.00', '25.00', '231490.00', '231750.00', '20.00', '260.00', '9.6154', '1.9231', ''),
(26, 25, 27, 1, 1, 1273881600, '0000-00-00', '500.00', '23.26', '231750.00', '231962.00', '21.50', '212.00', '10.9717', '2.3585', ''),
(27, 26, 28, 1, 1, 1274486400, '0000-00-00', '500.00', '21.73', '231962.00', '232167.00', '23.01', '205.00', '10.6000', '2.4390', ''),
(28, 27, 29, 1, 1, 1275091200, '0000-00-00', '920.00', '40.00', '232167.00', '232470.00', '23.00', '303.00', '13.2013', '3.0363', ''),
(29, 28, 30, 1, 1, 1275696000, '0000-00-00', '500.00', '21.73', '232470.00', '232633.00', '23.01', '163.00', '13.3313', '3.0675', ''),
(30, 29, 31, 1, 1, 1276300800, '0000-00-00', '690.00', '30.00', '232633.00', '232940.00', '23.00', '307.00', '9.7720', '2.2476', ''),
(31, 30, 32, 1, 1, 1276732800, '0000-00-00', '690.00', '30.00', '232940.00', '233220.00', '23.00', '280.00', '10.7143', '2.4643', ''),
(32, 31, 33, 1, 1, 1277424000, '0000-00-00', '920.00', '40.00', '233220.00', '233622.00', '23.00', '402.00', '9.9502', '2.2886', ''),
(33, 32, 34, 1, 1, 1277856000, '0000-00-00', '200.00', '9.30', '233622.00', '233694.00', '21.51', '72.00', '12.9167', '2.7778', ''),
(34, 33, 35, 1, 1, 1278288000, '0000-00-00', '920.00', '40.00', '233694.00', '233938.00', '23.00', '244.00', '16.3934', '3.7705', ''),
(35, 34, 36, 1, 1, 1278979200, '0000-00-00', '690.00', '30.00', '233938.00', '234140.00', '23.00', '202.00', '14.8515', '3.4158', ''),
(36, 35, 37, 1, 1, 1279324800, '0000-00-00', '460.00', '20.00', '234140.00', '234340.00', '23.00', '200.00', '10.0000', '2.3000', ''),
(37, 36, 38, 1, 1, 1279497600, '0000-00-00', '690.00', '30.00', '234340.00', '234650.00', '23.00', '310.00', '9.6774', '2.2258', ''),
(38, 37, 39, 1, 1, 1279843200, '0000-00-00', '575.00', '25.00', '234650.00', '234890.00', '23.00', '240.00', '10.4167', '2.3958', ''),
(39, 38, 3, 1, 1, 1280275200, '0000-00-00', '690.00', '30.00', '234890.00', '235175.00', '23.00', '285.00', '10.5263', '2.4211', ''),
(40, 0, 41, 1, 1, 1245715200, '0000-00-00', '500.00', '23.26', '221410.00', '221594.00', '21.50', '184.00', '12.6413', '2.7174', ''),
(41, 40, 42, 1, 1, 1245963600, '0000-00-00', '400.00', '18.60', '221594.00', '221752.00', '21.51', '158.00', '11.7722', '2.5316', ''),
(42, 41, 43, 1, 1, 1246309200, '0000-00-00', '500.00', '23.26', '221752.00', '221896.00', '21.50', '144.00', '16.1528', '3.4722', ''),
(43, 42, 44, 1, 1, 1246827600, '0000-00-00', '400.00', '18.18', '221896.00', '222069.00', '22.00', '173.00', '10.5087', '2.3121', ''),
(44, 43, 45, 1, 1, 1247173200, '0000-00-00', '220.00', '10.00', '222069.00', '222127.00', '22.00', '58.00', '17.2414', '3.7931', ''),
(45, 44, 46, 1, 1, 1247432400, '0000-00-00', '450.00', '20.00', '222127.00', '222315.00', '22.50', '188.00', '10.6383', '2.3936', ''),
(46, 45, 47, 1, 1, 1247605200, '0000-00-00', '200.00', '8.89', '222315.00', '222350.00', '22.50', '35.00', '25.4000', '5.7143', ''),
(47, 46, 48, 1, 1, 1247778000, '0000-00-00', '400.00', '17.78', '222350.00', '222517.00', '22.50', '167.00', '10.6467', '2.3952', ''),
(48, 47, 49, 1, 1, 1247864400, '0000-00-00', '641.25', '29.99', '222517.00', '222741.00', '21.38', '224.00', '13.3884', '2.8627', ''),
(49, 48, 50, 1, 1, 1248296400, '0000-00-00', '450.00', '20.00', '222741.00', '222945.00', '22.50', '204.00', '9.8039', '2.2059', ''),
(50, 49, 51, 1, 1, 1248728400, '0000-00-00', '427.50', '20.00', '222945.00', '223110.00', '21.38', '165.00', '12.1212', '2.5909', ''),
(51, 50, 52, 1, 1, 1248987600, '0000-00-00', '855.00', '39.99', '223110.00', '223428.00', '21.38', '318.00', '12.5755', '2.6887', ''),
(52, 51, 53, 1, 1, 1249419600, '0000-00-00', '450.00', '20.00', '223428.00', '223590.00', '22.50', '162.00', '12.3457', '2.7778', ''),
(53, 52, 54, 1, 1, 1249678800, '0000-00-00', '300.00', '13.33', '223590.00', '223711.00', '22.51', '121.00', '11.0165', '2.4793', ''),
(54, 53, 55, 1, 1, 1249765200, '0000-00-00', '200.00', '8.88', '223711.00', '223807.00', '22.52', '96.00', '9.2500', '2.0833', ''),
(55, 54, 56, 1, 1, 1249938000, '0000-00-00', '900.00', '40.00', '223807.00', '224181.00', '22.50', '374.00', '10.6952', '2.4064', ''),
(56, 55, 57, 1, 1, 1250283600, '0000-00-00', '300.00', '12.87', '224181.00', '224287.00', '23.31', '106.00', '12.1415', '2.8302', ''),
(57, 56, 58, 1, 1, 1250629200, '0000-00-00', '800.00', '34.33', '224287.00', '224571.00', '23.30', '284.00', '12.0880', '2.8169', ''),
(58, 57, 59, 1, 1, 1250974800, '0000-00-00', '200.00', '8.58', '224571.00', '224681.00', '23.31', '110.00', '7.8000', '1.8182', ''),
(59, 58, 60, 1, 1, 1251147600, '0000-00-00', '500.00', '21.45', '224681.00', '224833.00', '23.31', '152.00', '14.1118', '3.2895', ''),
(60, 59, 61, 1, 1, 1251579600, '0000-00-00', '500.00', '21.45', '224833.00', '224998.00', '23.31', '165.00', '13.0000', '3.0303', ''),
(61, 60, 62, 1, 1, 1252702800, '0000-00-00', '500.00', '20.57', '224998.00', '225170.00', '24.31', '172.00', '11.9593', '2.9070', ''),
(62, 61, 63, 1, 1, 1253134800, '0000-00-00', '700.00', '28.81', '225170.00', '225357.00', '24.30', '187.00', '15.4064', '3.7433', ''),
(63, 62, 64, 1, 1, 1253566800, '0000-00-00', '500.00', '20.57', '225357.00', '225510.00', '24.31', '153.00', '13.4444', '3.2680', ''),
(64, 63, 65, 1, 1, 1254258000, '0000-00-00', '500.00', '20.57', '225510.00', '225643.00', '24.31', '133.00', '15.4662', '3.7594', ''),
(65, 64, 66, 1, 1, 1254517200, '0000-00-00', '461.70', '20.00', '225643.00', '225838.00', '23.09', '195.00', '10.2564', '2.3677', ''),
(66, 65, 67, 1, 1, 1254603600, '0000-00-00', '500.00', '20.57', '225838.00', '225991.00', '24.31', '153.00', '13.4444', '3.2680', ''),
(67, 66, 68, 1, 1, 1255122000, '0000-00-00', '300.00', '12.60', '225991.00', '226087.00', '23.81', '96.00', '13.1250', '3.1250', ''),
(68, 67, 69, 1, 1, 1255294800, '0000-00-00', '500.00', '21.00', '226087.00', '226253.00', '23.81', '166.00', '12.6506', '3.0120', ''),
(69, 68, 70, 1, 1, 1255640400, '0000-00-00', '200.00', '8.40', '226253.00', '226285.00', '23.81', '32.00', '26.2500', '6.2500', ''),
(70, 69, 71, 1, 1, 1255726800, '0000-00-00', '952.00', '40.00', '226285.00', '226653.00', '23.80', '368.00', '10.8696', '2.5870', ''),
(71, 70, 72, 1, 1, 1256245200, '0000-00-00', '500.00', '21.00', '226653.00', '226793.00', '23.81', '140.00', '15.0000', '3.5714', ''),
(72, 71, 73, 1, 1, 1256680800, '0000-00-00', '200.00', '8.40', '226793.00', '226856.00', '23.81', '63.00', '13.3333', '3.1746', ''),
(73, 72, 74, 1, 1, 1256853600, '0000-00-00', '1000.00', '42.01', '226856.00', '227152.00', '23.80', '296.00', '14.1926', '3.3784', ''),
(74, 73, 75, 1, 1, 1257544800, '0000-00-00', '500.00', '21.00', '227152.00', '227278.00', '23.81', '126.00', '16.6667', '3.9683', ''),
(75, 74, 76, 1, 1, 1257804000, '0000-00-00', '300.00', '12.60', '227278.00', '227338.00', '23.81', '60.00', '21.0000', '5.0000', ''),
(76, 75, 77, 1, 1, 1258063200, '0000-00-00', '500.00', '21.00', '227338.00', '227464.00', '23.81', '126.00', '16.6667', '3.9683', ''),
(77, 76, 78, 1, 1, 1258236000, '0000-00-00', '952.00', '40.00', '227464.00', '228050.00', '23.80', '586.00', '6.8259', '1.6246', ''),
(78, 77, 79, 1, 1, 1259532000, '0000-00-00', '714.00', '30.00', '228050.00', '228190.00', '23.80', '140.00', '21.4286', '5.1000', ''),
(79, 78, 80, 1, 1, 1260136800, '0000-00-00', '705.00', '30.00', '228190.00', '228354.00', '23.50', '164.00', '18.2927', '4.2988', ''),
(80, 79, 81, 1, 1, 1260568800, '0000-00-00', '690.00', '30.00', '228354.00', '228550.00', '23.00', '196.00', '15.3061', '3.5204', ''),
(81, 80, 9, 1, 1, 1261346400, '0000-00-00', '630.00', '30.00', '228550.00', '228710.00', '21.00', '160.00', '18.7500', '3.9375', ''),
(108, 107, 0, 1, 1, 1284408000, '1970-01-01', '460.00', '20.00', '236870.00', '237010.00', '23.00', '140.00', '14.2857', '3.2857', ''),
(107, 7, 0, 1, 1, 1283976000, '1970-01-01', '690.00', '30.00', '236610.00', '236870.00', '23.00', '260.00', '11.5385', '2.6538', ''),
(109, 108, 0, 1, 1, 1284667200, '1970-01-01', '920.00', '40.00', '237010.00', '237310.00', '23.00', '300.00', '13.3333', '3.0667', ''),
(110, 109, 0, 1, 1, 1285099200, '1970-01-01', '460.00', '20.00', '237310.00', '237500.00', '23.00', '190.00', '10.5263', '2.4211', ''),
(111, 110, 0, 1, 1, 1285099200, '1970-01-01', '450.00', '20.00', '237500.00', '237700.00', '22.50', '200.00', '10.0000', '2.2500', ''),
(112, 111, 0, 1, 1, 1285358400, '1970-01-01', '600.00', '34.09', '237700.00', '238160.00', '17.60', '460.00', '7.4109', '1.3043', ''),
(113, 112, 0, 1, 1, 1285617600, '1970-01-01', '500.00', '28.41', '238160.00', '238447.00', '17.60', '287.00', '9.8990', '1.7422', ''),
(114, 113, 0, 1, 1, 1285617600, '1970-01-01', '460.00', '20.00', '238447.00', '0.00', '23.00', '0.00', '0.0000', '0.0000', '');

-- --------------------------------------------------------

--
-- ��������� ������� `op`
--

CREATE TABLE IF NOT EXISTS `op` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(1) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `op_date` int(11) NOT NULL default '0',
  `op_vid` int(1) NOT NULL default '0',
  `op_summ` decimal(18,2) NOT NULL default '0.00',
  `cat_id` int(11) NOT NULL default '0',
  `sub_id` int(11) NOT NULL default '0',
  `acc_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=45 ;

--
-- ���� ������ ������� `op`
--

INSERT INTO `op` (`id`, `status`, `user_id`, `op_date`, `op_vid`, `op_summ`, `cat_id`, `sub_id`, `acc_id`) VALUES
(18, 1, 1, 1284584400, 2, '6000.00', 9, -1, 2),
(22, 1, 1, 1284670800, 2, '11910.49', 22, -1, 2),
(25, 1, 1, 1284670800, 1, '920.00', 5, 27, 2),
(26, 1, 1, 1284670800, 1, '230.51', 1, 28, 2),
(28, 1, 1, 1284670800, 1, '50.00', 95, 65, 1),
(33, 1, 1, 1284843600, 1, '50.00', 1, 4, 1),
(37, 1, 1, 1285016400, 1, '4203.89', 23, 60, 2),
(39, 1, 1, 1284930000, 1, '650.00', 98, 74, 2),
(40, 1, 1, 1285099200, 1, '273.80', 1, 75, 2),
(41, -1, 1, 1285704000, 1, '1800.00', 100, -1, 2),
(42, -1, 1, 1285704000, 2, '1800.00', 101, -1, 1),
(43, -1, 1, 1285099200, 1, '1800.00', 100, -1, 2),
(44, -1, 1, 1285099200, 2, '1800.00', 101, -1, 1);

-- --------------------------------------------------------

--
-- ��������� ������� `strings`
--

CREATE TABLE IF NOT EXISTS `strings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `value` text NOT NULL,
  `type` varchar(10) default NULL,
  `comment` varchar(250) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) AUTO_INCREMENT=2 ;

--
-- ���� ������ ������� `strings`
--

INSERT INTO `strings` (`id`, `name`, `value`, `type`, `comment`) VALUES
(1, 'vers', '0.01 alpha', 'system', '');

-- --------------------------------------------------------

--
-- ��������� ������� `subcat`
--

CREATE TABLE IF NOT EXISTS `subcat` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `rating` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default ' ',
  `cat_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=76 ;

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
(74, 1, 1, 2, '����� ������', 98),
(75, 1, 1, 1, '��� �������', 1);

-- --------------------------------------------------------

--
-- ��������� ������� `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(11) default '0' COMMENT '-2-blocked, -1-deleted, 0-not activated, 1-normal >1 not specified by available',
  `u_key` int(11) NOT NULL default '0',
  `u_login` varchar(50) NOT NULL default '',
  `u_pass` varchar(50) NOT NULL default '',
  `last_visit_dt` int(11) NOT NULL default '0',
  `reg_date` varchar(10) NOT NULL default '',
  `activity` int(11) NOT NULL default '0',
  `nick_name` varchar(50) default NULL,
  `first_name` varchar(50) default NULL,
  `second_name` varchar(50) default NULL,
  `last_name` varchar(50) default NULL,
  `email` varchar(100) default NULL,
  `cel_phone` varchar(25) default NULL,
  `home_phone` varchar(25) default NULL,
  `fax` varchar(25) default NULL,
  `city_id` int(11) NOT NULL default '0',
  `address` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `ind_login_pass` (`u_login`,`u_pass`)
) AUTO_INCREMENT=4 ;

--
-- ���� ������ ������� `users`
--

INSERT INTO `users` (`id`, `status`, `u_key`, `u_login`, `u_pass`, `last_visit_dt`, `reg_date`, `activity`, `nick_name`, `first_name`, `second_name`, `last_name`, `email`, `cel_phone`, `home_phone`, `fax`, `city_id`, `address`) VALUES
(1, 1, 0, 'ccc', 'ccc', 1285742960, '', 14204, '1', '������', '', '�������', NULL, NULL, NULL, NULL, 0, NULL),
(2, 1, 4197442, 'smallll', 'smallll', 1285521575, '', 65, '2', '����������', ' ', '�������', NULL, NULL, NULL, NULL, 0, NULL),
(3, 1, 0, 'pro', 'pro', 1284217329, '', 6, '3', '�����', ' ', '������', NULL, NULL, NULL, NULL, 0, NULL);
