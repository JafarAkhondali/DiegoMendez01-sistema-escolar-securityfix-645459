<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['title']) OR empty($_POST['description'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son necesarios'
        ];
    }else{
        $id          = $_POST['id'];
        $idCourse    = $_POST['idCourse'];
        $title       = $_POST['title'];
        $description = $_POST['description'];
        
        // Files
        $material    = $_FILES['material']['name'];
        $type        = $_FILES['material']['type'];
        $url_temp    = $_FILES['material']['tmp_name'];
        
        $dir         = '../../../uploads/'.rand(1000, 10000);
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }
        
        $destiny     = $dir.'/'.$material;
        
        // Consulta actualizar
        $sql = '
            SELECT
                *
            FROM
                contents
            WHERE
                id = ?
        ';
        
        $query = $pdo->prepare($sql);
        $query->execute([$id]);
        $data  = $query->fetch(PDO::FETCH_ASSOC);
        
        if($_FILES['material']['size'] > 15000000){
            $answer = [
                'status' => false,
                'msg'    => 'Solo se permiten archivos hasta 15MB'
            ];
        }else{
            if(empty($id)){
                $sqlInsert = '
                INSERT INTO
                    contents (title, description, material, teacher_course_id, created)
                VALUES
                    (?, ?, ?, ?, now())
            ';
                
                $queryInsert = $pdo->prepare($sqlInsert);
                $request     = $queryInsert->execute([$title, $description, $destiny, $idCourse]);
                move_uploaded_file($url_temp, $destiny);
                $action = 1;
            }else{
                if(empty($_FILES['material']['name'])){
                    $sqlUpdate = '
                    UPDATE
                        contents
                    SET
                        title = ?,
                        description = ?,
                        teacher_course_id = ?
                    WHERE
                        id = ?
                ';
                    
                    $queryUpdate = $pdo->prepare($sqlUpdate);
                    $request     = $queryUpdate->execute([$title, $description, $idCourse, $id]);
                    $action = 2;
                }else{
                    $sqlUpdate = '
                    UPDATE
                        contents
                    SET
                        title = ?,
                        description = ?,
                        material = ?,
                        teacher_course_id = ?
                    WHERE
                        id = ?
                ';
                    
                    $queryUpdate = $pdo->prepare($sqlUpdate);
                    $request     = $queryUpdate->execute([$title, $description, $destiny, $idCourse, $id]);
                    if($data['material'] != ''){
                        unlink($data['material']);
                    }
                    move_uploaded_file($url_temp, $destiny);
                    $action = 3;
                }
            }
            if($request > 0){
                if($action == 1){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Contenido creado correctamente'
                    ];
                }else{
                    $answer = [
                        'status' => true,
                        'msg'    => 'Contenido actualizado correctamente'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
}

?>