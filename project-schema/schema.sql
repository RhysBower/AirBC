# Account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Account`;

CREATE TABLE `Account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Account` (`id`, `name`, `email`, `username`, `password`)
VALUES
	(4194304,'Rhys Bower','rhys@airbc.ca','rbower','hashedpassword'),
	(4194305,'Mandy Chen','mandy@airbc.ca','mchen','hashedpassword'),
	(4194306,'Alison Wu','alison@airbc.ca','awu','hashedpassword'),
	(4194307,'Harryson Hu','harryson@airbc.ca','hhu','hashedpassword');

# Aircraft
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Aircraft`;

CREATE TABLE `Aircraft` (
  `id` char(7) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `first_class_seats` int(11) NOT NULL,
  `business_seats` int(11) NOT NULL,
  `economy_seats` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `status` enum('OK','REPAIR') NOT NULL DEFAULT 'OK',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Aircraft` (`id`, `type`, `first_class_seats`, `business_seats`, `economy_seats`, `purchase_date`, `status`)
VALUES
	('C-FONF','Fokker F28-1000',10,20,200,'2017-01-01','OK'),
	('C-FPWC','Boeing 737',10,20,200,'2017-01-01','OK'),
	('C-FQWL','Fairchild F-27',10,20,200,'2017-01-01','OK'),
	('C-FSKI','Canadair CL-600-2B19 (RJ100ER) Regional Jet',10,20,200,'2017-01-01','OK'),
	('C-FTCZ','Boeing 737-800',10,20,200,'2017-01-01','OK'),
	('C-FTJP','Airbus A320',10,20,200,'2017-01-01','OK'),
	('C-FTLU','McDonnell Douglas DC-9-32',10,20,200,'2017-01-01','OK'),
	('C-FTLV','McDonnell Douglas DC-9-32',10,20,200,'2017-01-01','OK'),
	('C-GAUN','Boeing 767-233',10,20,200,'2017-01-01','OK'),
	('C-GITS','Airbus A330-243',10,20,200,'2017-01-01','OK'),
	('C-GMXQ','Douglas DC-8-61',10,20,200,'2017-01-01','OK'),
	('C-GNWN','Boeing 737-200',10,20,200,'2017-01-01','OK'),
	('C-GPAT','Airbus A310-308',10,20,200,'2017-01-01','OK'),
	('C-GPTR','Ornithopter',10,20,200,'2017-01-01','OK'),
	('C-GZCH','Sikorsky S-92A',10,20,200,'2017-01-01','OK'),
	('CF-CPC','Douglas DC-4',10,20,200,'2017-01-01','OK'),
	('CF-CPK','Douglas DC-8-43',10,20,200,'2017-01-01','OK'),
	('CF-CUA','Douglas DC-3',10,20,200,'2017-01-01','OK'),
	('CF-CUQ','Douglas DC-6B',10,20,200,'2017-01-01','OK'),
	('CF-CZB','Bristol Britannia 314',10,20,200,'2017-01-01','OK'),
	('CF-EDN','Douglas C-54 Skymaster',10,20,200,'2017-01-01','OK'),
	('CF-TFD','Canadair North Star',10,20,200,'2017-01-01','OK'),
	('CF-TGR','Vickers Viscount',10,20,200,'2017-01-01','OK'),
	('CF-TIW','McDonnell Douglas DC-8-63',10,20,200,'2017-01-01','OK'),
	('CF-TJN','Douglas DC-8',10,20,200,'2017-01-01','OK'),
	('F-FKFY','Convair CV-580 Airtanker',10,20,200,'2017-01-01','OK');

# Airport
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Airport`;

CREATE TABLE `Airport` (
  `id` char(3) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Airport` (`id`, `name`)
