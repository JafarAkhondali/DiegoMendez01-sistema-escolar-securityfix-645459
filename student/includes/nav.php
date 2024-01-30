<?php 

require_once '../includes/connection.php';

session_start();
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

<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
    <div>
      <p class="app-sidebar__user-name"><?php echo $_SESSION['name']; ?></p>
      <p class="app-sidebar__user-designation">Alumno</p>
    </div>
  </div>
  <ul class="app-menu">
    <li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fas fa-home"></i><span class="app-menu__label">Inicio</span></a></li>
    <li class="treeview">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fas fa-laptop"></i>
          <span class="app-menu__label">Mis Cursos</span>
        <i class="treeview-indicator bi bi-chevron-right"></i>
      </a>
      <ul class="treeview-menu">
      <?php 
      if($row > 0){
          while($data = $query->fetch()){
              ?>
              <li><a class="treeview-item" href="contents.php?course=<?= $data['id'] ?>"><i class="icon fas fa-circle"></i>
              <?= $data['nameCourse']; ?> - <?= $data['nameDegree']; ?> - <?= $data['nameClassroom'] ?></a></li>
              <?php
          }
      }
      ?>
      </ul>
    </li>
    <li class="treeview">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fas fa-laptop"></i>
          <span class="app-menu__label">Mis Calificaciones</span>
        <i class="treeview-indicator bi bi-chevron-right"></i>
      </a>
      <ul class="treeview-menu">
      <?php 
      if($rowMark > 0){
          while($dataMark = $queryMark->fetch()){
              ?>
              <li><a class="treeview-item" href="marks.php?course=<?= $dataMark['id'] ?>"><i class="icon fas fa-circle"></i>
              <?= $dataMark['nameCourse']; ?> - <?= $dataMark['nameDegree']; ?> - <?= $dataMark['nameClassroom'] ?></a></li>
              <?php
          }
      }
      ?>
      </ul>
    </li>
    <li><a class="app-menu__item" href="../logout.php"><i class="app-menu__icon fas fa-sign-out-alt"></i><span
    class="app-menu__label">Logout</span></a></li>
  </ul>
</aside>