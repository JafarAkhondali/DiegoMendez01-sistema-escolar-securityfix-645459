<?php 

require_once 'includes/header.php';
require_once 'includes/modals/modal_student.php';

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i> Lista de Alumnos</h1>
      <button class="btn btn-success" type="button" onclick="openModalStudent()">Nuevo Alumno</button>
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
                  <th>Acciones</th>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Edad</th>
                  <th>Direccion</th>
                  <th>Identificacion</th>
                  <th>Celular</th>
                  <th>Correo Electronico</th>
                  <th>Fecha Nacimiento</th>
                  <th>Registro</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php 

require_once 'includes/footer.php';

?>