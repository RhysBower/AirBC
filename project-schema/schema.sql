DROP TABLE if EXISTS `loyalty_member`, `staff`, `ticket`;
DROP TABLE if EXISTS `customer`, `flight`, `route`;
DROP TABLE if EXISTS `aircraft`, `airport`, `type`;

# Staff
# ------------------------------------------------------------

CREATE TABLE `Staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` char(64) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Staff` (`id`, `name`, `email`, `username`, `password`, `title`)
VALUES
	(1,'Rhys Bower','rhys@airbc.ca','rbower','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','Software Engineer'),
	(2,'Mandy Chen','mandy@airbc.ca','mchen','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','Software Engineer'),
	(3,'Alison Wu','alison@airbc.ca','awu','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','Software Engineer'),
	(4,'Harryson Hu','harryson@airbc.ca','hhu','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','Software Engineer'),
  (5,'Boss','boss@airbc.ca','boss','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','CEO');

# Customer
# ------------------------------------------------------------

CREATE TABLE `Customer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` char(64) NOT NULL DEFAULT '',
  `travel_document` varchar(50) NOT NULL DEFAULT '',
  `billing_address` varchar(50) NOT NULL DEFAULT '',
  `phone_number` varchar(50) NOT NULL DEFAULT '',
  `seat_preference` enum('FIRST','BUSINESS', 'ECONOMY') NOT NULL DEFAULT 'ECONOMY',
  `payment_information` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Customer` (`id`, `name`, `email`, `username`, `password`, `travel_document`, `billing_address`, `phone_number`, `seat_preference`, `payment_information`)
VALUES
	(1,'Adam','adam@customer.ca','adam','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:111','111 Adam Dr. Vancouver BC, Canada','111-222-3333','ECONOMY', 'Visa:1111-1111-1111-1111'),
  (2,'Bailey','bailey@customer.ca','bailey','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:222','222 Bailey Dr. Vancouver BC, Canada','222-222-3333','ECONOMY', 'Visa:2222-2222-2222-2222'),
  (3,'Carlos','carlos@customer.ca','carlos','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:333','333 Carlos Dr. Vancouver BC, Canada','333-222-3333','FIRST', 'Visa:3333-3333-3333-3333'),
  (4,'Darcy','darcy@customer.ca','darcy','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:444','444 Darcy Dr. Vancouver BC, Canada','444-222-3333','BUSINESS', 'Visa:4444-4444-4444-4444'),
  (5,'Eli','eli@customer.ca','eli','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:555','555 Eli Dr. Vancouver BC, Canada','555-222-3333','ECONOMY', 'Visa:5555-5555-5555-5555'),
  (6,'Florence','florence@customer.ca','florence','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:666','666 Florence Dr. Vancouver BC, Canada','666-222-3333','FIRST', 'Visa:6666-6666-6666-6666'),
  (7,'Grant','grant@customer.ca','grant','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:777','777 Grant Dr. Vancouver BC, Canada','777-222-3333','ECONOMY', 'Visa:7777-7777-7777-7777'),
  (8,'Hana','hana@customer.ca','hana','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:888','888 Hana Dr. Vancouver BC, Canada','888-222-3333','BUSINESS', 'Visa:8888-8888-8888-8888'),
  (9,'Issac','issac@customer.ca','issac','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:999','999 Issac Dr. Vancouver BC, Canada','999-222-3333','ECONOMY', 'Visa:9999-9999-9999-9999'),
  (10,'Jane','jane@customer.ca','jane','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Passport:000','000 Jane Dr. Vancouver BC, Canada','000-222-3333','BUSINESS', 'Visa:0000-0000-0000-0000');

# Loyalty_Member
# ------------------------------------------------------------

