/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.13-MariaDB : Database - xero
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`xero` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `xero`;

/*Table structure for table `bookings` */

DROP TABLE IF EXISTS `bookings`;

CREATE TABLE `bookings` (
  `bookingid` varchar(15) NOT NULL,
  `customerid` varchar(15) NOT NULL,
  `officeid` varchar(15) NOT NULL,
  `pickuptime` datetime NOT NULL,
  `returntime` datetime NOT NULL,
  `pickuplocation` varchar(30) NOT NULL,
  `returnlocation` varchar(30) NOT NULL,
  `durationinhours` int(11) NOT NULL,
  `carid` varchar(15) NOT NULL,
  `carcost` double NOT NULL,
  `driverid` varchar(15) DEFAULT NULL,
  `drivercost` double NOT NULL,
  `totalcost` double NOT NULL,
  `paymentmethod` varchar(30) NOT NULL,
  `confirmstatus` varchar(30) NOT NULL DEFAULT 'pending',
  `staffid` varchar(15) DEFAULT NULL,
  `bookingtime` datetime NOT NULL,
  PRIMARY KEY (`bookingid`),
  KEY `officeid` (`officeid`),
  KEY `customerid` (`customerid`),
  KEY `carid` (`carid`),
  KEY `driverid` (`driverid`),
  KEY `staffid` (`staffid`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`officeid`) REFERENCES `offices` (`officeid`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`customerid`) REFERENCES `customers` (`customerid`),
  CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`carid`) REFERENCES `officecars` (`carid`),
  CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`driverid`) REFERENCES `drivers` (`driverid`),
  CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`staffid`) REFERENCES `staffs` (`staffid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bookings` */

insert  into `bookings`(`bookingid`,`customerid`,`officeid`,`pickuptime`,`returntime`,`pickuplocation`,`returnlocation`,`durationinhours`,`carid`,`carcost`,`driverid`,`drivercost`,`totalcost`,`paymentmethod`,`confirmstatus`,`staffid`,`bookingtime`) values ('booking6','cus1','office1','2017-04-07 06:30:00','2017-04-10 06:30:00','No (10) 64 Road, 33x34 Streets','No (10) 64 Road, 33x34 Streets',72,'carid14',432,'driver18',96,528,'Pay at Arrival','confirmed','staff1','2017-04-23 23:09:09'),('booking8','cus6','office1','2017-04-27 06:30:00','2017-04-29 06:30:00','Mandalay Office','Mandalay Office',48,'carid19',216,'nodriver',0,216,'Pay at Arrival','confirmed','staff1','2017-04-23 23:14:07'),('booking9','cus1','office1','2017-05-10 05:30:00','2017-05-13 05:30:00','Mandalay Office','Mandalay Office',72,'carid19',324,'nodriver',0,324,'Pay at Arrival','declined','staff1','2017-04-24 22:02:08');

/*Table structure for table `carratings` */

DROP TABLE IF EXISTS `carratings`;

CREATE TABLE `carratings` (
  `carno` varchar(15) NOT NULL,
  `customerid` varchar(15) NOT NULL,
  `carrating` int(11) DEFAULT NULL,
  `carreview` varchar(100) DEFAULT NULL,
  `ratingtime` datetime NOT NULL,
  PRIMARY KEY (`carno`,`customerid`),
  KEY `customerid` (`customerid`),
  CONSTRAINT `carratings_ibfk_1` FOREIGN KEY (`carno`) REFERENCES `cars` (`carno`),
  CONSTRAINT `carratings_ibfk_2` FOREIGN KEY (`customerid`) REFERENCES `customers` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `carratings` */

insert  into `carratings`(`carno`,`customerid`,`carrating`,`carreview`,`ratingtime`) values ('car1','cus1',3,'Hello!','2017-04-24 23:05:55'),('car1','cus2',4,'This car is great! I like it! The price is also re','0000-00-00 00:00:00'),('car1','cus3',5,'I love this car! Enjoyable Ride!','0000-00-00 00:00:00'),('car3','cus8',5,'Good!','2017-04-24 16:12:46'),('car8','cus4',3,'I think it is a bit expensive! ','0000-00-00 00:00:00'),('car8','cus5',4,'Great Car! I just love it!','0000-00-00 00:00:00');

/*Table structure for table `cars` */

DROP TABLE IF EXISTS `cars`;

CREATE TABLE `cars` (
  `carno` varchar(15) NOT NULL,
  `carname` varchar(30) NOT NULL,
  `carclass` varchar(30) NOT NULL,
  `cartransmission` varchar(30) NOT NULL,
  `carcost` double NOT NULL,
  `cartype` varchar(30) NOT NULL,
  `carcapacity` int(11) NOT NULL,
  `carairbag` int(11) NOT NULL,
  `carotherdescription` varchar(50) NOT NULL,
  `carrating` int(11) DEFAULT NULL,
  `carphoto` varchar(30) NOT NULL,
  PRIMARY KEY (`carno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cars` */

insert  into `cars`(`carno`,`carname`,`carclass`,`cartransmission`,`carcost`,`cartype`,`carcapacity`,`carairbag`,`carotherdescription`,`carrating`,`carphoto`) values ('car1','Toyota Vitz','Van','Auto',23,'Economy',4,4,'Cruise Control',4,'4.png'),('car10','Ford Mustang','Van','Auto',29,'Sporty',2,2,'Others',5,'Ford Mustang.png'),('car11','Lincoln Navigator','Truck','Auto',38,'Luxury',7,5,'Others',NULL,'Lincoln Navigator.png'),('car2','Honda Civic','Van','Manual',25,'Sporty',5,4,'Others',5,'4.png'),('car3','Jeep Renegade','SUV','Manual',35,'SUV',5,2,'Others',5,'Jeep Renegade.png'),('car4','Hyundai Santa Fe','Truck','Auto',36,'SUV',5,2,'Others',5,'Hyundai Santa Fe.png'),('car5','Lincoln Navigator','Truck','Auto',38,'Luxury',7,5,'Others',5,'Lincoln Navigator.png'),('car6','Audi Q3','SUV','Auto',36,'Premium',5,4,'Others',5,'Audi Q3.png'),('car7','Dodge Challenger','Van','Auto',26,'Sporty',2,2,'Others',5,'Dodge Challenger.png'),('car8','Nissan Frontier','Truck','Auto',28,'Premium',2,2,'Nissan Frontier',4,'Nissan Frontier.png'),('car9','Buick Verano','Van','Auto',27,'Premium',5,2,'Others',5,'Buick Verano.png');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `customerid` varchar(15) NOT NULL,
  `customername` varchar(30) NOT NULL,
  `customeremail` varchar(30) NOT NULL,
  `customerusername` varchar(30) NOT NULL,
  `customerpassword` varchar(50) NOT NULL,
  `customergender` varchar(15) NOT NULL,
  `customerdob` date NOT NULL,
  `customerphoto` varchar(30) DEFAULT NULL,
  `signuptime` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customers` */

insert  into `customers`(`customerid`,`customername`,`customeremail`,`customerusername`,`customerpassword`,`customergender`,`customerdob`,`customerphoto`,`signuptime`,`active`) values ('cus1','Zin Min Htet','zinminht3t@gmail.com','zinminht3t','f4ad231214cb99a985dff0f056a36242','male','1996-10-24','customer.png','2017-04-23 00:13:08',1),('cus2','Tom','tom@gmail.com','tomtomtom','f4ad231214cb99a985dff0f056a36242','male','1996-07-11','customer.png','2017-04-23 06:21:52',1),('cus3','Aung Kyaw Kyaw','aungkyawkyaw@gmail.com','aungkyawkyaw','f4ad231214cb99a985dff0f056a36242','male','1994-11-22','customer.png','2017-04-23 06:21:52',1),('cus4','John Legends','johnlegends@gmail.com','johnlegends','f4ad231214cb99a985dff0f056a36242','male','1996-05-17','customer.png','2017-04-23 06:21:52',1),('cus5','Sam Smiths','samsmiths@gmail.com','samsmiths','f4ad231214cb99a985dff0f056a36242','male','1996-07-02','customer.png','2017-04-23 06:21:52',1),('cus6','John Doe','johndoe@gmail.com','johndoe123','f4ad231214cb99a985dff0f056a36242','male','1996-10-03','customer.png','2017-04-23 06:21:52',1),('cus7','zin min htet','zinminhtet@gmail.com','customer','f4ad231214cb99a985dff0f056a36242','male','1996-02-01','customer.png','2017-04-23 16:54:41',1),('cus8','Aung Kaung Myat','akm97akm@gmail.com','akm97akm','f4ad231214cb99a985dff0f056a36242','male','1996-10-22','customer.png','2017-04-24 15:57:05',1),('cus9','Khun Si Thar','khunsithar7rs@gmail.com','khunsithar','f4ad231214cb99a985dff0f056a36242','','0000-00-00',NULL,'0000-00-00 00:00:00',1);

/*Table structure for table `driverratings` */

DROP TABLE IF EXISTS `driverratings`;

CREATE TABLE `driverratings` (
  `driverid` varchar(15) NOT NULL,
  `customerid` varchar(15) NOT NULL,
  `driverrating` int(11) NOT NULL,
  `driverreview` varchar(50) NOT NULL,
  `ratingtime` datetime NOT NULL,
  PRIMARY KEY (`driverid`,`customerid`),
  KEY `customerid` (`customerid`),
  CONSTRAINT `driverratings_ibfk_1` FOREIGN KEY (`driverid`) REFERENCES `drivers` (`driverid`),
  CONSTRAINT `driverratings_ibfk_2` FOREIGN KEY (`customerid`) REFERENCES `customers` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `driverratings` */

insert  into `driverratings`(`driverid`,`customerid`,`driverrating`,`driverreview`,`ratingtime`) values ('driver34','cus1',3,'fsadf','2017-04-24 02:46:06'),('driver34','cus2',5,'Great!','0000-00-00 00:00:00'),('driver34','cus3',5,'Friendly!','0000-00-00 00:00:00');

/*Table structure for table `drivers` */

DROP TABLE IF EXISTS `drivers`;

CREATE TABLE `drivers` (
  `driverid` varchar(15) NOT NULL,
  `drivername` varchar(30) NOT NULL,
  `driverusername` varchar(15) NOT NULL,
  `driverpassword` varchar(50) NOT NULL,
  `driverage` int(11) NOT NULL,
  `driverrating` int(11) NOT NULL,
  `driverstatus` varchar(30) NOT NULL,
  `officeid` varchar(30) NOT NULL,
  `drivercost` double NOT NULL,
  `drivergender` varchar(30) NOT NULL,
  `driverphoto` varchar(30) NOT NULL,
  `driveremail` varchar(30) NOT NULL,
  `licensephoto` varchar(30) DEFAULT NULL,
  `driverexperience` varchar(30) NOT NULL,
  `driversignuptime` datetime NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`driverid`),
  KEY `officeid` (`officeid`),
  CONSTRAINT `drivers_ibfk_1` FOREIGN KEY (`officeid`) REFERENCES `offices` (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `drivers` */

insert  into `drivers`(`driverid`,`drivername`,`driverusername`,`driverpassword`,`driverage`,`driverrating`,`driverstatus`,`officeid`,`drivercost`,`drivergender`,`driverphoto`,`driveremail`,`licensephoto`,`driverexperience`,`driversignuptime`,`lastlogin`,`Active`) values ('driver1','Justina Davenport','driver','c974f63abee678d0e103167ad9c813a5',21,5,'employee','office1',39,'male','driver1.png','zinminht3t@gmail.com','license1.png','10','2017-02-08 09:00:00','2017-04-24 23:16:53',1),('driver10','Rana Harper','CadeBurke','c974f63abee678d0e103167ad9c813a5',42,0,'employee','office2',32,'male','driver1.png','dui.in@nonummy.org','license.png','4','2017-02-08 09:00:00',NULL,1),('driver11','Alexander Harrison','HilaryWalls','c974f63abee678d0e103167ad9c813a5',32,0,'employee','office5',38,'female','driver1.png','ornare.lectus.justo@magnisdisp','license.png','5','2017-02-08 09:00:00',NULL,1),('driver12','Zenia Faulkner','PriceWarner','c974f63abee678d0e103167ad9c813a5',41,0,'freelance','office2',37,'female','driver1.png','ipsum.nunc@Crasegetnisi.net','license.png','5','2017-02-08 09:00:00',NULL,1),('driver13','Eden Alston','CalistaNash','c974f63abee678d0e103167ad9c813a5',21,0,'freelance','office5',40,'male','driver1.png','lacus@erat.net','license.png','4','2017-02-08 09:00:00',NULL,1),('driver14','Camille Guy','HuButler','c974f63abee678d0e103167ad9c813a5',48,0,'employee','office2',24,'female','driver1.png','Donec.dignissim@anteVivamusnon','license.png','6','2017-02-08 09:00:00',NULL,1),('driver15','Aubrey Juarez','EthanMaxwell','c974f63abee678d0e103167ad9c813a5',25,0,'freelance','office5',29,'female','driver1.png','cubilia.Curae@justoPraesent.or','license.png','8','2017-02-08 09:00:00',NULL,1),('driver16','Edan Figueroa','MelvinJohnston','c974f63abee678d0e103167ad9c813a5',48,0,'employee','office3',23,'male','driver1.png','euismod@utnisia.net','license.png','9','2017-02-08 09:00:00',NULL,1),('driver17','Malachi Moon','DillonEspinoza','c974f63abee678d0e103167ad9c813a5',37,0,'employee','office4',34,'female','driver1.png','Etiam@euneque.ca','license.png','4','2017-02-08 09:00:00',NULL,1),('driver18','Alec Wiley','GriffinDuffy','c974f63abee678d0e103167ad9c813a5',28,0,'freelance','office1',32,'female','driver1.png','ligula.consectetuer@velit.co.u','license.png','7','2017-02-08 09:00:00',NULL,1),('driver19','Porter Cameron','BellDaniels','c974f63abee678d0e103167ad9c813a5',34,0,'freelance','office5',28,'female','driver1.png','urna.et@vehicularisus.com','license.png','4','2017-02-08 09:00:00',NULL,1),('driver2','Yasir Conley','SimonMclaughlin','c974f63abee678d0e103167ad9c813a5',20,0,'employee','office1',27,'male','driver1.png','quis.pede.Praesent@Vivamusmole','license.png','4','2017-02-08 09:00:00',NULL,1),('driver20','Shelly Barnett','GiacomoRoberson','c974f63abee678d0e103167ad9c813a5',30,0,'freelance','office2',38,'male','driver1.png','a.mi@elitdictum.ca','license.png','8','2017-02-08 09:00:00',NULL,1),('driver21','Abel Rosales','QuincyDavenport','c974f63abee678d0e103167ad9c813a5',32,0,'freelance','office5',35,'male','driver1.png','ante.ipsum@euerat.com','license.png','6','2017-02-08 09:00:00',NULL,1),('driver22','Porter Delgado','StephenWalters','c974f63abee678d0e103167ad9c813a5',41,0,'freelance','office3',39,'male','driver1.png','ipsum.nunc.id@mollisdui.edu','license.png','6','2017-02-08 09:00:00',NULL,1),('driver23','Sopoline Sawyer','MeredithWatts','c974f63abee678d0e103167ad9c813a5',23,0,'freelance','office5',40,'female','driver1.png','in@MaurismagnaDuis.ca','license.png','9','2017-02-08 09:00:00',NULL,1),('driver24','Carter Wallace','BertGallegos','c974f63abee678d0e103167ad9c813a5',27,0,'freelance','office1',27,'male','driver1.png','sed.sem.egestas@sagittislobort','license.png','6','2017-02-08 09:00:00',NULL,0),('driver25','Nell Michael','NoahWatkins','c974f63abee678d0e103167ad9c813a5',43,0,'freelance','office2',27,'female','driver1.png','lorem@auctorvelit.co.uk','license.png','5','2017-02-08 09:00:00',NULL,1),('driver26','Brenden May','CharissaSmith','c974f63abee678d0e103167ad9c813a5',42,0,'employee','office5',36,'male','driver1.png','pede.malesuada@et.org','license.png','5','2017-02-08 09:00:00',NULL,1),('driver27','Leo Curry','FleurWilkins','c974f63abee678d0e103167ad9c813a5',29,0,'freelance','office2',32,'female','driver1.png','elit.pellentesque@hendreritDon','license.png','6','2017-02-08 09:00:00',NULL,1),('driver28','Darrel Mcpherson','ShoshanaPhelps','c974f63abee678d0e103167ad9c813a5',43,0,'employee','office3',35,'female','driver1.png','dapibus.quam.quis@dapibus.co.u','license.png','10','2017-02-08 09:00:00',NULL,1),('driver29','Ferris Stevens','HedleyWong','c974f63abee678d0e103167ad9c813a5',36,0,'employee','office3',36,'male','driver1.png','Fusce.aliquam.enim@variusorcii','license.png','8','2017-02-08 09:00:00',NULL,1),('driver3','Brynn Hendrix','ClaudiaCash','c974f63abee678d0e103167ad9c813a5',47,0,'freelance','office1',31,'male','driver1.png','nec.euismod@magnisdisparturien','license.png','10','2017-02-08 09:00:00',NULL,1),('driver30','Barry Rivers','MaggyJoyner','c974f63abee678d0e103167ad9c813a5',41,0,'employee','office5',39,'female','driver1.png','accumsan.convallis.ante@Curabi','license.png','4','2017-02-08 09:00:00',NULL,1),('driver31','Simon Welch','ScarletRodrique','c974f63abee678d0e103167ad9c813a5',30,0,'employee','office2',33,'male','driver1.png','Nulla.tincidunt@temporlorem.co','license.png','8','2017-02-08 09:00:00',NULL,1),('driver32','Amelia Parker','IsaacGreer','c974f63abee678d0e103167ad9c813a5',44,0,'employee','office3',39,'female','driver1.png','Morbi@Fuscefeugiat.org','license.png','7','2017-02-08 09:00:00',NULL,1),('driver33','Karen Henderson','YuliForbes','c974f63abee678d0e103167ad9c813a5',32,0,'employee','office2',23,'female','driver1.png','egestas@Proin.com','license.png','8','2017-02-08 09:00:00',NULL,1),('driver34','Brenda Gordon','DustinGibbs','c974f63abee678d0e103167ad9c813a5',25,4,'employee','office3',27,'female','driver1.png','turpis@Nuncmauriselit.com','license.png','9','2017-02-08 09:00:00',NULL,1),('driver35','Colorado Joyner','PhyllisDonaldso','c974f63abee678d0e103167ad9c813a5',33,0,'freelance','office5',31,'female','driver1.png','Nam@Aliquamerat.org','license.png','6','2017-02-08 09:00:00',NULL,1),('driver36','Abbot Barker','LuciusAbbott','c974f63abee678d0e103167ad9c813a5',34,0,'employee','office4',40,'female','driver1.png','ut@Nullam.org','license.png','8','2017-02-08 09:00:00',NULL,1),('driver37','Sierra Roth','CassadyRivera','c974f63abee678d0e103167ad9c813a5',34,0,'freelance','office5',37,'female','driver1.png','consectetuer.euismod@neque.ca','license.png','3','2017-02-08 09:00:00',NULL,1),('driver38','Len Delgado','VielkaWalton','c974f63abee678d0e103167ad9c813a5',48,0,'freelance','office4',21,'male','driver1.png','Mauris@et.co.uk','license.png','3','2017-02-08 09:00:00',NULL,1),('driver39','Natalie Peters','TyroneHoover','c974f63abee678d0e103167ad9c813a5',37,0,'freelance','office4',23,'female','driver1.png','consectetuer@fringillaestMauri','license.png','7','2017-02-08 09:00:00',NULL,1),('driver4','Yen Parsons','MaceyMorrow','c974f63abee678d0e103167ad9c813a5',33,0,'employee','office3',21,'male','driver1.png','erat.volutpat.Nulla@molestieph','license.png','7','2017-02-08 09:00:00',NULL,1),('driver40','Cameran West','LibertyCrosby','c974f63abee678d0e103167ad9c813a5',20,0,'freelance','office3',27,'female','driver1.png','Cras.vulputate.velit@iaculis.e','license.png','6','2017-02-08 09:00:00',NULL,1),('driver41','Genevieve Gaines','JenniferWallace','c974f63abee678d0e103167ad9c813a5',46,0,'freelance','office3',23,'female','driver1.png','facilisis.lorem.tristique@volu','license.png','9','2017-02-08 09:00:00',NULL,1),('driver42','Candace Foley','MalcolmWilson','c974f63abee678d0e103167ad9c813a5',36,0,'freelance','office4',35,'female','driver1.png','sapien@tinciduntpede.net','license.png','10','2017-02-08 09:00:00',NULL,1),('driver43','Stacey Newman','GrayLara','c974f63abee678d0e103167ad9c813a5',32,0,'employee','office5',34,'male','driver1.png','ante@rhoncusNullam.edu','license.png','7','2017-02-08 09:00:00',NULL,1),('driver44','Wayne Caldwell','BellRocha','c974f63abee678d0e103167ad9c813a5',25,0,'employee','office5',20,'female','driver1.png','risus.Duis.a@pharetraNam.edu','license.png','4','2017-02-08 09:00:00',NULL,1),('driver45','Elaine Parrish','NoelleBuckner','c974f63abee678d0e103167ad9c813a5',23,0,'employee','office1',32,'male','driver1.png','cursus.luctus.ipsum@consequatn','license.png','6','2017-02-08 09:00:00',NULL,1),('driver46','Malachi Knapp','RyderSalas','c974f63abee678d0e103167ad9c813a5',23,0,'employee','office1',38,'female','driver1.png','gravida.mauris@Donec.edu','license.png','8','2017-02-08 09:00:00',NULL,1),('driver47','Hayes Harding','BrynnLloyd','c974f63abee678d0e103167ad9c813a5',46,0,'freelance','office4',26,'male','driver1.png','Morbi.non.sapien@sitamet.net','license.png','10','2017-02-08 09:00:00',NULL,1),('driver48','Jelani Wise','PandoraCameron','c974f63abee678d0e103167ad9c813a5',34,0,'employee','office5',31,'female','driver1.png','gravida@varius.edu','license.png','6','2017-02-08 09:00:00',NULL,1),('driver49','Angela Sloan','KeefeSalazar','c974f63abee678d0e103167ad9c813a5',35,0,'freelance','office1',24,'male','driver1.png','odio.Aliquam.vulputate@atarcu.','license.png','7','2017-02-08 09:00:00',NULL,1),('driver5','Maia Bowman','FultonCampos','c974f63abee678d0e103167ad9c813a5',25,0,'employee','office1',32,'female','driver1.png','amet.ultricies@ipsum.com','license.png','7','2017-02-08 09:00:00',NULL,1),('driver50','Buffy Stevens','DarrelArmstrong','c974f63abee678d0e103167ad9c813a5',27,0,'employee','office2',39,'male','driver1.png','felis.adipiscing@euismod.edu','license.png','3','2017-02-08 09:00:00',NULL,1),('driver6','Deirdre English','FaithBrock','c974f63abee678d0e103167ad9c813a5',39,0,'employee','office2',40,'female','driver1.png','odio.Nam.interdum@nonummyFusce','license.png','3','2017-02-08 09:00:00',NULL,1),('driver7','Frances Conley','CarlRice','c974f63abee678d0e103167ad9c813a5',24,0,'employee','office4',34,'female','driver1.png','dui.Cras.pellentesque@Proin.or','license.png','10','2017-02-08 09:00:00',NULL,1),('driver8','Kirby Skinner','ChantaleMeyers','c974f63abee678d0e103167ad9c813a5',46,0,'employee','office5',35,'male','driver1.png','interdum.Sed@cursusInteger.co.','license.png','7','2017-02-08 09:00:00',NULL,1),('driver9','Sara Powers','NoelBlackwell','c974f63abee678d0e103167ad9c813a5',50,0,'employee','office4',38,'female','driver1.png','sapien.cursus.in@malesuadaut.e','license.png','9','2017-02-08 09:00:00',NULL,1),('nodriver','nodriver','nodriver','nodriver',0,1,'nodriver','office1',0,'nodriver','nodriver','nodriver','nodriver','nodriver','0000-00-00 00:00:00',NULL,1);

/*Table structure for table `mails` */

DROP TABLE IF EXISTS `mails`;

CREATE TABLE `mails` (
  `feedbackid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `feedback` varchar(150) DEFAULT NULL,
  `sendtime` datetime NOT NULL,
  PRIMARY KEY (`feedbackid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `mails` */

insert  into `mails`(`feedbackid`,`name`,`email`,`feedback`,`sendtime`) values (1,'Zin Min Htet','zinminht3t@gmail.com','Hello It is me!\r\n','2017-04-18 02:31:19'),(2,'Zin Min Htet','zinminht3t@gmail.com','Hello! I am new to this website! Can you explain the process of this system!','2017-04-19 00:17:33'),(3,'sdfa','sdaf@gmail.com','sadfsdfasdf','2017-04-19 00:17:57'),(5,'Zin Min Htet','zinminht3t@gmail.com','Hello, the website is great!','2017-04-23 22:11:03'),(6,'Mg Mg','mgmgmgmg@gmail.com','How to make the booking?','2017-04-24 02:55:47');

/*Table structure for table `officecars` */

DROP TABLE IF EXISTS `officecars`;

CREATE TABLE `officecars` (
  `officeid` varchar(15) DEFAULT NULL,
  `carno` varchar(15) DEFAULT NULL,
  `carid` varchar(15) NOT NULL,
  PRIMARY KEY (`carid`),
  KEY `carno` (`carno`),
  KEY `officeid` (`officeid`),
  CONSTRAINT `officecars_ibfk_1` FOREIGN KEY (`carno`) REFERENCES `cars` (`carno`),
  CONSTRAINT `officecars_ibfk_2` FOREIGN KEY (`officeid`) REFERENCES `offices` (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `officecars` */

insert  into `officecars`(`officeid`,`carno`,`carid`) values ('office1','car1','carid1'),('office1','car4','carid10'),('office1','car5','carid11'),('office1','car5','carid12'),('office1','car6','carid13'),('office1','car6','carid14'),('office1','car7','carid15'),('office1','car7','carid16'),('office1','car8','carid17'),('office1','car8','carid18'),('office1','car9','carid19'),('office1','car1','carid2'),('office1','car9','carid20'),('office1','car8','carid21'),('office1','car9','carid22'),('office1','car9','carid23'),('office1','car10','carid3'),('office1','car10','carid4'),('office1','car2','carid5'),('office1','car2','carid6'),('office1','car3','carid7'),('office1','car3','carid8'),('office1','car4','carid9');

/*Table structure for table `officephones` */

DROP TABLE IF EXISTS `officephones`;

CREATE TABLE `officephones` (
  `officephoneid` int(11) NOT NULL AUTO_INCREMENT,
  `officeid` varchar(30) NOT NULL,
  `officephoneprefix` varchar(11) NOT NULL,
  `officephoneno` int(11) NOT NULL,
  PRIMARY KEY (`officephoneid`),
  KEY `officeid` (`officeid`),
  CONSTRAINT `officephones_ibfk_1` FOREIGN KEY (`officeid`) REFERENCES `offices` (`officeid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `officephones` */

insert  into `officephones`(`officephoneid`,`officeid`,`officephoneprefix`,`officephoneno`) values (1,'office1','02',65345),(4,'office1','02',63344),(5,'office1','02',61398),(6,'office2','068',238428),(7,'office2','068',234322),(9,'office2','068',284388),(10,'office3','01',521723),(11,'office3','01',529392),(12,'office3','01',528389),(13,'office4','079',893434),(14,'office4','079',834933),(15,'office4','079',832043),(16,'office5','034',123838),(17,'office5','034',138483),(18,'office5','034',193484);

/*Table structure for table `offices` */

DROP TABLE IF EXISTS `offices`;

CREATE TABLE `offices` (
  `officeid` varchar(15) NOT NULL,
  `officename` varchar(30) NOT NULL,
  `officeaddress` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `offices` */

insert  into `offices`(`officeid`,`officename`,`officeaddress`) values ('office1','Mandalay','No (21), 62 Road, 34 x 35 Road, Mahar Aung Myae Township, Mandalay'),('office2','Pyin Oo Lwin','No (66), Mandalay-Lashio Road, Near Kandawgyi Garden, Pyin Oo Lwin'),('office3','Yangon','No A-84, Shwe Bone Road x Merchant Road, Alone Township, Yangon'),('office4','Nay Pyi Taw','No (553), Main Shwe Pyi Road, Pyote Par Thiri Town'),('office5','TaungGyi','No (9A), Sakar War Road, Oakkar Township, Taung Gyi');

/*Table structure for table `paypalserver` */

DROP TABLE IF EXISTS `paypalserver`;

CREATE TABLE `paypalserver` (
  `paypalid` int(11) NOT NULL AUTO_INCREMENT,
  `paypalemail` varchar(30) NOT NULL,
  `paypalpassword` varchar(50) NOT NULL,
  `customerid` varchar(30) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT '5000',
  PRIMARY KEY (`paypalid`),
  KEY `customerid` (`customerid`),
  CONSTRAINT `paypalserver_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `customers` (`customerid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `paypalserver` */

insert  into `paypalserver`(`paypalid`,`paypalemail`,`paypalpassword`,`customerid`,`balance`) values (8,'zinminht3t@gmail.com','f4ad231214cb99a985dff0f056a36242','cus1',4200),(9,'johndoe@gmail.com','f4ad231214cb99a985dff0f056a36242','cus6',10000),(10,'khunsithar7rs@gmail.com','f4ad231214cb99a985dff0f056a36242','cus8',10000),(11,'akm97@gmail.com','f4ad231214cb99a985dff0f056a36242','cus8',10000);

/*Table structure for table `staffs` */

DROP TABLE IF EXISTS `staffs`;

CREATE TABLE `staffs` (
  `staffid` varchar(15) NOT NULL,
  `staffname` varchar(30) NOT NULL,
  `staffusername` varchar(30) NOT NULL,
  `staffemail` varchar(30) NOT NULL,
  `staffpassword` varchar(50) NOT NULL,
  `staffrole` varchar(30) NOT NULL,
  `staffphoto` varchar(30) NOT NULL,
  `officeid` varchar(30) DEFAULT NULL,
  `staffgender` varchar(30) NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`staffid`),
  KEY `officeid` (`officeid`),
  CONSTRAINT `staffs_ibfk_1` FOREIGN KEY (`officeid`) REFERENCES `offices` (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `staffs` */

insert  into `staffs`(`staffid`,`staffname`,`staffusername`,`staffemail`,`staffpassword`,`staffrole`,`staffphoto`,`officeid`,`staffgender`,`lastlogin`,`active`) values ('staff1','Zin Min Htet','admin','zinminht3t@gmail.com','0192023a7bbd73250516f069df18b500','branchmanager','staff1.png','office1','male','2017-04-24 23:16:04',1),('staff10','Thar Thar','tharthar','tharthar@gmail.com','0192023a7bbd73250516f069df18b500','staff','staff1.png','office5','male','2017-04-18 03:23:50',1),('staff12','Kyaw Kyaw Ko','staff','kyawkyawko@gmail.com','0192023a7bbd73250516f069df18b500','staff','staff1.png','office1','male','0000-00-00 00:00:00',1),('staff2','Kyaw Kyaw','kyawkyaw','kyawkyaw@gmail.com','0192023a7bbd73250516f069df18b500','staff','staff1.png','office1','male','2017-04-18 03:24:06',1),('staff3','Aung Aung','aungaung','aungaung@gmail.com','0192023a7bbd73250516f069df18b500','branchmanager','staff1.png','office2','male',NULL,1),('staff4','Zaw Zaw','zawzawzaw','zawzaw@gmail.com','0192023a7bbd73250516f069df18b500','staff','staff1.png','office2','male',NULL,1),('staff5','Kaung Kaung','kaungkaung','kaungkaung@gmail.com','0192023a7bbd73250516f069df18b500','branchmanger','staff1.png','office3','male',NULL,1),('staff6','Lin Lin','linlinlin','linlin@gmail.com','0192023a7bbd73250516f069df18b500','staff','staff1.png','office3','male',NULL,1),('staff7','Moe Moe','moemoemoe','moemoe@gmail.com','0192023a7bbd73250516f069df18b500','branchmanager','staff1.png','office4','male',NULL,1),('staff8','Yan Yan','yanyanyan','yanyan@gmail.com','0192023a7bbd73250516f069df18b500','staff','staff1.png','office4','male',NULL,1),('staff9','Pyae Pyae','pyaepyae','pyaepyae@gmail.com','0192023a7bbd73250516f069df18b500','branchmanager','staff1.png','office5','male',NULL,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
