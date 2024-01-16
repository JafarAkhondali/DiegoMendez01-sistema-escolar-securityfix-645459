<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['teacher_id']) OR empty($_POST['degree_id']) OR empty($_POST['classroom_id']) OR empty($_POST['course_id']) OR empty($_POST['period_id'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son requeridos'
        ];
    }else{
        $id             = $_POST['id'];
        $teacher        = $_POST['teacher_id'];
        $degree         = $_POST['degree_id'];
        $classroom      = $_POST['classroom_id'];
        $course         = $_POST['course_id'];
        $period         = $_POST['period_id'];
        $is_active      = $_POST['is_active'];
        
        // Consulta para insertar
        $sql = '
            SELECT
                *
            FROM
                teacher_courses
            WHERE
                teacher_id = ? AND degree_id = ? AND classroom_id = ? AND course_id = ? AND period_id = ? AND is_active != 0
        ';
        
        $query  = $pdo->prepare($sql);
        $query->execute([$teacher, $degree, $classroom, $course, $period]);
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        // Consulta para actualizar
        $sql2 = '
            SELECT
                *
            FROM
                teacher_courses
            WHERE
                teacher_id = ? AND degree_id = ? AND classroom_id = ? AND course_id = ? AND period_id = ? AND id != ? AND is_active != 0
        ';
        
        $query2  = $pdo->prepare($sql2);
        $query2->execute([$teacher, $degree, $classroom, $course, $period, $id]);
        $resultUpdate = $query2->fetch(PDO::FETCH_ASSOC);
        
        if($resultInsert > 0){
            $answer = [
                'status' => false,
                'msg'    => 'El grado, aula, materia y profesor existen, seleccione otro'
            ];
        }else{
            if(empty($id)){
                $sqlInsert = '
                        INSERT INTO
                            teacher_courses (teacher_id, degree_id, classroom_id, course_id, period_id, is_active, created)
                        VALUES (?, ?, ?, ?, ?, ?, now())
                    ';
                
                $queryInsert  = $pdo->prepare($sqlInsert);
                $request      = $queryInsert->execute([$teacher, $degree, $classroom, $course, $period, $is_active]);
                
                if($request){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Proceso creado correctamente'
                    ];
                }
            }
        }
        
        if($resultUpdate > 0){
            $answer = [
                'status' => false,
                'msg'    => 'El grado, aula, materia y profesor existen, seleccione otro'
            ];
        }else{
            if(!empty($id)){
                $sqlUpdate = '
                        UPDATE
                            teacher_courses
                        SET
                            teacher_id = ?,
                            degree_id = ?,
                            classroom_id = ?,
                            course_id = ?,
                            period_id = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                
                $queryUpdate = $pdo->prepare($sqlUpdate);
                $request2      = $queryUpdate->execute([$teacher, $degree, $classroom, $course, $period, $is_active, $id]);
                
                if($request2){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Proceso actualizado correctamente'
                    ];
                }
            }
        }
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>