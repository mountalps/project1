#student(sid, username, password, sname, university, degree, major, GPA, keywords, resume, restrict)
#name, a login name, and a password.

INSERT INTO `Student`
VALUES
(22, 'js123', 'passwordjs01', 'John Smith',NULL,NULL, NULL, NULL, NULL, NULL, 1);

insert into Student
values 
(1, 'fionnidis0', 'Qfm86w7Y4R', 'Freeman', 'New York University', 'Computer Science', 'Master', 3.24, 'Stringtough', null, 0),
(2, 'lsnaith1', 'N1BkX2DgBaU', 'Lorry', 'New York University', 'Computer Science', 'Master', 3.84, 'Temp', null, 1),
(3, 'aloalday2', 'Y7yAPpHwt', 'Afton', 'New York University', 'Computer Science', 'Master', 3.55, 'Cookley', null, 0),
(4, 'zgourlay3', 't7UMYzm', 'Zared', 'University of New Brunswick, Saint John', 'Computer Science', 'Master', 3.18, 'Andalax', null, 0),
(5, 'eescale4', 'wxWlioIs', 'Etheline', 'Kyunghee University', 'Computer Science', 'Master', 3.46, 'Alphazap', null, 0),
(6, 'tclausewitz5', 'qR9iRIk1N3', 'Tyrus', 'Gyeongsang National University', 'Computer Science', 'Master', 3.75, 'Cardguard', null, 1),
(7, 'wdursley6', 'Gs9lNupD', 'Wenda', 'Georg-August Universität Göttingen', 'Physics', 'Doctor', 3.18, 'Temp', null, 0),
(8, 'nfelgat7', 'PyW3cJHmUD', 'Neilla', 'United States International University', 'Physics', 'Doctor', 3.16, 'Domainer', null, 1),
(9, 'sbeckworth8', '1qIYpfUa15', 'Samson', 'Universidade Católica de Santos', 'Physics', 'Doctor', 3.18, 'Tampflex', null, 1),
(10, 'ymedford9', 'eZ9OWBQZT', 'Yulma', 'Fine Arts Academy in Gdansk', 'Physics', 'Doctor', 3.91, 'Gembucket', null, 0),
(11, 'mboatswaina', 'EKeeAp2OYak', 'Myrtle', 'Universidad del Norte', 'Physics', 'Doctor', 3.22, 'Biodex', null, 0),
(12, 'lcroftsb', 'cmmRkpCR4XT9', 'Lyda', 'Ching Kuo Institue of Management & Health', 'Physics', 'Doctor', 3.76, 'Lotstring', null, 0),
(13, 'bbrumc', 'rOOMEy', 'Barbabas', 'Université Julius Nyerere Kankan', 'Physics', 'Doctor', 3.42, 'Duobam', null, 0),
(14, 'myersond', 'Npc7bymffmp', 'Monte', 'Islamic Azad University, Central Tehran Branch', 'Physics', 'Doctor', 3.44, 'Duobam', null, 1),
(15, 'aemanuelove', 'xIG6mwi', 'Artur', 'Turku School of Economics and Business Administration', 'Physics', 'Doctor', 3.83, 'Alpha', null, 1),
(16, 'idespenserf', 'f2SnlrdrG', 'Inger', 'Tallinn University of Technology', 'Physics', 'Doctor', 3.49, 'Bitchip', null, 1),
(17, 'vbenoitong', 'reolUVkm', 'Vasily', 'Brigham Young University', 'Physics', 'Doctor', 3.18, 'Stim', null, 1),
(18, 'cbuggeh', 'KFKmHjVepj', 'Coleen', 'University of North West', 'Physics', 'Doctor', 3.87, 'Mat Lam Tam', null, 0),
(19, 'jmasureli', 'jDhPnlw', 'Jeromy', 'Stevens Institute of Technology', 'Physics', 'Doctor', 3.7, 'Tin', null, 0),
(20, 'abiertonj', '038KU588Amj', 'Ariana', 'Birsk State Pedagogical Institute', 'Physics', 'Doctor', 3.67, 'Stim', null, 1);

