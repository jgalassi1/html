create table meal_plan
(
    mp_id number(5),
    name varchar(255),
    owner varchar(255),
    type varchar(255)
)
/
alter table meal_plan add constraint mp_id_pk primary key (mp_id);
alter table meal_plan add foreign key (owner) references users (username)
/