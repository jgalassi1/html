load data infile 'meals.csv'
insert into table meal
fields terminated by ';'
(meal_id, name, calories, protein, type, description)