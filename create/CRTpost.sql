create table post
(
    post_id number(5),
    owner varchar(255),
    likes number(5),
    content varchar(255)
)
/
alter table post add constraint post_id_pk primary key (post_id);
alter table post add foreign key (owner) references users (username)
/