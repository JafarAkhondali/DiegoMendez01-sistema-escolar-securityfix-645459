<?php 
if(!empty($_GET['course'])){
    $courseId = $_GET['course'];
}else{
    header("Location: student/");
}
require_once 'includes/header.php';
require_once '../includes/connection.php';
require_once '../includes/functions.php';

$idStudent = $_SESSION['id'];

$sql = '
    SELECT
        c.id,
        c.title,
        c.material,
        c.description,
        tc.id as idTeacherCourse
    FROM
        contents as c
    INNER JOIN teacher_courses tc ON c.teacher_course_id = tc.id
    WHERE
        tc.id = ? AND c.is_active = 1
';

$query = $pdo->prepare($sql);
$query->execute([$courseId]);
$row = $query->rowCount();

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i>Contenidos a Evaluar</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">Contenidos a Evaluar</a></li>
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
                  <a class="btn btn-warning icon-btn" href="assessments.php?course=<?= $data['idTeacherCourse']; ?>&content=<?= $data['id']; ?>">
                       <i class="fas fa-edit"></i>Ver Evaluacion
                  </a>
               </p>
          </div>
        </div>
        <div class="title-body">
          <b><?= $data['description']; ?></b>
        </div>
        <div class="title-footer mt-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text" style="height: 36px;"><i class="fas fa-download"></i></div>
            </div>
            <a class="btn btn-primary" href="BASE_URL<?= $data['material']; ?>" target="_blank">Material de Descarga</a>
          </div>
        </div>
      </div>
    </div>
    <?php 
      }
  }
  ?>
  </div>
  <div class="row">
    <a href="index.php" class="btn btn-info">Volver Atras</a>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>