<?php 

require_once '../../../includes/connection.php';

if(!empty($_GET)){
    $id = $_GET['id'];
    
    $sql = '
        SELECT
            *
        FROM
            student_teachers
        WHERE
            id = ?
    ';
    
    $query  = $pdo->prepare($sql);
    $query->execute([$id]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    if(empty($result)){
        $answer = [
            'status' => false,
            'msg'    => 'Datos no encontrados'
        ];
    }else{
        $answer = [
            'status' => true,
            'data'   => $result
        ];
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>