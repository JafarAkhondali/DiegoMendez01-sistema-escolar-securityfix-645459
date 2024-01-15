$('#tableteachers').DataTable();

var tableteachers;

document.addEventListener('DOMContentLoaded', function(){
	tableteachers = $('#tableteachers').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": "./models/teachers/table_teachers.php",
			"dataSrc": "",
		},
		"columns": [
			{"data": "acciones"},
			{"data": "id"},
			{"data": "name"},
			{"data": "address"},
			{"data": "identification"},
			{"data": "phone"},
			{"data": "email"},
			{"data": "level"},
			{"data": "is_active"}
		],
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]]
	});
	
	var formTeacher = document.querySelector('#formTeacher');
	formTeacher.onsubmit = function(e){
		e.preventDefault();
		
		var id            	= document.querySelector('#id').value;
		var name          	= document.querySelector('#name').value;
		var address       	= document.querySelector('#address').value;
		var identification 	= document.querySelector('#identification').value;
		var password 	    = document.querySelector('#password').value;
		var phone       	= document.querySelector('#phone').value;
		var email       	= document.querySelector('#email').value;
		var level       	= document.querySelector('#level').value;
		var is_active     	= document.querySelector('#is_active').value;
		
		if(name == '' || address == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/users/ajax_teachers.php';
		var form    = new FormData(formTeacher);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					$('#modalTeacher').modal('hide');
					Swal.fire('Profesor', data.msg, 'success');
					formTeacher.reset();
					tableteachers.ajax.reload();
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
});

function openModal()
{
	document.querySelector('#id').value = '';
	document.querySelector('#tituloModal').innerHTML = 'Nuevo Profesor';
	document.querySelector('#action').innerHTML = 'Guardar';
	document.querySelector('#formTeacher').reset();
	$('#modalTeacher').modal('show');
}
/*
function editUser(id)
{
	var idUser = id;
	
	document.querySelector('#tituloModal').innerHTML = 'Actualizar Usuario';
	document.querySelector('#action').innerHTML = 'Actualizar';
	
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/users/edit_users.php?id='+idUser;
	
	request.open('GET', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			if(data.status){
				document.querySelector('#id').value = data.data.id;
				document.querySelector('#name').value = data.data.name;
				document.querySelector('#user').value = data.data.user;
				document.querySelector('#role_id').value = data.data.role_id;
				document.querySelector('#is_active').value = data.data.is_active;
				
				$('#modalUser').modal('show');
			}else{
				Swal.fire('Atencion', data.msg, 'error');
			}
		}
	}
}

function deleteUser(id)
{
	var idUser = id;
	
	Swal.fire({
		title: "Eliminar Usuario",
		text: "¿Realmente desea eliminar el usuario?",
		showDenyButton: true,
		confirmButtonText: "Si, eliminar",
		denyButtonText: `No, cancelar`
	}).then((result) => {
		if(result.isConfirmed){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var url = './models/users/delet_users.php';
			
			request.open('POST', url, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Configurar los encabezados antes de enviar
			var strData = "id=" + idUser;
			request.send(strData);
			request.onreadystatechange = function () {
			    if (request.readyState == 4 && request.status == 200) {
			        var data = JSON.parse(request.responseText);
			        if (data.status) {
			            Swal.fire('Eliminar', data.msg, 'success');
			            tableusers.ajax.reload();
			        } else {
			            Swal.fire('Atencion', data.msg, 'error');
			        }
			    }
			};
		}
	});
}*/