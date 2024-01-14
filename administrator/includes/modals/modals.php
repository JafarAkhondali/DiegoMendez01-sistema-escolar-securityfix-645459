<!--  MODAL USUARIOS  -->
<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tituloModal">Nuevo Usuario</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formUser" name="formUser">
					<div class="form-group">
						<label for="control-label" class="col-form-label">Nombre:</label>
						<input type="text" class="form-control" id="name" name="name" />
					</div>
					<div class="form-group">
						<label for="control-label" class="col-form-label">Usuario:</label>
						<input type="text" class="form-control" id="user" name="user" />
					</div>
					<div class="form-group">
						<label for="control-label" class="col-form-label">Clave:</label>
						<input type="password" class="form-control" id="password_hash" name="password_hash" />
					</div>
					<div class="form-group">
						<label for="role_id" class="col-form-label">Rol:</label>
						<select class="form-control" name="role_id" id="role_id">
							<option value="">.::Seleccionar::.</option>
							<option value="1">Administrador</option>
							<option value="1">Asistente</option>
						</select>
					</div>
					<div class="form-group">
						<label for="is_active" class="col-form-label">Estado:</label>
						<select class="form-control" name="is_active" id="is_active">
							<option value="">.::Seleccionar::.</option>
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					<div class="modal-footer">
        				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        				<button type="submit" class="btn btn-primary">Guardar</button>
        			</div>
				</form>
			</div>
		</div>
	</div>
</div>