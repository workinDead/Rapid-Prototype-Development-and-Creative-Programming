mysql> describe departments;
+--------------+---------------------------------------------------+------+-----+---------+-------+
| Field        | Type                                              | Null | Key | Default | Extra |
+--------------+---------------------------------------------------+------+-----+---------+-------+
| school_code  | enum('L','B','A','F','E','T','I','W','S','U','M') | NO   | PRI | L       |       |
| dept_id      | tinyint(3) unsigned                               | NO   | PRI | NULL    |       |
| abbreviation | varchar(9)                                        | NO   |     | NULL    |       |
| dept_name    | varchar(200)                                      | NO   |     | NULL    |       |
+--------------+---------------------------------------------------+------+-----+---------+-------+
4 rows in set (0.00 sec)
