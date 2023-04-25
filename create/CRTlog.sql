create table log
(
    entry_id number(5),
    owner varchar(255),
    log_date date
)
/
alter table log add constraint entry_id_pk primary key (entry_id);
alter table log add foreign key (owner) references users (username)
/