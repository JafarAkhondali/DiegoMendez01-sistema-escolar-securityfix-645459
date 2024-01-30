<?php 

if(!empty($_GET['course']) AND !empty($_GET['content'] AND !empty($_GET['assessment']))){
    $courseId     = $_GET['course'];
    $contentId    = $_GET['content'];
    $assessmentId = $_GET['assessment'];
}else{
    header("Location: student/");
}

require_once 'includes/header.php';
require_once '../includes/connection.php';

$idStudent = $_SESSION['id'];

$sql1 = '
    SELECT
        sa.id
    FROM
        submitted_assessments sa
    INNER JOIN students s ON sa.student_id = s.id
    INNER JOIN assessments a ON sa.assessment_id = a.id
    INNER JOIN contents c ON a.content_id = c.id
    WHERE
        a.id = ? AND s.id = ?
';

$query1 = $pdo->prepare($sql1);
$query1->execute([$assessmentId, $idStudent]);
$row1   = $query1->rowCount();

date_default_timezone_set("America/Bogota");
$date = date('Y-m-d');

$sql2 = '
    SELECT
        *
    FROM
        assessments a
    WHERE
        a.content_id = ?
';

$query2 = $pdo->prepare($sql2);
$query2->execute([$contentId]);
$result = $query2->fetch();
$dateLimit = $result['date'];

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i>Realizar Entrega</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Realizar entrega</a></li>
    </ul>
  </div>
  <?php
    if($row1 > 0){
        while($data = $query1->fetch()){
            $value               = '';
            $calificacion        = '';
            $submittedAssessment = $data['id'];
            
            $sqlMark = '
                SELECT
                    m.mark_value
                FROM
                    marks as m
                INNER JOIN submitted_assessments sa ON m.submitted_assessment_id = sa.id
                INNER JOIN students s ON sa.student_id = s.id
                WHERE
                    m.submitted_assessment_id = ? AND s.id = ?
            ';
            
            $queryMark = $pdo->prepare($sqlMark);
            $queryMark->execute([$submittedAssessment, $idStudent]);
            $rowMark   = $queryMark->rowCount();
            $mark      = $queryMark->fetch();
            
            if($rowMark > 0){
                $value        = '<kbd class="bg-success">Calificado</kbd>';
                $calificacion = $mark['mark_value'];
            }else{
                $value        = '<kbd class="bg-danger">Sin Calificar</kbd>';
                $calificacion = '';
            }
            ?>
            <div class="row mt-2 bg-success text-white p-2">
            	<h1>Ya realizo la entrega</h1>
            </div>
            <div class="row mt-3">
                <table class="table table-bordered">
                	<thead>
                		<tr>
                			<td>Estado</td>
                			<td>Calificacion</td>
                		</tr>
                	</thead>
                	<tbody>
                		<tr>
                			<td><?= $value; ?></td>
                			<td><?= $calificacion ?></td>
                		</tr>
                	</tbody>
                </table>
            </div>
            <?php
        }
    }else{
        if($date < $dateLimit){
            ?>
            <div class="row">
            	<div class="col-md-12">
            		<div class="tile">
                        <h3 class="tile-title">Realizar entrega</h3>
                        <div class="tile-body">
                          <form class="form-horizontal" id="formSubmitActivity">
                            <div class="mb-3 row">
                              <label class="form-label col-md-3">Descripción de la Actividad</label>
                              <div class="col-md-8">
                                <textarea class="form-control" name="observation" id="observation" rows="4" placeholder="Enter your address"></textarea>
                              </div>
                            </div>
                            <div class="mb-3 row">
                              <div class="col-md-12">
                                <input type="file" name="file" id="file" class="form-control">
                              </div>
                            </div>
                            <div class="tile-footer">
                              <div class="row">
                                <div class="col-md-8 col-md-offset-3">
                                  <button class="btn btn-primary" type="button"><i class="bi bi-check-circle-fill me-2"></i>Enviar</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                     </div>
            	</div>
            </div>
            <?php
        }else{
            ?>
            <div class="row bg-danger p-3 text-white">
            	<h5>Ya no pueden hacer entregas (Fecha limite <?= $dateLimit; ?>)</h5>
            </div>
            <?php
        }
    }
  ?>
  <div class="row p-2">
    <a href="contents.php?course=<?= $courseId ?>&content=<?= $contentId ?>" class="btn btn-info">Volver Atras</a>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>