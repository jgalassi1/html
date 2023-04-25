create table friends
(
    friendship_id number(5),
    username_1 varchar(255),
    username_2 varchar(255)
)
/
alter table friends add constraint friendship_id_pk primary key (friendship_id);
alter table friends add foreign key (username_1) references users (username);
alter table friends add foreign key (username_2) references users (username)
/