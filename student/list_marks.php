<?php
if(!empty($_GET['course']) AND !empty($_GET['student'])){
    $courseId  = $_GET['course'];
    $studentId = $_GET['student'];
}else{
    header("Location: teacher/");
}
require_once 'includes/header.php';
require_once '../includes/connection.php';
require_once '../includes/functions.php';

// ID alumno
$idStudent = $_SESSION['id'];

$sql = '
    SELECT
        c.title,
        m.mark_value,
        a.title as titleAssessment
    FROM
        marks as m
    INNER JOIN submitted_assessments sa ON m.submitted_assessment_id = sa.id
    INNER JOIN students s ON sa.student_id = s.id
    INNER JOIN assessments a ON sa.assessment_id = a.id
    INNER JOIN contents c ON a.content_id = c.id
    INNER JOIN teacher_courses tc ON c.teacher_course_id = tc.id
    WHERE
        s.id = ? AND tc.id = ?
';

$query = $pdo->prepare($sql);
$query->execute([$idStudent, $courseId]);
$row = $query->rowCount();

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i>Notas Cargadas</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Notas cargadas</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="title-body">
        	<div class="table-responsive">
            	<table class="table table-hover table-bordered">
            		<thead>
            			<tr>
            				<th>Tema</th>
            				<th>Actividad</th>
            				<th>Notas</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php 
                      if($row > 0){
                          while($data = $query->fetch()){
                      ?>
                      <tr>
                      	<td><?= $data['title'] ?></td>
                      	<td><?= $data['titleAssessment'] ?></td>
                      	<td><?= $data['mark_value'] ?></td>
                      </tr>
                      <?php 
                          }
                      }
                      ?>
            		</tbody>
            	</table>
        	</div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
  	<div class="col-lg-12">
  		<div class="bs-component">
  			<ul class="list-group">
  				<li class="list-group-item"><span class="tag tag-default tag-pill float-xs-right"><strong>PROMEDIO: <?= formato(promedio($studentId)) ?></strong></span></li>
  			</ul>
  		</div>
  	</div>
  </div>
  <div class="row mt-3">
    <a href="marks.php?course=<?= $courseId ?>" class="btn btn-info">Volver Atras</a>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>