<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['name']) OR empty($_POST['user']) OR empty($_POST['password_hash'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son requeridos'
        ];
    }else{
        $name          = $_POST['name'];
        $user          = $_POST['user'];
        $password      = $_POST['password_hash'];
        $role_id       = $_POST['role_id'];
        $is_active     = $_POST['is_active'];
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = '
            SELECT
                *
            FROM
                users
            WHERE
                user = ?
        ';
        
        $query  = $pdo->prepare($sql);
        $query->execute([$user]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            $answer = [
                'status' => false,
                'msg'    => 'El usuario ya existe'
            ];
        }else{
            $sqlInsert = '
                INSERT INTO
                    users (name, user, password_hash, role_id, is_active, created)
                VALUES (?, ?, ?, ?, ?, now())
            ';
            
            $queryInsert  = $pdo->prepare($sqlInsert);
            $resultInsert = $queryInsert->execute([$name, $user, $password_hash, $role_id, $is_active]);
            
            if($resultInsert){
                $answer = [
                    'status' => true,
                    'msg'    => 'Usuario creado correctamente'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el usuario'
                ];
            }
        }
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>