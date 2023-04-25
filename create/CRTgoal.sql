create table goal
(
    goal_id number(5),
    owner varchar(255),
    start_date date,
    target_date date,
    description varchar(255),
    success number(1)
)
/
alter table goal add constraint goal_id_pk primary key (goal_id);
alter table goal add foreign key (owner) references users (username)
/