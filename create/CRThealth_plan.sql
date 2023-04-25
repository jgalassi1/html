create table health_plan
(
    hp_id number(5),
    name varchar(255),
    owner varchar(255),
    description varchar(255)
)
/
alter table health_plan add constraint hp_id_pk primary key (hp_id);
alter table health_plan add foreign key (owner) references users (username)
/