CREATE OR REPLACE PACKAGE BODY workout_plan_pkg
IS
    FUNCTION create_workout_plan_tbl(num_days IN NUMBER) RETURN workout_id_nt
    IS
        v_workout_ids workout_id_nt := workout_id_nt();
    BEGIN
        generate_workout_plan(num_days, v_workout_ids);
        RETURN v_workout_ids;
    END create_workout_plan_tbl;

    FUNCTION get_workout_plan(num_days IN NUMBER) RETURN workout_id_nt PIPELINED
    IS
        v_workout_ids workout_id_nt;
    BEGIN
        v_workout_ids := create_workout_plan_tbl(num_days);
        FOR i IN 1..v_workout_ids.COUNT LOOP
            PIPE ROW (v_workout_ids(i));
        END LOOP;
        RETURN;
    END get_workout_plan;

    PROCEDURE generate_workout_plan(num_days IN NUMBER, workout_ids OUT workout_id_nt) IS
        muscle_groups SYS.ODCIVARCHAR2LIST := SYS.ODCIVARCHAR2LIST('Upper back', 'Shoulders', 'Lats', 'Chest', 'Glutes', 'Hamstrings', 'Calves', 'Biceps', 'Triceps', 'Abs', 'Quads');
        workout_cur SYS_REFCURSOR;
        workout_rec Workout%ROWTYPE;
        valid_workouts workout_id_nt := workout_id_nt();
        current_muscle_group_count NUMBER;
        workout_count NUMBER;
        v_sql_statement VARCHAR2(4000);
        v_workout_list VARCHAR2(4000); 
    BEGIN
        FOR i IN 1 .. num_days LOOP
            v_workout_list := '';
            FOR j IN 1..valid_workouts.COUNT LOOP
                IF j > 1 THEN
                    v_workout_list := v_workout_list || ',';
                END IF;
                v_workout_list := v_workout_list || TO_CHAR(valid_workouts(j).workout_id);
            END LOOP;

            v_sql_statement := 'SELECT * FROM Workout WHERE 1=1 ' || (CASE WHEN v_workout_list <> '' THEN 'AND Workout_ID NOT IN (' || v_workout_list || ')' ELSE '' END) || ' ORDER BY DBMS_RANDOM.VALUE';

            OPEN workout_cur FOR v_sql_statement;

            WHILE TRUE LOOP
                FETCH workout_cur INTO workout_rec;
                EXIT WHEN workout_cur%NOTFOUND;

                current_muscle_group_count := 0;

                FOR j IN 1 .. muscle_groups.COUNT LOOP
                    IF (workout_rec.MG1 = muscle_groups(j) OR workout_rec.MG2 = muscle_groups(j) OR workout_rec.MG3 = muscle_groups(j) OR workout_rec.MG4 = muscle_groups(j)) THEN
                        current_muscle_group_count := current_muscle_group_count + 1;
                    END IF;
                END LOOP;

                workout_count := 0;
                FOR j IN 1..valid_workouts.COUNT LOOP
                    IF valid_workouts(j).workout_id = workout_rec.Workout_ID THEN
                        workout_count := workout_count + 1;
                    END IF;
                END LOOP;

                IF current_muscle_group_count >= 2 AND workout_count < 3 THEN
                    valid_workouts.EXTEND;
                    valid_workouts(valid_workouts.COUNT) := workout_id_obj(workout_rec.Workout_ID);
                    CLOSE workout_cur;
                    EXIT;
                END IF;
            END LOOP;
        END LOOP;

        workout_ids := valid_workouts;
    END generate_workout_plan;
END workout_plan_pkg;
/