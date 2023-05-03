SET SERVEROUTPUT ON;

DECLARE
    TYPE workout_plan_result IS TABLE OF NUMBER INDEX BY PLS_INTEGER;
    v_workout_ids workout_plan_result;
    v_index PLS_INTEGER;
    v_workout_list VARCHAR2(4000);

    PROCEDURE generate_workout_plan(num_days IN NUMBER, workout_ids OUT workout_plan_result) IS
        muscle_groups SYS.ODCIVARCHAR2LIST := SYS.ODCIVARCHAR2LIST('Upper back', 'Shoulders', 'Lats', 'Chest', 'Glutes', 'Hamstrings', 'Calves', 'Biceps', 'Triceps', 'Abs', 'Quads');
        workout_cur SYS_REFCURSOR;
        workout_rec Workout%ROWTYPE;
        valid_workouts workout_plan_result;
        current_muscle_group_count NUMBER;
        workout_count NUMBER;
        v_sql_statement VARCHAR2(4000);
    BEGIN
        FOR i IN 1 .. num_days LOOP
            v_workout_list := '';
            v_index := valid_workouts.FIRST;
            WHILE v_index IS NOT NULL LOOP
                IF v_workout_list <> '' THEN
                    v_workout_list := v_workout_list || ',';
                END IF;
                v_workout_list := v_workout_list || TO_CHAR(valid_workouts(v_index));
                v_index := valid_workouts.NEXT(v_index);
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
                v_index := valid_workouts.FIRST;
                WHILE v_index IS NOT NULL LOOP
                    IF valid_workouts(v_index) = workout_rec.Workout_ID THEN
                        workout_count := workout_count + 1;
                    END IF;
                    v_index := valid_workouts.NEXT(v_index);
                END LOOP;

                IF current_muscle_group_count >= 2 AND workout_count < 3 THEN
                    valid_workouts(i) := workout_rec.Workout_ID;
                    CLOSE workout_cur;
                    EXIT;
                END IF;
            END LOOP;
        END LOOP;

        workout_ids := valid_workouts;
    END generate_workout_plan;

BEGIN
    generate_workout_plan(5, v_workout_ids);
    v_index := v_workout_ids.FIRST;

    WHILE v_index IS NOT NULL LOOP
        DBMS_OUTPUT.PUT_LINE('Workout ID: ' || v_workout_ids(v_index));
        v_index := v_workout_ids.NEXT(v_index);
    END LOOP;
END;
/