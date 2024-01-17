<!--  MODAL CONTENIDOS  -->
<div class="modal fade" id="modalContent" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tituloModal">Nueva Contenido</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formContent" name="formContent" enctype="multipart/form-data">
					<input type="hidden" name="id" id="id" value="" />
					<input type="hidden" name="idCourse" id="idCourse" value="<?= $courseId; ?>" />
					<div class="form-group">
						<label for="control-label" class="col-form-label">Titulo:</label>
						<input type="text" class="form-control" id="title" name="title" />
					</div>
					<div class="form-group">
						<label for="control-label" class="col-form-label">Descripcion:</label>
						<textarea id="description" class="form-control" name="description" rows="4"></textarea>
					</div>
					<div class="form-group">
						<label for="control-label" class="col-form-label">Adjuntar Material:</label>
						<input type="file" class="form-control" id="material" name="material" />
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