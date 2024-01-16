<?php 

require_once '../../../includes/connection.php';


$sql = '
    SELECT
        tc.id,
        t.name as nameTeacher,
        d.name as nameDegree,
        c.name as nameClassroom,
        p.name as namePeriod,
        cs.name nameCourse
    FROM
        teacher_courses as tc
    INNER JOIN teachers t ON tc.teacher_id = t.id
    INNER JOIN degrees d ON tc.degree_id = d.id
    INNER JOIN classrooms c ON tc.teacher_id = c.id
    INNER JOIN periods p ON tc.period_id = p.id
    INNER JOIN courses cs ON tc.course_id = cs.id
    WHERE
        tc.is_active = 1
';

$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>