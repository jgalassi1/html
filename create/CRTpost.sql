create table posts
(
    post_id number(5),
    owner varchar(255),
    likes number(5),
    content varchar(255)
)
/
alter table posts add constraint posts_id_pk primary key (post_id);
alter table posts add foreign key (owner) references users (username)
/