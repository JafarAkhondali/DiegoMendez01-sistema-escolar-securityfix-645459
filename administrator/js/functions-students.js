$('#tablestudents').DataTable();

var tablestudents;

document.addEventListener('DOMContentLoaded', function(){
	tablestudents = $('#tablestudents').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": "./models/students/table_students.php",
			"dataSrc": "",
		},
		"columns": [
			{"data": "acciones"},
			{"data": "id"},
			{"data": "name"},
			{"data": "age"},
			{"data": "address"},
			{"data": "identification"},
			{"data": "phone"},
			{"data": "email"},
			{"data": "birthdate"},
			{"data": "created"},
			{"data": "is_active"}
		],
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]]
	});
	
	var formStudent = document.querySelector('#formStudent');
	formStudent.onsubmit = function(e){
		e.preventDefault();
		
		var id            	= document.querySelector('#id').value;
		var name          	= document.querySelector('#name').value;
		var age       	    = document.querySelector('#age').value;
		var address       	= document.querySelector('#address').value;
		var identification 	= document.querySelector('#identification').value;
		var password 	    = document.querySelector('#password').value;
		var phone       	= document.querySelector('#phone').value;
		var email       	= document.querySelector('#email').value;
		var birthdate       = document.querySelector('#birthdate').value;
		var is_active     	= document.querySelector('#is_active').value;
		
		if(name == '' || age == '' || address == '' || identification == '' || phone == '' || email == '' || birthdate == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/students/ajax_students.php';
		var form    = new FormData(formStudent);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					$('#modalStudent').modal('hide');
					Swal.fire('Alumno', data.msg, 'success');
					formStudent.reset();
					tablestudents.ajax.reload();
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
});

function openModalStudent()
{
	document.querySelector('#id').value = '';
	document.querySelector('#tituloModal').innerHTML = 'Nuevo Alumno';
	document.querySelector('#action').innerHTML = 'Guardar';
	document.querySelector('#formStudent').reset();
	$('#modalStudent').modal('show');
}

function editStudent(id)
{
	var idTeacher = id;
	
	document.querySelector('#tituloModal').innerHTML = 'Actualizar Alumno';
	document.querySelector('#action').innerHTML = 'Actualizar';
	
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/students/edit_students.php?id='+idTeacher;
	
	request.open('GET', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			if(data.status){
				document.querySelector('#id').value = data.data.id;
				document.querySelector('#name').value = data.data.name;
				document.querySelector('#age').value = data.data.age;
				document.querySelector('#address').value = data.data.address;
				document.querySelector('#identification').value = data.data.identification;
				document.querySelector('#phone').value = data.data.phone;
				document.querySelector('#email').value = data.data.email;
				document.querySelector('#birthdate').value = data.data.birthdate;
				document.querySelector('#is_active').value = data.data.is_active;
				
				$('#modalStudent').modal('show');
			}else{
				Swal.fire('Atencion', data.msg, 'error');
			}
		}
	}
}

function deleteStudent(id)
{
	var idStudent = id;
	
	Swal.fire({
		title: "Eliminar Alumno",
		text: "¿Realmente desea eliminar el alumno?",
		showDenyButton: true,
		confirmButtonText: "Si, eliminar",
		denyButtonText: `No, cancelar`
	}).then((result) => {
		if(result.isConfirmed){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var url = './models/students/delete_students.php';
			
			request.open('POST', url, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Configurar los encabezados antes de enviar
			var strData = "id=" + idStudent;
			request.send(strData);
			request.onreadystatechange = function () {
			    if (request.readyState == 4 && request.status == 200) {
			        var data = JSON.parse(request.responseText);
			        if (data.status) {
			            Swal.fire('Eliminar', data.msg, 'success');
			            tablestudents.ajax.reload();
			        } else {
			            Swal.fire('Atencion', data.msg, 'error');
			        }
			    }
			};
		}
	});
}