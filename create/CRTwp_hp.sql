create table wp_hp 
(
    wpmp_id number(5),
    wp_id number(5),
    hp_id number(5)
)
/
alter table wp_hp add constraint wpmp_id_pk primary key (wpmp_id);
alter table wp_hp add foreign key (wp_id) references workout_plan (wp_id);
alter table wp_hp add foreign key (hp_id) references health_plan (hp_id)
/