CREATE TABLE `Loyalty_Member` (
  `id` int(11) unsigned NOT NULL,
  `points` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `Loyalty_Member` FOREIGN KEY (`id`) REFERENCES `Customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Loyalty_Member` (`id`, `points`)
VALUES
	(1,0),
  (3,1500),
  (5,950),
  (7,25),
  (9,1150);

# Type
# ------------------------------------------------------------

CREATE TABLE `Type` (
  `type` varchar(50) NOT NULL DEFAULT '',
  `first_class_seats` int(11) NOT NULL,
  `business_seats` int(11) NOT NULL,
  `economy_seats` int(11) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Type` (`type`, `first_class_seats`, `business_seats`, `economy_seats`)
VALUES
	('Fokker F28-1000',10,20,200),
	('Boeing 737',10,20,200),
	('Fairchild F-27',10,20,200),
	('Canadair CL-600-2B19 (RJ100ER) Regional Jet',10,20,200),
	('Boeing 737-800',10,20,200),
	('Airbus A320',10,20,200),
	('McDonnell Douglas DC-9-32',10,20,200),
	('Boeing 767-233',10,20,200),
	('Airbus A330-243',10,20,200),
	('Douglas DC-8-61',10,20,200),
	('Boeing 737-200',10,20,200),
	('Airbus A310-308',10,20,200),
	('Ornithopter',10,20,200),
	('Sikorsky S-92A',10,20,200),
	('Douglas DC-4',10,20,200),
	('Douglas DC-8-43',10,20,200),
	('Douglas DC-3',10,20,200),
	('Douglas DC-6B',10,20,200),
	('Bristol Britannia 314',10,20,200),
	('Douglas C-54 Skymaster',10,20,200),
	('Canadair North Star',10,20,200),
	('Vickers Viscount',10,20,200),
	('McDonnell Douglas DC-8-63',10,20,200),
	('Douglas DC-8',10,20,200),
	('Convair CV-580 Airtanker',10,20,200);

# Aircraft
# ------------------------------------------------------------

CREATE TABLE `Aircraft` (
  `id` char(7) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `purchase_date` date NOT NULL,
  `status` enum('OK','REPAIR') NOT NULL DEFAULT 'OK',
  PRIMARY KEY (`id`),
  CONSTRAINT `Type` FOREIGN KEY (`type`) REFERENCES `Type` (`type`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Aircraft` (`id`, `type`, `purchase_date`, `status`)
VALUES
	('C-FONF','Fokker F28-1000','2017-01-01','OK'),
	('C-FPWC','Boeing 737','2017-01-01','OK'),
	('C-FQWL','Fairchild F-27','2017-01-01','OK'),
	('C-FSKI','Canadair CL-600-2B19 (RJ100ER) Regional Jet','2017-01-01','OK'),
	('C-FTCZ','Boeing 737-800','2017-01-01','OK'),
	('C-FTJP','Airbus A320','2017-01-01','OK'),
	('C-FTLU','McDonnell Douglas DC-9-32','2017-01-01','OK'),
	('C-FTLV','McDonnell Douglas DC-9-32','2017-01-01','OK'),
	('C-GAUN','Boeing 767-233','2017-01-01','OK'),
	('C-GITS','Airbus A330-243','2017-01-01','OK'),
	('C-GMXQ','Douglas DC-8-61','2017-01-01','OK'),
	('C-GNWN','Boeing 737-200','2017-01-01','OK'),
	('C-GPAT','Airbus A310-308','2017-01-01','OK'),
	('C-GPTR','Ornithopter','2017-01-01','OK'),
	('C-GZCH','Sikorsky S-92A','2017-01-01','OK'),
	('CF-CPC','Douglas DC-4','2017-01-01','OK'),
	('CF-CPK','Douglas DC-8-43','2017-01-01','REPAIR'),
	('CF-CUA','Douglas DC-3','2017-01-01','OK'),
	('CF-CUQ','Douglas DC-6B','2017-01-01','OK'),
	('CF-CZB','Bristol Britannia 314','2017-01-01','OK'),
	('CF-EDN','Douglas C-54 Skymaster','2017-01-01','OK'),
	('CF-TFD','Canadair North Star','2017-01-01','REPAIR'),
	('CF-TGR','Vickers Viscount','2017-01-01','OK'),
	('CF-TIW','McDonnell Douglas DC-8-63','2017-01-01','OK'),
	('CF-TJN','Douglas DC-8','2017-01-01','OK'),
	('F-FKFY','Convair CV-580 Airtanker','2017-01-01','REPAIR');

# Airport
# ------------------------------------------------------------

CREATE TABLE `Airport` (
  `id` char(3) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `location` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Airport` (`id`, `name`, `location`)
VALUES
	('CXH','Vancouver Harbour Water Airport','1055 Canada Place, Vancouver, BC V6C 3T4'),
	('DUQ','Duncan Airport','5100 Langtry Rd, Duncan, BC V9L 6R8'),
	('YAL','Alert Bay Airport','101 Alder Rd, Alert Bay, BC V0N 1A0'),
	('YBD','Bella Coola Airport','1685 Airport Road, Hagensborg, BC V0T 1H0'),
	('YBL','Campbell River Airport','2000 Jubilee Pkwy, Campbell River, BC V9H 1T5'),
	('YCA','Courtenay Airpark','1250 Knight Rd, Comox, BC V9M 4H2'),
	('YCD','Nanaimo Airport','3350 Spitfire Rd, Cassidy, BC V0R 1H0'),
	('YCW','Chilliwack Airport','46244 Airport Rd, Chilliwack, BC V2P 1A5'),
	('YCZ','Fairmont Hot Springs Airport','5192 Fairmont Airport Rd, Fairmont Hot Springs, BC V0B 1L1'),
	('YDQ','Dawson Creek Airport','80 Vic Turner Airport Rd, Pouce Coupe, BC V0C 2C0'),
	('YDT','Boundary Bay Airport','7800 Alpha Way, Delta, BC V4K 0A7'),
	('YGE','Golden Airport','214 Fisher Rd, Golden, BC V0A 1H0'),
	('YGG','Ganges Water Aerodrome','Ganges Harbor, BC V8K 2S3'),
	('YHE','Hope Aerodrome','62720 Airport Rd, Hope, BC V0X 1L2'),
	('YJM','Fort St. James (Perison) Airport','Airport Rd, Fort Saint James, BC V0J 1P0'),
	('YKA','Kamloops Airport','3035 Airport Rd, Kamloops, BC V2B 7X1'),
	('YLW','Kelowna International Airport','5533 Airport Way, Kelowna, BC V1V 1S1'),
	('YMP','Port McNeill Airport','1001 Airport Rd, Port McNeill, BC V0N 2R0'),
	('YNH','Hudson\'s Hope Airport','4142 Summer Rd, Hudson\'s Hope, BC V0C 1V0'),
	('YNJ','Langley Regional Airport','5385 216 St, Langley, BC V2Y 2N3'),
	('YPB','Port Alberni (Alberni Valley Regional) Airport','7400 Airport Rd, Port Alberni, BC V9Y 8Y9'),
	('YPK','Pitt Meadows Airport','18799 Airport Way, Pitt Meadows, BC V3Y 0A7'),
	('YPR','Prince Rupert Airport','Bag 4000, Prince Rupert, BC V8J 3S3'),
	('YQZ','Quesnel Airport','651 Airport Rd, Quesnel, BC V2J 6W6'),
	('YRV','Revelstoke Airport','2931 Airport Way, Revelstoke, BC V0E 2S1'),
	('YVE','Vernon Regional Airport',' 6300 Tronson Rd, Vernon, BC V1H 1N5'),
	('YVR','Vancouver International Airport','3211 Grant McConachie Way, Richmond, BC V7B 0A4'),
	('YWL','Williams Lake Airport','3000 Airport Rd, Williams Lake, BC V2G 5M1'),
	('YWS','Whistler/Green Lake Water Aerodrome','8069 Nicklaus N Blvd, Whistler, BC V0N 1B8'),
	('YXC','Cranbrook/Canadian Rockies International Airport','1-9370 Airport Access Rd, Cranbrook, BC V1C 7E4'),
	('YXJ','Fort St. John Airport (North Peace Airport)','9919 Terminal Rd, Fort St John, BC V1J 4H9'),
	('YXS','Prince George Airport','10, 4141 Airport Rd, Prince George, BC V2N 4M6'),
	('YXT','Northwest Regional Airport Terrace-Kitimat (Terrace Airport)','4401 Bristol road, Terrace, BC V8G 0E9'),
	('YXX','Abbotsford International Airport','30440 Liberator Ave, Abbotsford, BC V2T 6H5'),
	('YYD','Smithers Airport','6421 Airport Rd #1, Smithers, BC V0J 2N5'),
	('YYE','Fort Nelson Airport','Piper Rd, Fort Nelson, BC V0C 1R0'),
	('YYF','Penticton Regional Airport','3000 Airport Rd #109, Penticton, BC V2A 8X1'),
	('YYJ','Victoria International Airport','1640 Electra Blvd, Sidney, BC V8L 5V4'),
	('YZP','Sandspit Airport','1 Airport Rd, Sandspit, BC V0T 1T0'),
	('YZT','Port Hardy Airport','3675 Byng Rd, Port Hardy, BC V0N 2P0'),
	('ZMH','South Cariboo Regional Airport (108 Mile Ranch Airport)','Telqua Dr, 108 Mile Ranch, BC V0K 2Z0'),
	('ZMT','Masset Airport','1900 Towhill Rd, Masset, BC V0T 1M0');

# Route
# ------------------------------------------------------------

CREATE TABLE `Route` (
  `departure` char(3) NOT NULL DEFAULT '',
  `arrival` char(3) NOT NULL DEFAULT '',
  `first_class` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `economy` int(11) NOT NULL,
  PRIMARY KEY (`arrival`,`departure`),
  CONSTRAINT `Departure` FOREIGN KEY (`departure`) REFERENCES `Airport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Arrival` FOREIGN KEY (`arrival`) REFERENCES `Airport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Route` (`departure`, `arrival`, `first_class`, `business`, `economy`)
VALUES
	('YVR','YYJ',500,300,200),
  ('YYJ','YVR',500,300,200),
  ('YVR','YXS',600,400,300),
  ('YXS','YVR',600,400,300),
  ('YYJ','YXS',650,450,350),
  ('YXS','YYJ',650,450,350);

# Flight
# ------------------------------------------------------------

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

INSERT INTO `Flight` (`id`, `date_time`, `assigned`, `arrival`, `departure`)
VALUES
	(1,'2017-02-13 04:00:00','C-FONF','YVR','YYJ'),
  (2,'2017-02-13 07:00:00','C-FONF','YYJ','YVR'),
  (3,'2017-02-13 08:00:00','C-FQWL','YVR','YXS'),
  (4,'2017-02-13 12:00:00','C-FSKI','YVR','YXS'),
  (5,'2017-02-13 13:00:00','C-FTJP','YYJ','YXS'),
  (6,'2017-02-13 13:00:00','C-FTLU','YXS','YYJ');

# Ticket
# ------------------------------------------------------------

CREATE TABLE `Ticket` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seat_type` enum('FIRST','BUSINESS','ECONOMY') NOT NULL DEFAULT 'ECONOMY',
  `flightId` int(11) unsigned NOT NULL,
  `customerId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `Flight` FOREIGN KEY (`flightId`) REFERENCES `Flight` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Customer` FOREIGN KEY (`customerId`) REFERENCES `Customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Ticket` (`id`, `seat_type`, `flightId`, `customerId`)
VALUES
	(1,'ECONOMY',1,1),
  (2,'BUSINESS',1,2),
  (3,'FIRST',2,3),
  (4,'ECONOMY',2,3),
  (5,'ECONOMY',3,3),
  (6,'ECONOMY',4,4);
