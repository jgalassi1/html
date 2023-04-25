create table users
(
    username varchar(255),
    password varchar(255),
    fname varchar(255),
    lname varchar(255)
)
/
alter table users add constraint username_pk primary key (username)
/