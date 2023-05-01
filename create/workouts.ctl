load data infile 'workouts.csv'
insert into table workout
fields terminated by ';'
(workout_id, name, mg1, mg2, mg3, mg4, location_id, description)