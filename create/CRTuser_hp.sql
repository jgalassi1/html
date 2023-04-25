create table user_hp 
(
    uhp_id number(5),
    username varchar(255),
    hp_id number(5)
)
/
alter table user_hp add constraint uhp_id_pk primary key (uhp_id);
alter table user_hp add foreign key (username) references users (username);
alter table user_hp add foreign key (hp_id) references health_plan (hp_id)
/