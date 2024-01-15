<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['name']) OR empty($_POST['address']) OR empty($_POST['identification']) OR empty($_POST['phone']) OR empty($_POST['email']) OR empty($_POST['level'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son requeridos'
        ];
    }else{
        $id             = $_POST['id'];
        $name           = $_POST['name'];
        $address        = $_POST['address'];
        $identification = $_POST['identification'];
        $password       = $_POST['password'];
        $phone          = $_POST['phone'];
        $email          = $_POST['email'];
        $level          = $_POST['level'];
        $is_active      = $_POST['is_active'];
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = '
            SELECT
                *
            FROM
                teachers
            WHERE
                identification = ? AND id != ? AND is_active != 0
        ';
        
        $query  = $pdo->prepare($sql);
        $query->execute([$identification, $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            $answer = [
                'status' => false,
                'msg'    => 'El profesor ya existe'
            ];
        }else{
            if(empty($id)){
                $sqlInsert = '
                        INSERT INTO
                            teachers (name, address, identification, password, phone, email, level, is_active, created)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, now())
                    ';
                
                $queryInsert  = $pdo->prepare($sqlInsert);
                $request      = $queryInsert->execute([$name, $address, $identification, $password_hash, $phone, $email, $level, $is_active]);
                $action       = 1;
            }else{
                if(empty($password)){
                    $sqlUpdate = '
                        UPDATE
                            teachers 
                        SET
                            name = ?,
                            address = ?,
                            identification = ?,
                            phone = ?,
                            email = ?,
                            level = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                    
                    $queryUpdate  = $pdo->prepare($sqlUpdate);
                    $request      = $queryUpdate->execute([$name, $address, $identification, $phone, $email, $level, $is_active, $id]);
                    $action       = 2;
                }else{
                    $sqlUpdate = '
                        UPDATE
                            teachers
                        SET
                            name = ?,
                            address = ?,
                            identification = ?,
                            password = ?,
                            phone = ?,
                            email = ?,
                            level = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                    
                    $queryUpdate  = $pdo->prepare($sqlUpdate);
                    $request      = $queryUpdate->execute([$name, $address, $identification, $password_hash, $phone, $email, $level, $is_active, $id]);
                    $action       = 2;
                }
            }
            
            if($request > 0){
                if($action == 1){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Profesor creado correctamente'
                    ];
                }else{
                    $answer = [
                        'status' => true,
                        'msg'    => 'Profesor actualizado correctamente'
                    ];
                }
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el profesor'
                ];
            }
        }
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>