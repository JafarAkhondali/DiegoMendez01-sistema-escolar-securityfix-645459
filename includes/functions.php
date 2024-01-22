<?php 

$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$baseUrl = 'http://'.$_SERVER['HTTP_HOST'].$baseDir;

define('BASE_URL', $baseUrl);

function promedio($student)
{
    global $pdo;
    $promedio = 0;
    
    $sqlCantMarks = '
        SELECT
            COUNT(mark_value) as num
        FROM
            marks as m
        INNER JOIN submitted_assessments sa ON m.submitted_assessment_id = sa.id
        WHERE
            sa.student_id = ?
    ';
    $queryCantMark = $pdo->prepare($sqlCantMarks);
    $queryCantMark->execute([$student]);
    
    if($row = $queryCantMark->fetch()){
        $cantMarks = $row['num'];
    }
    
    $sqlMark = '
        SELECT
            *
        FROM
            marks as m
        INNER JOIN submitted_assessments sa ON m.submitted_assessment_id = sa.id
        WHERE
            sa.student_id = ?
    ';
    $queryMark = $pdo->prepare($sqlMark);
    $queryMark->execute([$student]);
    $count     = $queryMark->rowCount();
    
    while($row = $queryMark->fetch()){
        $promedio = $promedio + $row['mark_value'];
    }
    
    if($count > 0){
        return $promedio / $cantMarks;
    }else{
        $promedio = 0;
    }
}

function formato($cant)
{
    $cant = number_format($cant, 2, ',', '.');
    return $cant;
}

?>