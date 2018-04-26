drop database if exists project1;
create database project1;
use project1;
CREATE TABLE `Student` (
  `sid` INT NOT NULL auto_increment,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  `sname` VARCHAR(20) NOT NULL,
  `university` VARCHAR(100) ,
  `major` VARCHAR(20),
  `degree` VARCHAR(20),
  `GPA` DECIMAL(3,2) ,
  `keywords` VARCHAR(500),
  `resume` Varchar(20),
  `restrict` bit NOT NULL,
  PRIMARY KEY (`sid`)
  #PRIMARY KEY (`username`)
  );

CREATE TABLE `Company` (
  `cid` INT NOT NULL auto_increment,
  `cusername` VARCHAR(20) NOT NULL,
  `cpassword` VARCHAR(20) NOT NULL,
  `cname` VARCHAR(20) NOT NULL,
  `ccity` VARCHAR(20) NOT NULL,
  `cstate` VARCHAR(20) NOT NULL,
  `ccountry` VARCHAR(20) NOT NULL,
  `industry` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`cid`)
  #PRIMARY KEY (`cusername`)
  );

CREATE TABLE `Job` (
  `jid` INT NOT NULL auto_increment,
  `title` VARCHAR(100) NOT NULL,
  `cid` INT NOT NULL,
  `jcity` VARCHAR(20) NOT NULL,
  `jstate` VARCHAR(20) NOT NULL,
  `jcountry` VARCHAR(20) NOT NULL,
  `salary` MEDIUMINT NOT NULL,
  `degree` VARCHAR(20) NOT NULL,
  `major` VARCHAR(20) NOT NULL,
  `jdesciption` TEXT NOT NULL,
  PRIMARY KEY (`jid`),
  FOREIGN KEY (`cid`) REFERENCES `Company` (`cid`)
  );

#NotificationToStudent(nid, ntime, nstatus, notificationtype)
CREATE TABLE `NotificationToStudent` (
  `nid` INT NOT NULL auto_increment,
  `tosid` INT NOT NULL,
  `nstatus` VARCHAR(20) NOT NULL,
  `notificationtype` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`nid`),
  FOREIGN KEY (`tosid`) REFERENCES `Student` (`sid`)
  );

#NotificationToCompany(nid, tocid, nstatus, notificationtype)
CREATE TABLE `NotificationToCompany` (
  `nid` INT NOT NULL auto_increment,
  `tocid` INT NOT NULL,
  `nstatus` VARCHAR(20) NOT NULL,
  `notificationtype` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`nid`),
  FOREIGN KEY (`tocid`) REFERENCES `Company` (`cid`)
  );


#Application is from student to company
CREATE TABLE `Application` (
  `nid` INT NOT NULL,
  `atime` DATETIME NOT NULL,
  `fromsid` INT NOT NULL,
  `tocid` INT NOT NULL,
  `jid` INT NOT NULL,
  PRIMARY KEY (`nid`),
  FOREIGN KEY (`fromsid`) REFERENCES `Student` (`sid`),
  FOREIGN KEY (`tocid`) REFERENCES `Company` (`cid`),
  FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`)
  );

#Announcement is from company to student
CREATE TABLE `Announcement` (
  `nid` INT NOT NULL,
  `atime` DATETIME NOT NULL,
  `fromcid` INT NOT NULL,
  `jid` INT NOT NULL,
  `tosid` INT NOT NULL,
  PRIMARY KEY (`nid`),
  FOREIGN KEY (`nid`) REFERENCES `NotificationToStudent` (`nid`),
  FOREIGN KEY (`fromcid`) REFERENCES `Company` (`cid`),
  FOREIGN KEY (`jid`) REFERENCES `Job` (`jid`),
  FOREIGN KEY (`tosid`) REFERENCES `Student` (`sid`)
  );

#FriendReq is from Student to student
CREATE TABLE `FriendReq` (
  `nid` INT NOT NULL,
  `ftime` DATETIME NOT NULL,
  `fromsid` INT NOT NULL,
  `tosid` INT NOT NULL,
  `fqstatus` Varchar(10) NOT NULL,
  PRIMARY KEY (`nid`),
  FOREIGN KEY (`nid`) REFERENCES `NotificationToStudent` (`nid`),
  FOREIGN KEY (`fromsid`) REFERENCES `Student` (`sid`),
  FOREIGN KEY (`tosid`) REFERENCES `Student` (`sid`)
  );

#Forward is from student to student
CREATE TABLE `Forward` (
  `fid` INT NOT NULL,
  `ftime` DATETIME NOT NULL,
  `fromsid` INT NOT NULL,
  `tosid` INT NOT NULL,
  `nid` INT NOT NULL,
  PRIMARY KEY (`fid`),
  FOREIGN KEY (`fid`) REFERENCES `NotificationToStudent` (`nid`),
  FOREIGN KEY (`fromsid`) REFERENCES `Student` (`sid`),
  FOREIGN KEY (`tosid`) REFERENCES `Student` (`sid`),
  FOREIGN KEY (`nid`) REFERENCES `Announcement` (`nid`)
  );

#Tips is from student to student
CREATE TABLE `Tips` (
  `nid` INT NOT NULL,
  `ttime` DATETIME NOT NULL,
  `fromsid` INT NOT NULL,
  `tosid` INT NOT NULL,
  `content` TEXT NOT NULL,
  PRIMARY KEY (`nid`),
  FOREIGN KEY (`nid`) REFERENCES `NotificationToStudent` (`nid`),
  FOREIGN KEY (`fromsid`) REFERENCES `Student` (`sid`),
  FOREIGN KEY (`tosid`) REFERENCES `Student` (`sid`)
  );

CREATE TABLE `Friend` (
  `sid1` INT NOT NULL,
  `sid2` INT NOT NULL,
  PRIMARY KEY (`sid1`, `sid2`),
  FOREIGN KEY (`sid1`) REFERENCES `Student` (`sid`),
  FOREIGN KEY (`sid2`) REFERENCES `Student` (`sid`)
  );

CREATE TABLE `Follow` (
  `sid` INT NOT NULL,
  `cid` INT NOT NULL,
  PRIMARY KEY (`sid`, `cid`),
  FOREIGN KEY (`sid`) REFERENCES `Student` (`sid`),
  FOREIGN KEY (`cid`) REFERENCES `Company` (`cid`)
  );