create table workout
(
    workout_id number(5),
    name varchar(255),
    mg1 varchar(255),
    mg2 varchar(255),
    mg3 varchar(255),
    mg4 varchar(255),
    location_id number(5),
    description varchar(255)
)
/
alter table workout add constraint workout_id_pk primary key (workout_id);
alter table workout add foreign key (location_id) references location(location_id)
/