document.addEventListener('DOMContentLoaded', function(){
	var formMark = document.querySelector('#formMark');
	formMark.onsubmit = function(e){
		e.preventDefault();
		
		var idSubmittedAssesment   = document.querySelector('#idSubmittedAssessment').value;
		var mark_value             = document.querySelector('#mark_value').value;
		
		if (mark_value.trim() === '') {
		    Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
		    return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/marks/ajax_marks.php';
		var form    = new FormData(formMark);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					Swal.fire({
						title: "Crear nota",
						showDenyButton: true,
						confirmButtonText: "Aceptar",
					}).then((result) => {
						if(result.isConfirmed){
							$('#modalMark').modal('hide');
							location.reload();
							formMark.reset();
						}
					});
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
})

function openModalAssessment()
{
	$('#modalMark').modal('show');
}