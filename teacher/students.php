<?php 
if(!empty($_GET['course'])){
    $courseId  = $_GET['course'];
}else{
    header("Location: ./");
}
require_once 'includes/header.php';
require_once '../includes/connection.php';
require_once 'includes/modals/modal_assessment.php';

//ID del profesor
$id = $_SESSION['id'];

$sql = '
    SELECT
        s.id as idStudent,
        s.name as nameStudent,
        s.identification
    FROM
        student_teachers as st
    INNER JOIN teacher_courses tc ON st.teacher_course_id = tc.id
    INNER JOIN students s ON st.student_id = s.id
    WHERE
        tc.id = ? AND st.is_active = 1
';

$query = $pdo->prepare($sql);
$query->execute([$courseId]);
$row = $query->rowCount();

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i>Lista Alumnos</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">lista de alumnos</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tablestudents">
              <thead>
                <tr>
                  <th>Alumno</th>
                  <th>Cedula</th>
                  <th>Ultimo Acceso</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if($row > 0){
                    while($data = $query->fetch()){
                        $idStudent = $data['idStudent'];
                        $sqlAccess = '
                            SELECT
                                access
                            FROM
                                students
                            WHERE
                                id = ? AND is_active = 1
                        ';
                        
                        $queryAccess = $pdo->prepare($sqlAccess);
                        $queryAccess->execute([$idStudent]);
                        $resultAccess = $queryAccess->fetch(PDO::FETCH_ASSOC);
                ?>
                		<tr>
                			<td><?= $data['nameStudent']; ?></td>
                			<td><?= $data['identification']; ?></td>
                			<td>
                				<?php 
                				if($resultAccess['access'] == null){
                				    echo '<span class="me-1 badge bg-danger"">NUNCA</span>';
                				}else{
                				    echo $resultAccess['access'];
                				}
                				?>
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
    <a href="contents.php?course=<?= $courseId ?>" class="btn btn-info">Volver Atras</a>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>