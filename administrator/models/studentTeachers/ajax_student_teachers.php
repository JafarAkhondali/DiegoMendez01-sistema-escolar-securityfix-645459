<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['student_id']) OR empty($_POST['teacher_course_id']) OR empty($_POST['period_id'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son requeridos'
        ];
    }else{
        $id             = $_POST['id'];
        $student        = $_POST['student_id'];
        $teacherCourse  = $_POST['teacher_course_id'];
        $period         = $_POST['period_id'];
        $is_active      = $_POST['is_active'];
        
        // Consulta para insertar
        $sql = '
            SELECT
                *
            FROM
                student_teachers
            WHERE
                student_id = ? AND teacher_course_id = ? AND period_id = ? AND is_active != 0
        ';
        
        $query  = $pdo->prepare($sql);
        $query->execute([$student, $teacherCourse, $period]);
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        // Consulta para actualizar
        $sql2 = '
            SELECT
                *
            FROM
                student_teachers
            WHERE
                student_id = ? AND teacher_course_id = ? AND period_id = ? AND id != ? AND is_active != 0
        ';
        
        $query2  = $pdo->prepare($sql2);
        $query2->execute([$student, $teacherCourse, $period, $id]);
        $resultUpdate = $query2->fetch(PDO::FETCH_ASSOC);
        
        if($resultInsert > 0){
            $answer = [
                'status' => false,
                'msg'    => 'El alumno tiene el grado y profesor asignado, seleccione otro'
            ];
        }else{
            if(empty($id)){
                $sqlInsert = '
                        INSERT INTO
                            student_teachers (student_id, teacher_course_id, period_id, is_active, created)
                        VALUES (?, ?, ?, ?, now())
                    ';
                
                $queryInsert  = $pdo->prepare($sqlInsert);
                $request      = $queryInsert->execute([$student, $teacherCourse, $period, $is_active]);
                
                if($request){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Proceso Alumno creado correctamente'
                    ];
                }
            }
        }
        
        if($resultUpdate > 0){
            $answer = [
                'status' => false,
                'msg'    => 'El alumno tiene el grado y profesor asignado, seleccione otro'
            ];
        }else{
            if(!empty($id)){
                $sqlUpdate = '
                        UPDATE
                            student_teachers
                        SET
                            student_id = ?,
                            teacher_course_id = ?,
                            period_id = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                
                $queryUpdate = $pdo->prepare($sqlUpdate);
                $request2      = $queryUpdate->execute([$student, $teacherCourse, $period, $is_active, $id]);
                
                if($request2){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Proceso Alumno actualizado correctamente'
                    ];
                }
            }
        }
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>