#(cid, cname, ccity, cstate, ccountry, industry)
insert into Company values
(1, 'Microsoft', 'New York City', 'New York', 'United States', 'Telecommunications Equipment'),
(2, 'Youspan', 'Denver', 'Colorado', 'United States', 'Marine Transportation'),
(3, 'Twiyo', 'Los Angeles', 'California', 'United States', 'Life Insurance'),
(4, 'Brightdog', 'Austin', 'Texas', 'United States', 'Marine Transportation'),
(5, 'Jayo', 'Richmond', 'Virginia', 'United States', 'Marine Transportation'),
(6, 'Ailane', 'Mobile', 'Alabama', 'United States', 'Marine Transportation'),
(7, 'Shufflebeat', 'Syracuse', 'New York', 'United States', 'Auto Parts:O.E.M.'),
(8, 'Kaymbo', 'Charlotte', 'North Carolina', 'United States', 'Marine Transportation'),
(9, 'Oba', 'Monticello', 'Minnesota', 'United States', 'Oil & Gas Production'),
(10, 'Yabox', 'Mesa', 'Arizona', 'United States', 'Marine Transportation');


#Job (jid, title, cid, jcity, jstate, jcountry, salary, degree, major, jdesciption)
insert into Job
values 
(1, 'Senior Quality Engineer', 1, 'New York City', 'New York', 'United States', 88011, 'Master', 'Computer Science', 'XXX'),
(2, 'Electrical Engineer', 2, 'Philadelphia', 'Pennsylvania', 'United States', 83838, 'Master', 'Computer Science', 'XXX'),
(3, 'Statistician II', 3, 'Miami', 'Florida', 'United States', 81015, 'Doctor', 'Computer Science', 'XXX'),
(4, 'Sales Associate', 4, 'Seattle', 'Washington', 'United States', 119906, 'Master', 'Computer Science', 'XXX'),
(5, 'Programmer Analyst I', 5, 'Los Angeles', 'California', 'United States', 93693, 'Master', 'Computer Science', 'XXX'),
(6, 'Assistant Media Planner', 6, 'Worcester', 'Massachusetts', 'United States', 109752, 'Acura', 'Pontiac', 'XXX'),
(7, 'VP Quality Control', 7, 'Amarillo', 'Texas', 'United States', 101463, 'Oldsmobile', 'Toyota', 'XXX'),
(8, 'Tax Accountant', 8, 'Mesa', 'Arizona', 'United States', 100348, 'Ford', 'Chevrolet', 'XXX'),
(9, 'Statistician I', 9, 'New York City', 'New York', 'United States', 107572, 'Ford', 'Buick', 'XXX'),
(10, 'Pharmacist', 10, 'Milwaukee', 'Wisconsin', 'United States', 89249, 'Mazda', 'Ford', 'XXX'),
(11, 'Statistician IV', 10, 'Harrisburg', 'Pennsylvania', 'United States', 82160, 'Nissan', 'Mitsubishi', 'XXX'),
(12, 'Recruiter', 9, 'Detroit', 'Michigan', 'United States', 98879, 'Ford', 'Toyota', 'XXX'),
(13, 'Pharmacist', 8, 'Naperville', 'Illinois', 'United States', 116694, 'Chevrolet', 'Dodge', 'XXX'),
(14, 'Operator', 7, 'Monticello', 'Minnesota', 'United States', 110602, 'Mercedes-Benz', 'Lexus', 'XXX'),
(15, 'Safety Technician IV', 6, 'Evansville', 'Indiana', 'United States', 118503, 'GMC', 'Buick', 'XXX'),
(16, 'Paralegal', 5, 'Fort Worth', 'Texas', 'United States', 116372, 'Toyota', 'Hyundai', 'XXX'),
(17, 'Research Assistant IV', 4, 'Austin', 'Texas', 'United States', 86194, 'Ferrari', 'Lexus', 'XXX'),
(18, 'Health Coach IV', 3, 'Denver', 'Colorado', 'United States', 114222, 'Toyota', 'Toyota', 'XXX'),
(19, 'Staff Scientist', 2, 'Santa Clara', 'California', 'United States', 119701, 'Rolls-Royce', 'Subaru', 'XXX'),
(20, 'Physical Therapy Assistant', 1, 'Phoenix', 'Arizona', 'United States', 97864, 'Dodge', 'Mercedes-Benz', 'XXX');


