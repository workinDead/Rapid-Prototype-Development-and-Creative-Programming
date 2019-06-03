mysql> show tables;
+---------------+
| Tables_in_fox |
+---------------+
| comments      |
| links         |
| stories       |
| users         |
+---------------+
4 rows in set (0.00 sec)


mysql> describe comments;
+--------------+------------------+------+-----+-------------------+---------------                                                                  -+
| Field        | Type             | Null | Key | Default           | Extra                                                                            |
+--------------+------------------+------+-----+-------------------+---------------                                                                  -+
| username     | varchar(30)      | NO   | MUL | NULL              |                                                                                  |
| story_id     | int(10) unsigned | NO   | MUL | NULL              |                                                                                  |
| comment      | varchar(140)     | YES  |     | NULL              |                                                                                  |
| comment_time | timestamp        | NO   |     | CURRENT_TIMESTAMP |                                                                                  |
| comment_id   | int(10) unsigned | NO   | PRI | NULL              | auto_increment                                                                   |
+--------------+------------------+------+-----+-------------------+---------------                                                                  -+

mysql> describe links;
+----------+------------------+------+-----+---------+-------+
| Field    | Type             | Null | Key | Default | Extra |
+----------+------------------+------+-----+---------+-------+
| story_id | int(10) unsigned | NO   | PRI | NULL    |       |
| link     | varchar(255)     | YES  |     | NULL    |       |
+----------+------------------+------+-----+---------+-------+
2 rows in set (0.00 sec)

mysql> describe stories;
+-------------+------------------+------+-----+-------------------+----------------+
| Field       | Type             | Null | Key | Default           | Extra          |
+-------------+------------------+------+-----+-------------------+----------------+
| username    | varchar(30)      | NO   | MUL | NULL              |                |
| story_id    | int(10) unsigned | NO   | PRI | NULL              | auto_increment |
| story       | varchar(255)     | YES  |     | NULL              |                |
| story_time  | timestamp        | NO   |     | CURRENT_TIMESTAMP |                |
| story_title | varchar(255)     | NO   |     | NULL              |                |
+-------------+------------------+------+-----+-------------------+----------------+
5 rows in set (0.00 sec)


mysql> describe users;
+-------------+--------------+------+-----+--------------------------------------------------------------------------------+-------+
| Field       | Type         | Null | Key | Default                                                                        | Extra |
+-------------+--------------+------+-----+--------------------------------------------------------------------------------+-------+
| username    | varchar(30)  | NO   | PRI | NULL                                                                           |       |
| password    | varchar(255) | NO   |     | NULL                                                                           |       |
| signup_time | timestamp    | NO   |     | CURRENT_TIMESTAMP                                                              |       |
| img_url     | varchar(255) | NO   |     | https://abs.twimg.com/sticky/default_profile_images/default_profile_bigger.png |       |
| birthday    | varchar(255) | YES  |     | NULL                                                                           |       |
| email       | varchar(255) | YES  |     | NULL                                                                           |       |
| intro       | varchar(255) | YES  |     | NULL                                                                           |       |
| location    | varchar(255) | YES  |     | NULL                                                                           |       |
+-------------+--------------+------+-----+--------------------------------------------------------------------------------+-------+
8 rows in set (0.01 sec)
