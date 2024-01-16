<?php 

require_once '../../../includes/connection.php';


$sql = '
    SELECT
        *
    FROM
        classrooms
    WHERE
        is_active = 1
';

$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>