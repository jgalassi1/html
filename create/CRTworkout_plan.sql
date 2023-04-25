create table workout_plan
(
    wp_id number(5),
    owner varchar(255),
    split_name varchar(255)
)
/
alter table workout_plan add constraint wp_id_pk primary key (wp_id);
alter table workout_plan add foreign key (owner) references users (username)
/