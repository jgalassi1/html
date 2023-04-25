create table meal 
(
    meal_id number(5),
    name varchar(255),
    calories number(5),
    type varchar(255)
)
/
alter table meal add constraint meal_id_pk primary key (meal_id)
/