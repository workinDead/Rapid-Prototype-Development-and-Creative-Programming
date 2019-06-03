mysql> describe grades;
+-------------+---------------------------------------------------+------+-----+---------+----------------+
| Field       | Type                                              | Null | Key | Default | Extra          |
+-------------+---------------------------------------------------+------+-----+---------+----------------+
| pk_grade_ID | smallint(5) unsigned                              | NO   | PRI | NULL    | auto_increment |
| student_id  | mediumint(8) unsigned                             | NO   | MUL | NULL    |                |
| grade       | decimal(5,2)                                      | NO   |     | NULL    |                |
| school_code | enum('L','B','A','F','E','T','I','W','S','U','M') | YES  | MUL | NULL    |                |
| dept_id     | tinyint(3) unsigned                               | NO   |     | NULL    |                |
| course_code | char(5)                                           | NO   |     | NULL    |                |
+-------------+---------------------------------------------------+------+-----+---------+----------------+
6 rows in set (0.00 sec)