#(nid, tocid, nstatus, notificationtype)
insert into NotificationToCompany
values 
(1, 1, 'unread', 'Application'),
(2, 2, 'unread', 'Application'),
(3, 3, 'unread', 'Application'),
(4, 4, 'unread', 'Application'),
(5, 5, 'unread', 'Application'),
(6, 6, 'unread', 'Application'),
(7, 7, 'unread', 'Application'),
(8, 8, 'unread', 'Application'),
(9, 9, 'unread', 'Application'),
(10, 10, 'unread', 'Application');

#Job (nid, atime, fromsid, tocid, jid)
insert into Application
values (1, '2017-06-08 11:11:11', 4, 1, 1),
(2, '2017-05-06 11:11:11', 4, 2, 2),
(3, '2017-11-28 11:11:11', 4, 3, 3),
(4, '2017-07-05 11:11:11', 8, 4, 4),
(5, '2017-10-26 11:11:11', 6, 5, 5),
(6, '2017-06-14 11:11:11', 3, 6, 6),
(7, '2017-12-17 11:11:11', 7, 7, 7),
(8, '2017-05-16 11:11:11', 3, 8, 8),
(9, '2017-07-17 11:11:11', 5, 9, 9),
(10, '2018-03-11 11:11:11', 9, 10, 10);


#(nid, tosid, nstatus, notificationtype)
insert into NotificationToStudent
values 
(1, 10, 'unread', 'Announcement'),
(2, 6, 'unread', 'Announcement'),
(3, 4, 'unread', 'Announcement'),
(4, 10, 'unread', 'FriendReq'),
(5, 5, 'unread', 'FriendReq'),
(6, 5, 'unread', 'FriendReq'),
(7, 7, 'unread', 'Forward'),
(8, 8, 'unread', 'Forward'),
(9, 16, 'unread', 'Tips'),
(10, 19, 'unread', 'Tips');

#Announcement (nid, atime, fromcid, jid, tosid)
insert into Announcement
values
(1, '2018-04-19 10:00:12', 1, 1, 9),
(2, '2018-04-20 11:12:12', 2, 2, 12),
(3, '2017-11-10 12:13:21', 4, 4, 11);

#(nid, ftime, fromsid, tosid, fqstatus)
insert into FriendReq
values 
(4, '2018-01-30 01:00:00', 9, 10, 'pending'),
(5, '2018-04-16 02:00:00', 7, 5, 'pending'),
(6, '2018-03-23 03:00:00', 8, 5, 'pending');

#Forward(fid, ftime, fromsid, tosid, nid)
insert into Forward
values
(7,'2018-04-21 10:00:12', 1, 7, 1),
(8,'2018-04-22 10:00:12', 2, 8, 3);


#Tips(nid, ttime, fromsid, tosid, content)
insert into Tips
values
(9,'2018-04-21 13:00:12',3,16,'XXX' ),
(10, '2018-04-20 15:00:12', 4,19,'XXX');

insert into Friend
values 
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10);

#Follow (sid, cid)
insert into Follow 
values
(1, 1),
(2, 1),
(1, 3),
(17, 4),
(1, 5),
(20, 6),
(18, 7),
(14, 8),
(6, 9),
(10, 10);
