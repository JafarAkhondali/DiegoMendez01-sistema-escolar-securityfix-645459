<?php 

require_once '../../../includes/connection.php';

$sql = '
    SELECT
        *
    FROM
        teacher_courses as tc
    INNER JOIN teachers t ON tc.teacher_id = t.id
    INNER JOIN degrees d ON tc.degree_id = d.id
    INNER JOIN classrooms c ON tc.classroom_id = c.id
    INNER JOIN courses cs ON tc.course_id = cs.id
    INNER JOIN periods p ON tc.period_id = p.id
    WHERE
        tc.is_active != 0
';

$query = $pdo->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta); $i++){
    if($consulta[$i]['is_active'] == 1){
        $consulta[$i]['is_active'] = '<span class="me-1 badge bg-success">Activo</span>';
    }else{
        $consulta[$i]['is_active'] = '<span class="me-1 badge bg-danger">Inactivo</span>';
    }
    
    $consulta[$i]['acciones'] = '
        <button class="btn btn-primary" title="Editar" onclick="editTeacherCourse('.$consulta[$i]['id'].')">Editar</button>
        <button class="btn btn-danger" title="Eliminar" onclick="deleteTeacherCourse('.$consulta[$i]['id'].')">Eliminar</button>
    ';
}

echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
?>