create table hp_mp
(
    hpmp_id number(5),
    hp_id number(5),
    mp_id number(5)
)
/
alter table hp_mp add constraint hpmp_id_pk primary key (hpmp_id);
alter table hp_mp add foreign key (hp_id) references health_plan (hp_id);
alter table hp_mp add foreign key (mp_id) references meal_plan (mp_id)
/