VALUES
	('CJH','Chilko Lake (Tsylos Park Lodge) Aerodrome'),
	('CXH','Vancouver Harbour Water Airport'),
	('DUQ','Duncan Airport'),
	('WPL','Powell Lake Water Aerodrome'),
	('XQU','Qualicum Beach Airport'),
	('YAA','Anahim Lake Airport'),
	('YAL','Alert Bay Airport'),
	('YAZ','Tofino/Long Beach Airport'),
	('YBD','Bella Coola Airport'),
	('YBL','Campbell River Airport'),
	('YBO','Bob Quinn Lake Airport'),
	('YCA','Courtenay Airpark'),
	('YCD','Nanaimo Airport'),
	('YCF','Cortes Island Aerodome'),
	('YCG','Castlegar Airport'),
	('YCP','Blue River Airport'),
	('YCQ','Chetwynd Airport'),
	('YCW','Chiliwack Airport'),
	('YCZ','Fairmont Hot Springs Airport'),
	('YDL','Dease Lake Airport'),
	('YDQ','Bawson Creek Airport'),
	('YDT','Boundary Bay Airport'),
	('YGB','Texada/Gilies Bay Airport'),
	('YGE','Golden Airport'),
	('YGG','Ganges Water Aerodrome'),
	('YHE','Hope Aerodrome'),
	('YJM','Fort St. James (Perison) Airport'),
	('YKA','Kamloops Airport'),
	('YKK','Kikatla Water Aerodrome'),
	('YLW','Kelowna International Airport'),
	('YMB','Merritt Airport (Saunders Field)'),
	('YMP','Port McNeill Airport'),
	('YNH','Hundon\'s Hope Airport'),
	('YNJ','Langley Regional Airport'),
	('YPB','Port Alberni (Alberni Valley Regional) Airport'),
	('YPI','Port Simpson Water Aerodrome'),
	('YPK','Pitt Meadows Airport'),
	('YPR','Prince Rupert Airport'),
	('YPT','Pender Harbour Water Aerodrome'),
	('YPU','Puntzi Mountain Airport'),
	('YPW','Powell River Airport'),
	('YPZ','Burns Lake Airport'),
	('YQQ','CFB Comox (Comox Airport)'),
	('YQZ','Quesnel Airport'),
	('YRN','Rivers Inlet Water Aerodrome'),
	('YRV','Revelstoke Airport'),
	('YSE','Squamish Airport'),
	('YSN','Salmon Arm Airport'),
	('YSX','Bella Bella/Shearwater Water Aerodrome'),
	('YTB','Hartley Bay Water Aerodrome'),
	('YTG','Sulivan Bay Water Aerodrome'),
	('YVE','Vernon Regional Airport'),
	('YVR','Vancouver International Airport'),
	('YWH','Victoria Inner Harbour Airport (Victoria Harbour Water Airport)'),
	('YWL','Williams Lake Airport'),
	('YWS','Whistler/Green Lake Water Aerodrome'),
	('YXC','Cranbrook/Canadian Rockies International Airport'),
	('YXJ','Fort St. John Airport (North Peace Airport)'),
	('YXS','Prince George Airport'),
	('YXT','Northwest Regional Airport Terrace-Kitimat (Terrace Airport)'),
	('YXX','Abbotsford International Airport'),
	('YYD','Smithers Airport'),
	('YYE','Fort Nelson Airport'),
	('YYF','Penticton Tegional Airport'),
	('YYJ','Victoria International Airport'),
	('YZP','Sandspit Airport'),
	('YZT','Port Hardy Airport'),
	('YZY','Mackenzie Airport'),
	('ZEL','Denny Island Aerodrome'),
	('ZGF','Grand Forks Airport'),
	('ZMH','South Cariboo Rebional Airport (108 Mile Ranch Airport)'),
	('ZMT','Masset Airport'),
	('ZNA','Ocean Falls Water Aerodrome'),
	('ZOF','Ocean Falls Water Aerodrome'),
	('ZST','Stewart Awrodrome'),
	('ZSW','Prince Rupert/Seal Cover Water Airport'),
	('ZTS','Tahsis Water Aerodrome');

# Customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Customer`;

CREATE TABLE `Customer` (
  `id` int(11) unsigned NOT NULL,
  `travel_document` varchar(50) DEFAULT '',
  `billing_address` tinytext,
  `phone_number` char(11) DEFAULT NULL,
  `loyalty_member` tinyint(1) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `Account` FOREIGN KEY (`id`) REFERENCES `Account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Flight
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Flight`;

CREATE TABLE `Flight` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `assigned` char(7) NOT NULL DEFAULT '',
  `arrival` char(3) NOT NULL DEFAULT '',
  `departure` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Route` (`arrival`,`departure`),
  KEY `Aircraft` (`assigned`),
  CONSTRAINT `Aircraft` FOREIGN KEY (`assigned`) REFERENCES `Aircraft` (`id`),
  CONSTRAINT `Route` FOREIGN KEY (`arrival`, `departure`) REFERENCES `Route` (`arrival`, `departure`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Route
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Route`;

CREATE TABLE `Route` (
  `departure` char(3) NOT NULL DEFAULT '',
  `arrival` char(3) NOT NULL DEFAULT '',
  `first_class` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `economy` int(11) NOT NULL,
  PRIMARY KEY (`arrival`,`departure`),
  KEY `Departure` (`departure`),
  CONSTRAINT `Arrival` FOREIGN KEY (`arrival`) REFERENCES `Airport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Departure` FOREIGN KEY (`departure`) REFERENCES `Airport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Staff
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Staff`;

CREATE TABLE `Staff` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`),
  CONSTRAINT `MainAccount` FOREIGN KEY (`id`) REFERENCES `Account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Staff` (`id`, `title`)
VALUES
	(4194304,'Software Engineer'),
	(4194305,'Software Engineer'),
	(4194306,'Software Engineer'),
	(4194307,'Software Engineer');

# Ticket
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Ticket`;

CREATE TABLE `Ticket` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seat_type` enum('FIRST','BUSINESS','ECONOMY') NOT NULL DEFAULT 'ECONOMY',
  `flight` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
