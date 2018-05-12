drop database if exists dbproject_new;
create database dbproject_new;
use dbproject_new;
CREATE TABLE `Company` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cusername` varchar(20) NOT NULL,
  `cpassword` varchar(50) NOT NULL,
  `cname` varchar(20) NOT NULL,
  `ccity` varchar(20) NOT NULL,
  `cstate` varchar(20) NOT NULL,
  `ccountry` varchar(20) NOT NULL,
  `industry` varchar(100) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

CREATE TABLE `Student` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `sname` varchar(20) NOT NULL,
  `university` varchar(100) DEFAULT NULL,
  `major` varchar(20) DEFAULT NULL,
  `degree` varchar(20) DEFAULT NULL,
  `GPA` decimal(3,2) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `resume` varchar(5000) DEFAULT NULL,
  `restrict` varchar(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

CREATE TABLE `Job` (
  `jid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `cid` int(11) NOT NULL,
  `jcity` varchar(20) NOT NULL,
  `jstate` varchar(20) NOT NULL,
  `jcountry` varchar(20) NOT NULL,
  `salary` mediumint(9) NOT NULL,
  `degree` varchar(20) NOT NULL,
  `major` varchar(20) NOT NULL,
  `jdescription` text NOT NULL,
  `expirationDate` datetime NOT NULL,
  PRIMARY KEY (`jid`),
  KEY `cid` (`cid`),
  CONSTRAINT `Job_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `Company` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ALTER TABLE Job
-- ADD COLUMN jtime datetime NOT NULL;


CREATE TABLE `NotificationToStudent` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `fromsid` int(11) DEFAULT NULL,
  `fromcid` int(11) DEFAULT NULL,
  `tosid` int(11) NOT NULL,
  `nstatus` varchar(20) NOT NULL,
  `ntime` datetime NOT NULL,
  `notificationtype` varchar(20) NOT NULL,
  PRIMARY KEY (`nid`),
  KEY `tosid` (`tosid`),
  KEY `fromsid` (`fromsid`),
  KEY `fromcid` (`fromcid`),
  CONSTRAINT `NotificationToStudent_ibfk_1` FOREIGN KEY (`tosid`) REFERENCES `Student` (`sid`),
  CONSTRAINT `NotificationToStudent_ibfk_2` FOREIGN KEY (`fromsid`) REFERENCES `Student` (`sid`),
  CONSTRAINT `NotificationToStudent_ibfk_3` FOREIGN KEY (`fromcid`) REFERENCES `Company` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=latin1;

CREATE TABLE `Application` (
  `atime` datetime NOT NULL,
  `fromsid` int(11) NOT NULL,
  `tocid` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `astatus` varchar(10) NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`atime`,`fromsid`,`jid`),
  KEY `fromsid` (`fromsid`),
  KEY `tocid` (`tocid`),
  KEY `jid` (`jid`),
  CONSTRAINT `Application_ibfk_1` FOREIGN KEY (`fromsid`) REFERENCES `Student` (`sid`),
  CONSTRAINT `Application_ibfk_2` FOREIGN KEY (`tocid`) REFERENCES `Company` (`cid`),
  CONSTRAINT `Application_ibfk_3` FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `Push` (
  `nid` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `ptime` datetime NOT NULL,
  PRIMARY KEY (`nid`),
  KEY `jid` (`jid`),
  CONSTRAINT `Push_ibfk_1` FOREIGN KEY (`nid`) REFERENCES `NotificationToStudent` (`nid`),
  CONSTRAINT `Push_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- CREATE TABLE `Broadcast` (
--   `cid` int(11) NOT NULL,
--   `jid` int(11) NOT NULL,
--   `btime` datetime NOT NULL,
--   `minGPA` decimal(3,2) DEFAULT NULL,
--   `university` varchar(100) DEFAULT NULL,
--   `major` varchar(20) DEFAULT NULL,
--   `mindegree` varchar(20) DEFAULT NULL,
--   `keywords` varchar(500) DEFAULT NULL,
--   PRIMARY KEY (`cid`,`jid`,`btime`),
--   KEY `jid` (`jid`),
--   CONSTRAINT `Broadcast_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `Company` (`cid`),
--   CONSTRAINT `Broadcast_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Forward` (
  `nid` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `ftime` datetime NOT NULL,
  PRIMARY KEY (`nid`),
  KEY `jid` (`jid`),
  CONSTRAINT `Forward_ibfk_1` FOREIGN KEY (`nid`) REFERENCES `NotificationToStudent` (`nid`),
  CONSTRAINT `Forward_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Tips` (
  `nid` int(11) NOT NULL,
  `content` text NOT NULL,
  `ttime` datetime NOT NULL,
  PRIMARY KEY (`nid`),
  CONSTRAINT `Tips_ibfk_1` FOREIGN KEY (`nid`) REFERENCES `NotificationToStudent` (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `Friend` (
  `sid1` int(11) NOT NULL,
  `sid2` int(11) NOT NULL,
  PRIMARY KEY (`sid1`,`sid2`),
  KEY `sid2` (`sid2`),
  CONSTRAINT `Friend_ibfk_1` FOREIGN KEY (`sid1`) REFERENCES `Student` (`sid`),
  CONSTRAINT `Friend_ibfk_2` FOREIGN KEY (`sid2`) REFERENCES `Student` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Follow` (
  `sid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`sid`,`cid`),
  KEY `cid` (`cid`),
  CONSTRAINT `Follow_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
  CONSTRAINT `Follow_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `Company` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
