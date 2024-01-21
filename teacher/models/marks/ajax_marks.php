<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(trim($_POST['mark_value']) == ''){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son necesarios'
        ];
    }else{
        $idSubmittedAssessment    = $_POST['idSubmittedAssessment'];
        $mark_value               = $_POST['mark_value'];
        
        $sqlInsert = '
            INSERT INTO
                marks (submitted_assessment_id, mark_value, date, created)
            VALUES
                (?, ?, now(), now())
        ';
        
        $queryInsert = $pdo->prepare($sqlInsert);
        $request     = $queryInsert->execute([$idSubmittedAssessment, $mark_value]);
        
        if($request > 0){
            $answer = [
                'status' => true,
                'msg'    => 'Evaluacion creada correctamente'
            ];
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
}

?>