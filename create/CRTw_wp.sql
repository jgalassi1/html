create table w_wpNEW
(
    wwp_id number(5),
    workout_id number(5),
    wp_id number(5),
    w_day varchar(255)
)
/
alter table w_wp add constraint wwp_id_pk primary key (wwp_id);
alter table w_wp add foreign key (workout_id) references workout(workout_id);
alter table w_wp add foreign key (wp_id) references workout_plan(wp_id)
/