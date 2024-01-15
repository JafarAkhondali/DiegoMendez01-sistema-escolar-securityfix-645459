$('#tableperiods').DataTable();

var tableperiods;

document.addEventListener('DOMContentLoaded', function(){
	tableperiods = $('#tableperiods').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": "./models/periods/table_periods.php",
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
	
	var formPeriod = document.querySelector('#formPeriod');
	formPeriod.onsubmit = function(e){
		e.preventDefault();
		
		var id            	= document.querySelector('#id').value;
		var name          	= document.querySelector('#name').value;
		var is_active     	= document.querySelector('#is_active').value;
		
		if(name == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/periods/ajax_periods.php';
		var form    = new FormData(formPeriod);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					$('#modalPeriod').modal('hide');
					Swal.fire('Periodo', data.msg, 'success');
					formPeriod.reset();
					tableperiods.ajax.reload();
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
});

function openModalPeriod()
{
	document.querySelector('#id').value = '';
	document.querySelector('#tituloModal').innerHTML = 'Nueva Periodo';
	document.querySelector('#action').innerHTML = 'Guardar';
	document.querySelector('#formPeriod').reset();
	$('#modalPeriod').modal('show');
}

function editPeriod(id)
{
	var idPeriod = id;
	
	document.querySelector('#tituloModal').innerHTML = 'Actualizar Periodo';
	document.querySelector('#action').innerHTML = 'Actualizar';
	
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/periods/edit_periods.php?id='+idPeriod;
	
	request.open('GET', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			if(data.status){
				document.querySelector('#id').value = data.data.id;
				document.querySelector('#name').value = data.data.name;
				document.querySelector('#is_active').value = data.data.is_active;
				
				$('#modalPeriod').modal('show');
			}else{
				Swal.fire('Atencion', data.msg, 'error');
			}
		}
	}
}

function deletePeriod(id)
{
	var idPeriod = id;
	
	Swal.fire({
		title: "Eliminar Periodo",
		text: "¿Realmente desea eliminar el periodo?",
		showDenyButton: true,
		confirmButtonText: "Si, eliminar",
		denyButtonText: `No, cancelar`
	}).then((result) => {
		if(result.isConfirmed){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var url = './models/periods/delete_periods.php';
			
			request.open('POST', url, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Configurar los encabezados antes de enviar
			var strData = "id=" + idPeriod;
			request.send(strData);
			request.onreadystatechange = function () {
			    if (request.readyState == 4 && request.status == 200) {
			        var data = JSON.parse(request.responseText);
			        if (data.status) {
			            Swal.fire('Eliminar', data.msg, 'success');
			            tableperiods.ajax.reload();
			        } else {
			            Swal.fire('Atencion', data.msg, 'error');
			        }
			    }
			};
		}
	});
}