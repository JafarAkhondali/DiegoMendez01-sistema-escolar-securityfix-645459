<!--  MODAL CONTENIDOS  -->
<div class="modal fade" id="modalMark" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tituloModal">Cargar Nota</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formMark" name="formMark" enctype="multipart/form-data">
					<input type="hidden" name="idSubmittedAssessment" id="idSubmittedAssessment" value="<?= $submittedAssessment; ?>" />
					<div class="form-group">
						<label for="control-label" class="col-form-label">Nota:</label>
						<input type="number" class="form-control" id="mark_value" name="mark_value" />
					</div>
					<div class="form-group">
						<label for="control-label">Nota.</label>
						<p>Los cambios no podrán ser editados</p>
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