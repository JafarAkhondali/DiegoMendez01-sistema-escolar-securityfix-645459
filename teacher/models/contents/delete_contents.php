<?php 

require_once '../../../includes/connection.php';

if($_POST){
    $id = $_POST['id'];
    
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
    
    $sql = '
        SELECT
            *
        FROM
            assessments
        WHERE
            content_id = ?
    ';
    
    $querys = $pdo->prepare($sql);
    $querys->execute([$id]);
    $data2  = $querys->fetch(PDO::FETCH_ASSOC);
    
    if(empty($data2)){
        $sqlUpdate = '
            DELETE FROM
                contents
            WHERE
                id = ?
        ';
        
        $queryUpdate = $pdo->prepare($sqlUpdate);
        $result = $queryUpdate->execute([$id]);
        
        if($result){
            if($data['material'] != ''){
                unlink($data['material']);
            }
            $answer = [
                'status' => true,
                'msg'    => 'Contenido eliminado correctamente'
            ];
        }else{
            $answer = [
                'status' => false,
                'msg'    => 'Error al eliminar'
            ];
        }
    }else{
        $answer = [
            'status' => false,
            'msg'    => 'No se puede eliminar, tiene evaluacion asignada'
        ];
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>