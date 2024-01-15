<?php 

require_once 'includes/header.php';
require_once 'includes/modals/modal_period.php';

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i> Lista de Periodos</h1>
      <button class="btn btn-success" type="button" onclick="openModalPeriod()">Nuevo Periodo</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="#">lista de periodos</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tableperiods">
              <thead>
                <tr>
                  <th>Acciones</th>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Creado</th>
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