<?php 
if(!empty($_GET['course'])){
    $courseId = $_GET['course'];
}else{
    header("Location: teacher/");
}
require_once 'includes/header.php';
require_once '../includes/connection.php';
require_once 'includes/modals/modal_content.php';

$id = $_SESSION['id'];

$sql = '
    SELECT
        c.id,
        c.title,
        tc.id as idTeacherCourse
    FROM
        contents as c
    INNER JOIN teacher_courses tc ON c.teacher_course_id = tc.id
    WHERE
        tc.course_id = ?
';

$query = $pdo->prepare($sql);
$query->execute([$courseId]);
$row = $query->rowCount();

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i>Contenidos a Evaluar</h1>
      <button class="btn btn-success" type="button" onclick="openModalContent()">Nuevo Contenido</button>
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
        <div class="title-title-w-btn">
          <h3 class="title"><?= $data['title']; ?></h3>
          <p><button class="btn btn-info icon-btn" onclick="editContent(<?= $data['id']; ?>)"><i class="fas fa-edit">
          </i>Editar Contenido</button><button class="btn btn-danger icon-btn" onclick="deleteContent(<?= $data['id']; ?>)"><i class="fas fa-delet">
          </i>Eliminar Contenido</button><a class="btn btn-warning icon-btn" href="assessment.php?course=<?= $data['idTeacherCourse']; ?>&content=<?= $data['id']; ?>">
          <i class="fas fa-edit"></i>Asignar Evaluacion</a></p>
        </div>
        <div class="title-body">
          <b><?= $data['description']; ?></b>
        </div>
        <div class="title-footer mt-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-download"></i></div>
            </div>
            <a class="btn btn-primary" href="teacher/teacher/<?= $data['material']; ?>" target="_blank">Material de Descarga</a>
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