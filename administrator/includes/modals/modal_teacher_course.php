<!--  MODAL PROFESORES MATERIAS  -->
<div class="modal fade" id="modalTeacherCourse" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tituloModal">Nuevo Proceso</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formTeacherCourse" name="formTeacherCourse">
					<input type="hidden" name="id" id="id" value="" />
					<div class="form-group">
						<label for="teacher_id" class="col-form-label">Seleccionar Profesor:</label>
						<select class="form-control" name="teacher_id" id="teacher_id">
							<!-- Contenido AJAX  -->
						</select>
					</div>
					<div class="form-group">
						<label for="degree_id" class="col-form-label">Seleccionar Grado:</label>
						<select class="form-control" name="degree_id" id="degree_id">
							<!-- Contenido AJAX  -->
						</select>
					</div>
					<div class="form-group">
						<label for="classroom_id" class="col-form-label">Seleccionar Aula:</label>
						<select class="form-control" name="classroom_id" id="classroom_id">
							<!-- Contenido AJAX  -->
						</select>
					</div>
					<div class="form-group">
						<label for="course_id" class="col-form-label">Seleccionar Materia:</label>
						<select class="form-control" name="course_id" id="course_id">
							<!-- Contenido AJAX  -->
						</select>
					</div>
					<div class="form-group">
						<label for="period_id" class="col-form-label">Seleccionar Periodo:</label>
						<select class="form-control" name="period_id" id="period_id">
							<!-- Contenido AJAX  -->
						</select>
					</div>
					<div class="form-group">
						<label for="is_active" class="col-form-label">Estado:</label>
						<select class="form-control" name="is_active" id="is_active">
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					<div class="modal-footer">
        				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        				<button type="submit" id="action" class="btn btn-primary">Guardar</button>
        			</div>
				</form>
			</div>
		</div>
	</div>
</div>