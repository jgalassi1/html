CREATE OR REPLACE PACKAGE workout_plan_pkg
IS
    TYPE workout_id_nt IS TABLE OF workout_id_obj;

    FUNCTION create_workout_plan_tbl(num_days IN NUMBER) RETURN workout_id_nt;

    FUNCTION get_workout_plan(num_days IN NUMBER) RETURN workout_id_nt PIPELINED;

    PROCEDURE generate_workout_plan(num_days IN NUMBER, workout_ids OUT workout_id_nt);
END workout_plan_pkg;
/