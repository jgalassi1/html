prompt *** Dropping existing tables ***
drop table friends;
drop table ex_wp;
drop table user_hp;
drop table wp_hp;
drop table hp_mp;
drop table meal_mp;
drop table exercise;
drop table log;
drop table goal;
drop table health_plan;
drop table meal;
drop table workout_plan;
drop table meal_plan;
drop table location;
drop table users;

prompt *** Creating tables ***
@create/CRTusers
@create/CRTlocation
@create/CRTmeal_plan
@create/CRTworkout_plan
@create/CRTmeal 
@create/CRThealth_plan
@create/CRTgoal
@create/CRTlog
@create/CRTexercise
@create/CRTmeal_mp
@create/CRThp_mp
@create/CRTwp_hp
@create/CRTuser_hp
@create/CRTex_wp
@create/CRTfriends
exit;
