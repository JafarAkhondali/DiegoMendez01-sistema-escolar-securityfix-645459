<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['title']) OR empty($_POST['description']) OR empty($_POST['date']) OR empty($_POST['percentage'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son necesarios'
        ];
    }else{
        $id          = $_POST['id'];
        $idContent   = $_POST['idContent'];
        $title       = $_POST['title'];
        $description = $_POST['description'];
        $date        = $_POST['date'];
        $percentage  = $_POST['percentage'];
        
        if(empty($id)){
            $sqlInsert = '
                INSERT INTO
                    assessments (title, description, date, percentage, content_id, created)
                VALUES
                    (?, ?, ?, ?, ?, now())
            ';
            
            $queryInsert = $pdo->prepare($sqlInsert);
            $request     = $queryInsert->execute([$title, $description, $date, $percentage, $idContent]);
            $action = 1;
        }else{
            $sqlUpdate = '
                UPDATE
                    assessments
                SET
                    title = ?,
                    description = ?,
                    date = ?,
                    percentage = ?,
                    content_id = ?
                WHERE
                    id = ?
            ';
            
            $queryUpdate = $pdo->prepare($sqlUpdate);
            $request     = $queryUpdate->execute([$title, $description, $date, $percentage, $idContent, $id]);
            $action = 2;
        }
        if($request > 0){
            if($action == 1){
                $answer = [
                    'status' => true,
                    'msg'    => 'Evaluacion creada correctamente'
                ];
            }else{
                $answer = [
                    'status' => true,
                    'msg'    => 'Evaluacion actualizada correctamente'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
}

?>