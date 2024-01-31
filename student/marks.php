<?php 
if(!empty($_GET['course'])){
    $courseId = $_GET['course'];
}else{
    header("Location: teacher/");
}
require_once 'includes/header.php';
require_once '../includes/connection.php';

// ID alumno
$idStudent = $_SESSION['id'];

$sql = '
    SELECT
        s.id as idStudent,
        s.name as nameStudent,
        tc.id as idTeacherCourse
    FROM
        student_teachers as st
    INNER JOIN teacher_courses tc ON st.teacher_course_id = tc.id
    INNER JOIN students s ON st.student_id = s.id
    WHERE
        s.id = ? AND tc.id = ? GROUP BY s.id
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
            				<th>Alumno</th>
            				<th>Ver Notas</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php 
                      if($row > 0){
                          while($data = $query->fetch()){
                      ?>
                      <tr>
                      	<td><?= $data['nameStudent'] ?></td>
                      	<td>
                      		<a class="btn btn-primary btn-sm" title="Ver Notas" href="list_marks.php?student=<?= $data['idStudent'] ?>&course=<?= $data['idTeacherCourse'] ?>">
                      			<i class="fas fa-list"></i>
                      		</a>
                      	</td>
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
    <a href="index.php" class="btn btn-info">Volver Atras</a>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>