create table location 
(
    location_id number(5),
    name varchar(255),
    indoor number(1),
    gtype varchar(255)
)
/
alter table location add constraint location_id_pk primary key (location_id)
/