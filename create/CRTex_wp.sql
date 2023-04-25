create table ex_wp
(
    exwp_id number(5),
    exercise_id number(5),
    wp_id number(5)
)
/
alter table ex_wp add constraint exwp_id_pk primary key (exwp_id);
alter table ex_wp add foreign key (exercise_id) references exercise(exercise_id);
alter table ex_wp add foreign key (wp_id) references workout_plan(wp_id)
/