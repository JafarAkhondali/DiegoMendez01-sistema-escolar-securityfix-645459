<?php 

require_once '../../../includes/connection.php';

if($_POST){
    $id = $_POST['id'];
    
    $sql = '
        UPDATE
            degrees
        SET
            is_active = 0
        WHERE
            id = ?
    ';
    
    $query  = $pdo->prepare($sql);
    $result = $query->execute([$id]);
    
    if($result){
        $answer = [
            'status' => true,
            'msg'    => 'Grado eliminado correctamente'
        ];
    }else{
        $answer = [
            'status' => false,
            'msg'    => 'Error al eliminar el grado'
        ];
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>