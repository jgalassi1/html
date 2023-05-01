sqlplus -S timmy/timmy @CREATE
sqlldr timmy/timmy control=meals.ctl
sqlldr timmy/timmy control=workouts.ctl
