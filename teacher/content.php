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
        *
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
        
      </div>
    </div>
    <?php 
      }
  }
  ?>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>