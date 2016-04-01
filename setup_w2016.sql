/*
 *  File name:  setup.sql
 *  Function:   to create the initial database schema for the CMPUT 391 project: An Online Image Sharing System
 *              Winter, 2016
 *  Author:     Prof. Li-Yan Yuan
 */
DROP TABLE images;
DROP TABLE group_lists;
DROP TABLE groups;
DROP TABLE persons;
DROP TABLE users;

DROP SEQUENCE seq_group_id;

drop index image_subject_idx;
drop index image_place_idx;
drop index image_desc_idx;


CREATE TABLE users (
   user_name varchar(24),
   password  varchar(24),
   date_registered date,
   primary key(user_name)
);

CREATE TABLE persons (
   user_name  varchar(24),
   first_name varchar(24),
   last_name  varchar(24),
   address    varchar(128),
   email      varchar(128),
   phone      char(10),
   PRIMARY KEY(user_name),
   UNIQUE (email),
   FOREIGN KEY (user_name) REFERENCES users
);


CREATE TABLE groups (
   group_id   int,
   user_name  varchar(24),
   group_name varchar(24),
   date_created date,
   PRIMARY KEY (group_id),
   UNIQUE (user_name, group_name),
   FOREIGN KEY(user_name) REFERENCES users
);

INSERT INTO groups values(1,null,'public', sysdate);
INSERT INTO groups values(2,null,'private',sysdate);

CREATE TABLE group_lists (
   group_id    int,
   friend_id   varchar(24),
   date_added  date,
   notice      varchar(1024),
   PRIMARY KEY(group_id, friend_id),
   FOREIGN KEY(group_id) REFERENCES groups,
   FOREIGN KEY(friend_id) REFERENCES users
);

CREATE TABLE images (
   photo_id    int,
   owner_name  varchar(24),
   permitted   int,
   subject     varchar(128),
   place       varchar(128),
   timing      date,
   description varchar(2048),
   thumbnail   blob,
   photo       blob,
   PRIMARY KEY(photo_id),
   FOREIGN KEY(owner_name) REFERENCES users,
   FOREIGN KEY(permitted) REFERENCES groups
);

CREATE SEQUENCE seq_group_id
MINVALUE 3
START WITH 3
INCREMENT BY 1
CACHE 15;

CREATE OR REPLACE PROCEDURE CREATEGROUPPROC
(username IN varchar2, groupname IN varchar2 )
IS newId INT;
BEGIN
   newId := seq_group_id.nextVal;
   INSERT INTO groups values(newId,username,groupname,sysdate);
   INSERT INTO group_lists VALUES(newId,username,sysdate, null);
END;
/

/*
Add Group Member
username in groups
membername in users
groupname in groups
*/
CREATE OR REPLACE PROCEDURE ADDGROUPMEMBERPROC 
(username IN varchar2, membername IN varchar2, groupname IN varchar2 )
IS groupId INT;
BEGIN
   select group_id into groupId 
   from groups g 
   where g.group_name=groupname 
     and g.user_name= username;
   INSERT INTO group_lists VALUES(groupId,membername,sysdate, null);
END;
/

--Delete Group Member Procedure
CREATE OR REPLACE PROCEDURE DELGROUPMEMBERPROC 
(username IN varchar2, membername IN varchar2, groupname IN varchar2 )
IS groupId INT;
BEGIN
   select group_id into groupId 
   from groups g 
   where g.group_name=groupname 
     and g.user_name= username;
   DELETE FROM group_lists gl 
   WHERE gl.group_id = groupId
     AND gl.friend_id = membername;
END;
/

CREATE INDEX image_subject_idx ON images (subject) indextype is ctxsys.context parameters ('sync (on commit)');
CREATE INDEX image_place_idx ON images (place) indextype is ctxsys.context parameters ('sync (on commit)');
CREATE INDEX image_desc_idx ON images (description) indextype is ctxsys.context parameters ('sync (on commit)');


//add table for photo visit
CREATE TABLE PHOTO_VISIT
(
PHOTO_ID number(38,0),
OWNER_NAME VARCHAR2(24 BYTE)
);
