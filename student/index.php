<?php 

require_once 'includes/header.php';
require_once '../includes/connection.php';

// ID estudiante
$idStudent = $_SESSION['id'];

$sql = '
    SELECT
        tc.id,
        c.name as nameCourse,
        d.name as nameDegree,
        cs.name as nameClassroom
    FROM
        student_teachers as st
    INNER JOIN students s ON st.student_id = s.id
    INNER JOIN teacher_courses tc ON st.teacher_course_id = tc.id
    INNER JOIN degrees d ON tc.degree_id = d.id
    INNER JOIN teachers t ON tc.teacher_id = t.id
    INNER JOIN courses c ON tc.course_id = c.id
    INNER JOIN classrooms cs ON tc.classroom_id = cs.id
    WHERE
        s.id = ? AND st.is_active = 1
';

$query = $pdo->prepare($sql);
$query->execute([$idStudent]);
$row   = $query->rowCount();

?>
<main class="app-content">
  <div class="row">
    <div class="col-md-12 border-shadow p-2 bg-info text-white">
      <h3>Sistema Escolar - COLPAZ</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center border mt-3 p-4 bg-light">
      <h3>Mis Cursos</h3>
    </div>
  </div>
  <div class="row">
    <?php 
    if($row > 0){
        while($data = $query->fetch()){
        ?>
        <div class="col-md-4 text-center border mt-3 p-4 bg-light">
             <div class="card m-2 shadow" style="width: 23rem;">
                  <img src="images/card-school.svg" class="card-img-top" alt="..." style="height: 13rem;"/>
                  <div class="card-body">
                       <h4 class="card-title text-center"><?php echo $data['nameCourse']; ?></h4>
                       <h5 class="card-title">Grado <kbd class="bg-info"><?php echo $data['nameDegree']; ?></kbd> - Aula <kbd class="bg-info"><?php echo $data['nameClassroom']; ?></kbd></h5>
                       <a href="contents.php?course=<?= $data['id'] ?>" class="btn btn-primary">Acceder</a>
                  </div>
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