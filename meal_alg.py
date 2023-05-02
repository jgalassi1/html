import random
import json
import sys

def roundz(num, multiple):
    return multiple * round(num/multiple)


def maintenance(weight, height):
    if height < 72:
        return roundz(15*weight, 200) - 100
    return roundz(15*weight, 200)


def subset_sum(array, num):
    if num == 0 or num < 1:
        return None
    elif len(array) == 0:
        return None
    else:
        if array[0] == num:
            return [array[0]]
        else:
            with_v = subset_sum(array[1:], (num - array[0]))
            if with_v:
                return [array[0]] + with_v
            else:
                return subset_sum(array[1:], num)


def create_dict(meals):
    meal_dict = {}
    for meal in meals:
        if meal[1] in meal_dict:
            meal_dict[meal[1]].append((meal[2], meal[0]))
        else:
            meal_dict[meal[1]] = [(meal[2], meal[0])]
    return meal_dict


def get_meals(cals, meal_dict, total_protein):
    cur_protein = 0
    used = {}
    meals = []
    for cal in cals:
        for protein in reversed(meal_dict[cal]):
            if protein[0] + cur_protein > total_protein and protein != meal_dict[cal][0]:
                continue
            elif protein[1] not in used:
                used[protein[1]] = 1
                meals.append(protein[1])
                cur_protein += protein[0]
                break
    return meals


def generate_meals(weight, height, body_type):
    values = [(1, 150, 2), (2, 150, 5), (3, 150, 10), (4, 150, 15), (5, 150, 18), (6, 200, 5), (7, 200, 10), (8, 200, 15), (9, 200, 30), (10, 250, 5), (11, 250, 10), (12, 250, 15), (13, 250, 20), (14, 300, 10), (15, 300, 15), (16, 300, 20), (17, 300, 25), (18, 350, 8), (19, 350, 10), (20, 350, 15),
              (21, 350, 20), (22, 350, 25), (23, 350, 30), (24, 350, 35), (25, 400, 10), (26, 400, 15), (27, 400, 18), (28, 400, 20), (29, 400, 25), (30, 400, 30), (31, 400, 35), (32, 400, 40), (33, 450, 15), (34, 450, 20), (35, 450, 25), (36, 450, 30), (37, 450, 35), (38, 500, 20), (39, 500, 25), (40, 500, 40)]
    calories = maintenance(weight, height)
    protein = roundz(weight, 20)
    calories_list = [cal[1] for cal in values]
    if body_type == 0:
        calories -= 300
        protein += 20
    elif body_type == 2:
        calories += 500
    random.shuffle(calories_list)
    cals = subset_sum(calories_list, calories)
    dict = create_dict(values)
    meal_ids = get_meals(cals, dict, protein)
    sum_protein = 0
    for i in meal_ids:
        sum_protein += values[i-1][2]
    return (meal_ids, calories, sum_protein)


def get_max_protein(weight, height, body_type):
    max_protein = 0
    cur_meals = []
    for i in range(5):
        tuple = generate_meals(weight, height, body_type)
        if tuple[2] > max_protein:
            max_protein = tuple[2]
            cur_meals = tuple[0]
    return (cur_meals,max_protein,tuple[1])


if __name__ == "__main__":
    weight = float(sys.argv[1])
    height = float(sys.argv[2])
    body_type = int(sys.argv[3])

    result = get_max_protein(weight, height, body_type)
    string = ''
    for i in range(len(result[0])):
        if i == 0:
            string = str(result[0][i])
        else:
            string = str(string + ',' + str(result[0][i]))
    print(string+';'+str(result[1])+';'+str(int(result[2])))