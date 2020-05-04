---------------------
weight
---------------------
### Контроль веса пользователя.
### Вывод средних данных за любой интервал, с нужным уровнем детализации.

Описание окружения и версий  
php >= 5.4  
mysql >= 5.7  

Примеры запуска скрипта  
http://localhost/weight/app/weight.php
http://localhost/weight/app/weight.php?date_start=2019-02-01
http://localhost/weight/app/weight.php?detalization=week  
http://localhost/weight/app/weight.php?date_start=2019-02-01&date_end=2019-12-10&detalization=month  

Скрипт возвращает JSON  
в зависимости от параметра detalization  

detalization=day (day - значение по умолчанию)  
Дата Y-m-d, средний вес  

detalization=week  
Год-номер_недели_в_году, средний вес  

detalization=month  
Год-номер_месяца_в_году, средний вес  
