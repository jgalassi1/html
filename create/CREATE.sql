prompt *** Dropping existing tables ***
drop table friends;
drop table w_wp;
drop table user_hp;
drop table wp_hp;
drop table hp_mp;
drop table meal_mp;
drop table workout;
drop table log;
drop table goal;
drop table health_plan;
drop table meal;
drop table workout_plan;
drop table meal_plan;
drop table location;
drop table users;

prompt *** Creating tables ***
@CRTusers
@CRTlocation
@CRTmeal_plan
@CRTworkout_plan
@CRTmeal 
@CRThealth_plan
@CRTgoal
@CRTlog
@CRTworkout
@CRTmeal_mp
@CRThp_mp
@CRTwp_hp
@CRTuser_hp
@CRTw_wp
@CRTfriends
exit;
