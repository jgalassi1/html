create table meal_mp 
(
    mmp_id number(5),
    meal_id number(5),
    mp_id number(5)
)
/
alter table meal_mp add constraint mmp_id_pk primary key (mmp_id);
alter table meal_mp add foreign key (meal_id) references meal (meal_id);
alter table meal_mp add foreign key (mp_id) references meal_plan (mp_id)
/