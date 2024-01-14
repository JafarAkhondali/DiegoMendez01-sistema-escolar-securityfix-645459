<?php 

require_once '../../../includes/connection.php';

$sql = '
    SELECT
        u.*,
        r.name as nameRol
    FROM
        users as u
    INNER JOIN roles as r ON u.role_id = r.id
';

$query = $pdo->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta); $i++){
    if($consulta[$i]['is_active'] == 1){
        $consulta[$i]['is_active'] = '<span class="me-1 badge bg-success">Activo</span>';
    }else{
        $consulta[$i]['is_active'] = '<span class="me-1 badge bg-danger">Inactivo</span>';
    }
    
    $consulta[$i]['acciones'] = '
        <button class="btn btn-primary" title="Editar" onclick="edituser('.$consulta[$i]['id'].')">Editar</button>
        <button class="btn btn-danger" title="Eliminar" onclick="deleteuser('.$consulta[$i]['id'].')">Eliminar</button>
    ';
}

echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
?>