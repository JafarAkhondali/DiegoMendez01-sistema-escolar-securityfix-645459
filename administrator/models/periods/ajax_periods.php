<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(empty($_POST['name'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son requeridos'
        ];
    }else{
        $id             = $_POST['id'];
        $name           = $_POST['name'];
        $is_active      = $_POST['is_active'];
        
        $sql = '
            SELECT
                *
            FROM
                periods
            WHERE
                name = ? AND id != ? AND is_active != 0
        ';
        
        $query  = $pdo->prepare($sql);
        $query->execute([$name, $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            $answer = [
                'status' => false,
                'msg'    => 'El periodo ya existe'
            ];
        }else{
            if(empty($id)){
                $sqlInsert = '
                        INSERT INTO
                            periods (name, is_active, created)
                        VALUES (?, ?, now())
                    ';
                
                $queryInsert  = $pdo->prepare($sqlInsert);
                $request      = $queryInsert->execute([$name, $is_active]);
                $action       = 1;
            }else{
                $sqlUpdate = '
                    UPDATE
                        periods 
                    SET
                        name = ?,
                        is_active = ?
                    WHERE
                        id = ?
                ';
                
                $queryUpdate  = $pdo->prepare($sqlUpdate);
                $request      = $queryUpdate->execute([$name, $is_active, $id]);
                $action       = 2;
            }
            
            if($request > 0){
                if($action == 1){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Periodo creado correctamente'
                    ];
                }else{
                    $answer = [
                        'status' => true,
                        'msg'    => 'Periodo actualizado correctamente'
                    ];
                }
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el periodo'
                ];
            }
        }
    }
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
}

?>