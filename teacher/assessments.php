<?php 
if(!empty($_GET['course']) AND !empty($_GET['content'])){
    $courseId  = $_GET['course'];
    $contentId = $_GET['content'];
}else{
    header("Location: teacher/");
}
require_once 'includes/header.php';
require_once '../includes/connection.php';
require_once 'includes/modals/modal_assessment.php';

//ID del profesor
$id = $_SESSION['id'];

$sql = '
    SELECT
        tc.id as idTeacher,
        a.id,
        c.id as idContent,
        DATE_FORMAT(a.date, "%d/%m/%Y") as date,
        a.percentage,
        a.description,
        a.title
    FROM
        assessments as a
    INNER JOIN contents c ON a.content_id = c.id
    INNER JOIN teacher_courses tc ON c.teacher_course_id = tc.id 
    WHERE
        a.content_id = ?
';

$query = $pdo->prepare($sql);
$query->execute([$contentId]);
$row = $query->rowCount();

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i>Asignar Evaluacion</h1>
      <button class="btn btn-success" type="button" onclick="openModalAssessment()">Nueva Evaluacion</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Asignar evaluacion</a></li>
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
          <div class="btn-group">
               <p>
                  <button class="btn btn-info icon-btn" onclick="editAssessment(<?= $data['id']; ?>)">
                       <i class="fas fa-edit"></i>Editar
                  </button>
                  <button class="btn btn-danger icon-btn" onclick="deleteAssessment(<?= $data['id']; ?>)">
                       <i class="fas fa-delet"></i>Eliminar
                  </button>
                  <a class="btn btn-warning icon-btn" href="submittedAssessments.php?course=<?= $data['idTeacher']; ?>&content=<?= $data['idContent']; ?>&assessment=<?= $data['id'] ?>">
                       <i class="fas fa-edit"></i>Ver Entregas
                  </a>
               </p>
          </div>
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
  <div class="row">
    <a href="contents.php?course=<?= $courseId ?>" class="btn btn-info">Volver Atras</a>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>