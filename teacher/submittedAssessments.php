<?php 
if(!empty($_GET['course']) AND !empty($_GET['content']) AND !empty($_GET['assessment'])){
    $courseId     = $_GET['course'];
    $contentId    = $_GET['content'];
    $assessmentId = $_GET['assessment'];
}else{
    header("Location: teacher/");
}
require_once 'includes/header.php';
require_once '../includes/connection.php';

//ID del profesor
$id = $_SESSION['id'];

$sql = '
    SELECT
        a.id,
        DATE_FORMAT(a.date, "%d/%m/%Y") as date,
        a.percentage,
        a.description,
        a.title
    FROM
        assessments as a
    INNER JOIN contents c ON a.content_id = c.id
    INNER JOIN teacher_courses tc ON c.teacher_course_id = tc.id 
    WHERE
        a.content_id = ? AND a.is_active = 1 AND a.id = ?
';

$query = $pdo->prepare($sql);
$query->execute([$contentId, $assessmentId]);
$row = $query->rowCount();

$sql2 = '
    SELECT
        s.id as idStudent,
        s.name as nameStudent,
        sa.observation,
        c.material,
        sa.id
    FROM
        submitted_assessments as sa
    INNER JOIN students s ON sa.student_id = s.id
    INNER JOIN assessments a ON sa.assessment_id = a.id
    INNER JOIN contents c ON a.content_id = c.id
    WHERE
        sa.assessment_id = ? AND sa.is_active = 1
';

$query2 = $pdo->prepare($sql2);
$query2->execute([$assessmentId]);
$row2 = $query2->rowCount();

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i>Evaluaciones Entregadas</h1>
      <button class="btn btn-success" type="button" onclick="openModalAssessment()">Nueva Evaluacion</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Evaluaciones entregadas</a></li>
    </ul>
  </div>
  <div class="row">
  <?php 
  if($row > 0){
      while($data = $query->fetch()){
  ?>
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-title-w-btn">
          <h3 class="title"><?= $data['title']; ?></h3>
        </div>
        <div class="title-body">
          <b><?= $data['description']; ?></b><br><br>
          <b>Fecha: <kbd class="bg-info"><?= $data['date']; ?></kbd></b><br><br>
          <b>Valor: <?= $data['percentage']; ?></b>
        </div>
      </div>
    </div>
    <?php 
      }
  }
  ?>
  </div>
  <div class="row mt-2 bg-secondary text-white p-2">
  	<h3>Evaluaciones Entregadas</h3>
  </div>
  <div class="row mt-3">
  <?php 
    if($row2 > 0){
        while($data2 = $query2->fetch()){
            $value                = '';
            $cargue               = '';
            $student              = $data2['idStudent'];
            $submittedAssessment  = $data2['id'];
          
            $sql3 = '
                SELECT
                    *
                FROM
                    marks
                WHERE
                    assessment_id = ?
            ';
            
            $query3 = $pdo->prepare($sql3);
            $query3->execute([$submittedAssessment]);
            $data3  = $query3->rowCount();
            
            if($data3 > 0){
                $value  = '<kbd class="bg-success">Calificado</kbd>';
                $cargue = '';
            }else{
                require_once 'includes/modals/modal_mark.php';
                $value  = '<kbd class="bg-success">Sin Calificar</kbd';
                $cargue = '<button class="btn btn-warning" onclick="modalNota()">Cargar Nota</button>';
            }
  ?>
       <div class="col-md-12">
            <div class="tile">
                 <table class="table table-bordered">
                      <thead>
                           <tr>
                                <th>Alumno</th>
                                <th>Obervacion</th>
                                <th>Material</th>
                                <th>Estado</th>
                                <th>Cargar Nota</th>
                           </tr>
                      </thead>
                      <tbody>
                           <tr>
                                <th><?= $data2['nameStudent'] ?></th>
                                <th><?= $data2['observation'] ?></th>
                                <th>
                                	<div class="input-group">
                                		<div class="input-group-prepend">
                                			<div class="input-group-text"><i class="fas fa-download" style="height: 22px;"></i></div>
                                		</div>
                                		<a class="btn btn-primary" href="BASE_URL<?= $data2['material']; ?>" target="_blank">Material</a>
                                	</div>
                                </th>
                                <th><?= $value ?></th>
                                <th><?= $cargue ?></th>
                           </tr>
                      </tbody>
                 </table>
            </div>
       </div>
  </div>
  <?php 
      }
  }
  ?>
  <div class="row">
    <a href="contents.php?course=<?= $courseId ?>" class="btn btn-info">Volver Atras</a>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>