$('#tableactivities').DataTable();

var tableactivities;

document.addEventListener('DOMContentLoaded', function(){
	tableactivities = $('#tableactivities').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": "./models/activities/table_activities.php",
			"dataSrc": "",
		},
		"columns": [
			{"data": "acciones"},
			{"data": "id"},
			{"data": "name"},
			{"data": "created"},
			{"data": "is_active"}
		],
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]]
	});
	
	var formActivity = document.querySelector('#formActivity');
	formActivity.onsubmit = function(e){
		e.preventDefault();
		
		var id            	= document.querySelector('#id').value;
		var name          	= document.querySelector('#name').value;
		var is_active     	= document.querySelector('#is_active').value;
		
		if(name == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/activities/ajax_activities.php';
		var form    = new FormData(formActivity);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					$('#modalActivity').modal('hide');
					Swal.fire('Aula', data.msg, 'success');
					formActivity.reset();
					tableactivities.ajax.reload();
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
});

function openModalActivity()
{
	document.querySelector('#id').value = '';
	document.querySelector('#tituloModal').innerHTML = 'Nueva Actividad';
	document.querySelector('#action').innerHTML = 'Guardar';
	document.querySelector('#formActivity').reset();
	$('#modalActivity').modal('show');
}

function editActivity(id)
{
	var idActivity = id;
	
	document.querySelector('#tituloModal').innerHTML = 'Actualizar Materia';
	document.querySelector('#action').innerHTML = 'Actualizar';
	
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/activities/edit_activities.php?id='+idActivity;
	
	request.open('GET', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			if(data.status){
				document.querySelector('#id').value = data.data.id;
				document.querySelector('#name').value = data.data.name;
				document.querySelector('#is_active').value = data.data.is_active;
				
				$('#modalActivity').modal('show');
			}else{
				Swal.fire('Atencion', data.msg, 'error');
			}
		}
	}
}

function deleteActivity(id)
{
	var idActivity = id;
	
	Swal.fire({
		title: "Eliminar Actividad",
		text: "¿Realmente desea eliminar la actividad?",
		showDenyButton: true,
		confirmButtonText: "Si, eliminar",
		denyButtonText: `No, cancelar`
	}).then((result) => {
		if(result.isConfirmed){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var url = './models/activities/delete_activities.php';
			
			request.open('POST', url, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Configurar los encabezados antes de enviar
			var strData = "id=" + idActivity;
			request.send(strData);
			request.onreadystatechange = function () {
			    if (request.readyState == 4 && request.status == 200) {
			        var data = JSON.parse(request.responseText);
			        if (data.status) {
			            Swal.fire('Eliminar', data.msg, 'success');
			            tableactivities.ajax.reload();
			        } else {
			            Swal.fire('Atencion', data.msg, 'error');
			        }
			    }
			};
		}
	});
}