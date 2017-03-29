DROP VIEW if EXISTS FullAircraft, FullCustomer, FullLoyaltyMember, FullStaff;
DROP TABLE if EXISTS Loyalty_Member, Staff, Ticket;
DROP TABLE if EXISTS Customer, Flight, Route;
DROP TABLE if EXISTS Aircraft, Airport, Type, Account;

# Account
# ------------------------------------------------------------
CREATE TABLE Account (
  id bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL CHECK (LENGTH(name)>0),
  email varchar(50) NOT NULL UNIQUE,
  username varchar(50) NOT NULL UNIQUE,
  password char(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1024;

INSERT INTO Account (id, name, email, username, password)
VALUES
	(1024,'Rhys Bower','rhys@airbc.ca','rbower','$2y$10$aecMr2mzHPoZtWNNfSJFuey9wTfrvSgSGn9hZZdW2WJFSwhNcl5Xy'),
	(1025,'Mandy Chen','mandy@airbc.ca','mchen','$2y$10$3p3UEluJ397wPcMWNQLcYO96g135gHj.TyIDO0TTmKKvQqKFFjHXu'),
	(1026,'Alison Wu','alison@airbc.ca','awu','$2y$10$cdmvvqJnmy2jz6NAqE3zHeASMPTakVBzuVPBdz6wsUSwK02beFOsG'),
	(1027,'Harryson Hu','harryson@airbc.ca','hhu','$2y$10$8vuy4VwwFL5anBY2Idl72Oc.iPTjxpr9bl.fpRhzLnKFGhCNwSGUy'),
  (1028,'Boss','boss@airbc.ca','boss','$2y$10$fYHrzcRXp27HEFkKgTVe3.QH.oFlCPRgktQIqaOZN2up6sYLVdfea'),
  (1029,'Adam','adam@customer.ca','adam','$2y$10$Tj.cZSIGlZh4oJB0GTnm0.FRkkSY85vIxmdvsrQqakjTGi1/51LLS'),
  (1030,'Bailey','bailey@customer.ca','bailey','$2y$10$Pv/7XgbKETiZrZDDDMrbxuidyzp6lCIdcXJeFbeDHBuY3zXOPT41.'),
  (1031,'Carlos','carlos@customer.ca','carlos','$2y$10$dSL2yCCK1SCtEOHqWQytWO.A0rk9ngmqwEfz5vZAOGrZVsFwOdYTS'),
  (1032,'Darcy','darcy@customer.ca','darcy','$2y$10$X4Z5NFJ8XmA.2ZOrhZXXfO7C1kD8sr07WIdNO/18neCHNcVbWWtOa'),
  (1033,'Eli','eli@customer.ca','eli','$2y$10$iV0anL6otg/yxPZgdr8nGez75NfWSiJTHdXn4MAEKA.bvc1ZzFqwO'),
  (1034,'Florence','florence@customer.ca','florence','$2y$10$6PF3Taw8StEt4YF6eoD4NOQVW46G5WRqZWskBdND5CsK0zwy/U.bW'),
  (1035,'Grant','grant@customer.ca','grant','$2y$10$i/zrPp0SuN5d5NbkVVxq6uc3OY9VnZ2/8zmtHH72PZlm0JCCFjFzO'),
  (1036,'Hana','hana@customer.ca','hana','$2y$10$aX.h/7UbQMc9WPzDmjrHb.wbPdkWmzYh8CqVdsbbsIEQSnIvVZ2nO'),
  (1037,'Issac','issac@customer.ca','issac','$2y$10$1LKWLZkxVIwSXSwJn2kcVub.QiF4gWjN9D/AJCHbJWeNuxOKQulA.'),
  (1038,'Jane','jane@customer.ca','jane','$2y$10$NMOa8ImcRVzKdvSgKT5Nsux71CdHpHunwXMgqfg4fJ5T85yIZeHNO');


# Staff
# ------------------------------------------------------------

CREATE TABLE Staff (
  id bigint(11) unsigned NOT NULL,
  title varchar(50) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id) REFERENCES Account (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO Staff (id, title)
VALUES
	(1024,'Software Engineer'),
	(1025,'Software Engineer'),
	(1026,'Software Engineer'),
	(1027,'Software Engineer'),
	(1028,'CEO');

# Customer
# ------------------------------------------------------------

CREATE TABLE Customer (
  id bigint(11) unsigned NOT NULL,
  travel_document varchar(50) NOT NULL,
  billing_address varchar(50) NOT NULL DEFAULT '',
  phone_number varchar(50) NOT NULL DEFAULT '',
  seat_preference enum('FIRST','BUSINESS', 'ECONOMY') NOT NULL DEFAULT 'ECONOMY',
  payment_information varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  FOREIGN KEY (id) REFERENCES Account (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO Customer (id, travel_document, billing_address, phone_number, seat_preference, payment_information)
VALUES
	(1029,'Passport:111','111 Adam Dr. Vancouver BC, Canada','111-222-3333','ECONOMY', 'Visa:1111-1111-1111-1111'),
	(1030,'Passport:222','222 Bailey Dr. Vancouver BC, Canada','222-222-3333','ECONOMY', 'Visa:2222-2222-2222-2222'),
	(1031,'Passport:333','333 Carlos Dr. Vancouver BC, Canada','333-222-3333','FIRST', 'Visa:3333-3333-3333-3333'),
	(1032,'Passport:444','444 Darcy Dr. Vancouver BC, Canada','444-222-3333','BUSINESS', 'Visa:4444-4444-4444-4444'),
	(1033,'Passport:555','555 Eli Dr. Vancouver BC, Canada','555-222-3333','ECONOMY', 'Visa:5555-5555-5555-5555'),
	(1034,'Passport:666','666 Florence Dr. Vancouver BC, Canada','666-222-3333','FIRST', 'Visa:6666-6666-6666-6666'),
	(1035,'Passport:777','777 Grant Dr. Vancouver BC, Canada','777-222-3333','ECONOMY', 'Visa:7777-7777-7777-7777'),
	(1036,'Passport:888','888 Hana Dr. Vancouver BC, Canada','888-222-3333','BUSINESS', 'Visa:8888-8888-8888-8888'),
	(1037,'Passport:999','999 Issac Dr. Vancouver BC, Canada','999-222-3333','ECONOMY', 'Visa:9999-9999-9999-9999'),
	(1038,'Passport:000','000 Jane Dr. Vancouver BC, Canada','000-222-3333','BUSINESS', 'Visa:0000-0000-0000-0000');

# Loyalty_Member
# ------------------------------------------------------------

CREATE TABLE Loyalty_Member (
  id bigint(11) unsigned NOT NULL,
  points int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id) REFERENCES Customer (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO Loyalty_Member (id, points)
VALUES
	(1029,0),
	(1031,1500),
	(1033,950),
	(1035,25),
	(1037,1150);

# Type
# ------------------------------------------------------------

CREATE TABLE Type (
  type varchar(50) NOT NULL,
  first_class_seats int(11) NOT NULL CHECK (first_class_seats>=0),
  business_seats int(11) NOT NULL CHECK (business_seats>=0),
  economy_seats int(11) NOT NULL CHECK (economy_seats>=0),
  PRIMARY KEY (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO Type (type, first_class_seats, business_seats, economy_seats)
VALUES
	('Fokker F28-1000',10,20,200),
	('Boeing 737',30,50,450),
	('Fairchild F-27',10,20,200),
	('Canadair CL-600-2B19 (RJ100ER) Regional Jet',20,20,200),
	('Boeing 737-800',10,20,200),
	('Airbus A320',10,20,200),
	('McDonnell Douglas DC-9-32',30,10,200),
	('Boeing 767-233',50,50,400),
	('Airbus A330-243',15,25,350),
	('Douglas DC-8-61',10,20,200),
	('Boeing 737-200',20,35,400),
	('Airbus A310-308',10,20,200),
	('Ornithopter',10,20,200),
	('Sikorsky S-92A',15,15,200),
	('Douglas DC-4',10,20,200),
	('Douglas DC-8-43',10,20,200),
	('Douglas DC-3',10,20,200),
	('Douglas DC-6B',10,20,200),
	('Bristol Britannia 314',30,25,200),
	('Douglas C-54 Skymaster',10,20,200),
	('Canadair North Star',10,20,200),
	('Vickers Viscount',30,10,150),
	('McDonnell Douglas DC-8-63',25,10,200),
	('Douglas DC-8',10,20,200),
	('Convair CV-580 Airtanker',10,20,200);

# Aircraft
# ------------------------------------------------------------

CREATE TABLE Aircraft (
  id char(7) NOT NULL,
  type varchar(50) NOT NULL,
  purchase_date date NOT NULL,
  status enum('OK','REPAIR') NOT NULL DEFAULT 'OK',
  PRIMARY KEY (id),
  FOREIGN KEY (type) REFERENCES Type (type) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO Aircraft (id, type, purchase_date, status)
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

CREATE TABLE Airport (
  id char(3) NOT NULL CHECK (LENGTH(id)=3),
  name varchar(100) NOT NULL UNIQUE,
  location varchar(100) NOT NULL UNIQUE,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO Airport (id, name, location)
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

CREATE TABLE Route (
  departure char(3) NOT NULL CHECK (LENGTH(departure)=3),
  arrival char(3) NOT NULL CHECK (LENGTH(arrival)=3),
  first_class int(11) NOT NULL CHECK (first_class>=0),
  business int(11) NOT NULL CHECK (business>=0),
  economy int(11) NOT NULL CHECK (economy>=0),
  PRIMARY KEY (arrival,departure),
  FOREIGN KEY (departure) REFERENCES Airport (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (arrival) REFERENCES Airport (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO Route (departure, arrival, first_class, business, economy)
VALUES
	('YVR','YYJ',500,300,200),
  	('YYJ','YVR',500,300,200),
  	('YVR','YXS',600,400,300),
  	('YXS','YVR',600,400,300),
  	('YYJ','YXS',650,450,350),
  	('YXS','YYJ',650,450,350);

# Flight
# ------------------------------------------------------------

CREATE TABLE Flight (
  id bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  date_time datetime NOT NULL,
  assigned char(7) NOT NULL,
  arrival char(3) NOT NULL CHECK (LENGTH(arrival)=3),
  departure char(3) NOT NULL CHECK (LENGTH(departure)=3),
  PRIMARY KEY (id),
  FOREIGN KEY (assigned) REFERENCES Aircraft (id),
  FOREIGN KEY (arrival, departure) REFERENCES Route (arrival, departure) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1024;

INSERT INTO Flight (id, date_time, assigned, arrival, departure)
VALUES
	(1024,'2017-02-13 04:00:00','C-FONF','YVR','YYJ'),
 	(1025,'2017-02-13 07:00:00','C-FONF','YYJ','YVR'),
 	(1026,'2017-02-13 08:00:00','C-FQWL','YVR','YXS'),
 	(1027,'2017-02-13 12:00:00','C-FSKI','YVR','YXS'),
 	(1028,'2017-02-13 13:00:00','C-FTJP','YYJ','YXS'),
 	(1029,'2017-02-13 13:00:00','C-FTLU','YXS','YYJ');

# Ticket
# ------------------------------------------------------------

CREATE TABLE Ticket (
  id bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  seat_type enum('FIRST','BUSINESS','ECONOMY') NOT NULL DEFAULT 'ECONOMY',
  flightId bigint(11) unsigned NOT NULL,
  customerId bigint(11) unsigned NOT NULL,
  purchasedBy bigint(11) unsigned NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (flightId) REFERENCES Flight (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (customerId) REFERENCES Customer (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (purchasedBy) REFERENCES Account (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1024;

INSERT INTO Ticket (id, seat_type, flightId, customerId, purchasedBy)
VALUES
	(1024,'ECONOMY',1024,1029, 1029),
  (1025,'BUSINESS',1024,1030, 1030),
  (1026,'FIRST',1025,1031, 1031),
  (1027,'ECONOMY',1025,1031, 1031),
  (1028,'ECONOMY',1026,1031, 1031),
  (1029,'ECONOMY',1027,1032, 1032);

# Views
# ------------------------------------------------------------
CREATE VIEW FullAircraft AS
  SELECT id, Aircraft.type, purchase_date, status, first_class_seats, business_seats, economy_seats
  	from Aircraft JOIN Type WHERE Aircraft.type=Type.type;

CREATE VIEW FullStaff AS
  SELECT Account.id, name, email, username, password, title
  	from Account, Staff WHERE Account.id=Staff.id;

CREATE VIEW FullCustomer AS
  SELECT Account.id, name, email, username, password, travel_document,
  billing_address, phone_number, seat_preference, payment_information
  	from Account, Customer WHERE Account.id=Customer.id;

CREATE VIEW FullLoyaltyMember AS
  SELECT Account.id, name, email, username, password, travel_document,
  billing_address, phone_number, seat_preference, payment_information, points
  	from Account, Customer, Loyalty_Member WHERE Account.id=Customer.id AND Account.id=Loyalty_Member.id;
