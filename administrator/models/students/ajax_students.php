<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['name']) OR empty($_POST['age']) OR empty($_POST['address']) OR empty($_POST['identification']) OR empty($_POST['phone']) OR empty($_POST['email']) OR empty($_POST['birthdate'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son requeridos'
        ];
    }else{
        $id             = $_POST['id'];
        $name           = $_POST['name'];
        $age            = $_POST['age'];
        $address        = $_POST['address'];
        $identification = $_POST['identification'];
        $password       = $_POST['password'];
        $phone          = $_POST['phone'];
        $email          = $_POST['email'];
        $birthdate      = $_POST['birthdate'];
        $is_active      = $_POST['is_active'];
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = '
            SELECT
                *
            FROM
                students
            WHERE
                identification = ? AND id != ? AND is_active != 0
        ';
        
        $query  = $pdo->prepare($sql);
        $query->execute([$identification, $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            $answer = [
                'status' => false,
                'msg'    => 'El alumno ya existe'
            ];
        }else{
            if(empty($id)){
                $sqlInsert = '
                        INSERT INTO
                            students (name, age, address, identification, password, phone, email, birthdate, is_active, created)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, now())
                    ';
                
                $queryInsert  = $pdo->prepare($sqlInsert);
                $request      = $queryInsert->execute([$name, $age, $address, $identification, $password_hash, $phone, $email, $birthdate, $is_active]);
                $action       = 1;
            }else{
                if(empty($password)){
                    $sqlUpdate = '
                        UPDATE
                            students 
                        SET
                            name = ?,
                            age  = ?,
                            address = ?,
                            identification = ?,
                            phone = ?,
                            email = ?,
                            birthdate = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                    
                    $queryUpdate  = $pdo->prepare($sqlUpdate);
                    $request      = $queryUpdate->execute([$name, $age, $address, $identification, $phone, $email, $birthdate, $is_active, $id]);
                    $action       = 2;
                }else{
                    $sqlUpdate = '
                        UPDATE
                            students
                        SET
                            name = ?,
                            age  = ?,
                            address = ?,
                            identification = ?,
                            password = ?,
                            phone = ?,
                            email = ?,
                            birthdate = ?,
                            is_active = ?
                        WHERE
                            id = ?
                    ';
                    
                    $queryUpdate  = $pdo->prepare($sqlUpdate);
                    $request      = $queryUpdate->execute([$name, $age, $address, $identification, $password_hash, $phone, $email, $birthdate, $is_active, $id]);
                    $action       = 2;
                }
            }
            
            if($request > 0){
                if($action == 1){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Alumno creado correctamente'
                    ];
                }else{
                    $answer = [
                        'status' => true,
                        'msg'    => 'Alumno actualizado correctamente'
                    ];
                }
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el alumno'
                ];
            }
        }
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>