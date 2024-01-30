document.addEventListener('DOMContentLoaded', function(){
	var formSubmittedAssessment = document.querySelector('#formSubmittedAssessment');
	formSubmittedAssessment.onsubmit = function(e){
		e.preventDefault();
		
		var observation = document.querySelector('#observation').value;
		var file        = document.querySelector('#file').value;
		
		if(observation.trim() === '' || file == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/submittedAssessments/ajax_submittedAssessments.php';
		var form    = new FormData(formSubmittedAssessment);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					Swal.fire({
						title: "Crear Entrega",
						showDenyButton: true,
						confirmButtonText: "Aceptar",
					}).then((result) => {
						if(result.isConfirmed){
							location.reload();
							formSubmittedAssessment.reset();
						}
					});
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
	
});