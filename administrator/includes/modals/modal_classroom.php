<!--  MODAL AULAS  -->
<div class="modal fade" id="modalClassroom" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tituloModal">Nueva Aula</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formClassroom" name="formClassroom">
					<input type="hidden" name="id" id="id" value="" />
					<div class="form-group">
						<label for="control-label" class="col-form-label">Nombre:</label>
						<input type="text" class="form-control" id="name" name="name" />
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