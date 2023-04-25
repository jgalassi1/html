create table exercise
(
    exercise_id number(5),
    name varchar(255),
    repititions number(5),
    rest_time number(5),
    muscle_group varchar(255),
    location_id number(5)
)
/
alter table exercise add constraint exercise_id_pk primary key (exercise_id);
alter table exercise add foreign key (location_id) references location(location_id)
/