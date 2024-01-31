<?php 

require_once '../../../includes/connection.php';

if(!empty($_POST)){
    if(trim($_POST['observation']) == '' OR empty($_FILES['file'])){
        $answer = [
            'status' => false,
            'msg'    => 'Todos los campos son necesarios'
        ];
    }else{
        $idStudent      = $_POST['student_id'];
        $idAssessment   = $_POST['assessment_id'];
        $observation    = $_POST['observation'];
        
        // Files
        $material    = $_FILES['file']['name'];
        $type        = $_FILES['file']['type'];
        $url_temp    = $_FILES['file']['tmp_name'];
        
        $dir         = '../../../uploads/'.rand(1000, 10000);
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }
        
        $destiny     = $dir.'/'.$material;
        
        if($_FILES['file']['size'] > 15000000){
            $answer = [
                'status' => false,
                'msg'    => 'Solo se permiten archivos hasta 15MB'
            ];
        }else{
            $sqlInsert = '
                INSERT INTO
                    submitted_assessments (observation, material, assessment_id, student_id, created)
                VALUES
                    (?, ?, ?, ?, now())
            ';
            
            $queryInsert = $pdo->prepare($sqlInsert);
            $request     = $queryInsert->execute([$observation, $destiny, $idAssessment, $idStudent]);
            move_uploaded_file($url_temp, $destiny);
            if($request > 0){
                $answer = [
                    'status' => true,
                    'msg'    => 'Evaluacion enviada correctamente'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
}

?>