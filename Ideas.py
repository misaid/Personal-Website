import random

ideas = ['links website', 'resume website (2049 inspo)',
         'weather notifications website', 'pomodoro type website']
dic = {}

for i in range(100):
    x = random.choice(ideas)
    if x in dic:
        dic[x] += 1
    else:
        dic[x] = 0

print(dic)


l1 = [1,2,3,4,5,6]
l2 = [9,10,11]
l1 = l1+l2
print(l1)