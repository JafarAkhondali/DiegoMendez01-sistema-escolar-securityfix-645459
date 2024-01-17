<?php 

require_once '../../../includes/connection.php';

if($_POST){
    $id = $_POST['id'];
    
    $sqlUpdate = '
        UPDATE
            assessments
        SET
            is_active = 0
        WHERE
            id = ?
    ';
    
    $queryUpdate = $pdo->prepare($sqlUpdate);
    $result = $queryUpdate->execute([$id]);
    
    if($result){
        $answer = [
            'status' => true,
            'msg'    => 'Evaluacion eliminada correctamente'
        ];
    }else{
        $answer = [
            'status' => false,
            'msg'    => 'Error al eliminar'
        ];
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>