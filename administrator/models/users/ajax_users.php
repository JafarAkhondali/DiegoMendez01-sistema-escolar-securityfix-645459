<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['name']) OR empty($_POST['user'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son requeridos'
        ];
    }else{
        $id            = $_POST['id'];
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
                user = ? AND id != ? AND is_active != 0
        ';
        
        $query  = $pdo->prepare($sql);
        $query->execute([$user, $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            $answer = [
                'status' => false,
                'msg'    => 'El usuario ya existe'
            ];
        }else{
            if($id == 0){
                $sqlInsert = '
                        INSERT INTO
                            users (name, user, password_hash, role_id, is_active, created)
                        VALUES (?, ?, ?, ?, ?, now())
                    ';
                
                $queryInsert  = $pdo->prepare($sqlInsert);
                $request      = $queryInsert->execute([$name, $user, $password_hash, $role_id, $is_active]);
                $action       = 1;
            }else{
                if(empty($password_hash)){
                    $sqlUpdate = '
                        UPDATE
                            users 
                        SET
                            name = ?,
                            user = ?,
                            role_id = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                    
                    $queryUpdate  = $pdo->prepare($sqlUpdate);
                    $request      = $queryUpdate->execute([$name, $user, $role_id, $is_active, $id]);
                    $action       = 2;
                }else{
                    $sqlUpdate = '
                        UPDATE
                            users
                        SET
                            name = ?,
                            user = ?,
                            password_hash = ?,
                            role_id = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                    
                    $queryUpdate  = $pdo->prepare($sqlUpdate);
                    $request      = $queryUpdate->execute([$name, $user, $password_hash, $role_id, $is_active, $id]);
                    $action       = 3;
                }
            }
            
            if($request > 0){
                if($action == 1){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Usuario creado correctamente'
                    ];
                }else{
                    $answer = [
                        'status' => true,
                        'msg'    => 'Usuario actualizado correctamente'
                    ];
                }
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