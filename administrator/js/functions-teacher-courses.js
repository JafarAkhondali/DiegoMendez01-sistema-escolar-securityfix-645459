$('#tableteachercourses').DataTable();

var tableteachercourses;

document.addEventListener('DOMContentLoaded', function(){
	tableteachercourses = $('#tableteachercourses').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": "./models/teacherCourses/table_teacher_courses.php",
			"dataSrc": "",
		},
		"columns": [
			{"data": "acciones"},
			{"data": "id"},
			{"data": "teacher_id"},
			{"data": "degree_id"},
			{"data": "classroom_id"},
			{"data": "course_id"},
			{"data": "period_id"},
			{"data": "is_active"}
		],
		"dom": "lBfrtip",
	    "buttons": [
	        {
	            "extend": "copyHtml5",
	            "text": "<i class='far fa-copy'></i> Copiar",
	            "titleAttr": "Copiar",
	            "className": "btn btn-secondary"
	        },
	        {
	            "extend": "excelHtml5",
	            "text": "<i class='fas fa-file-excel'></i> Excel",
	            "titleAttr": "Exportar a Excel",
	            "className": "btn btn-success"
	        },
	        {
	            "extend": "pdfHtml5",
	            "text": "<i class='fas fa-pdf'></i> PDF",
	            "titleAttr": "Exportar a PDF",
	            "className": "btn btn-danger",
	            "exportOptions": {
	                 "columns": [1, 2, 3, 4, 5, 6, 7]
	           }
	        },
	        {
	            "extend": "csvHtml5",
	            "text": "<i class='fas fa-csv'></i> CSV",
	            "titleAttr": "Exportar a CSV",
	            "className": "btn btn-info"
			}
	    ],
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]]
	});
	
	var formTeacherCourse = document.querySelector('#formTeacherCourse');
	formTeacherCourse.onsubmit = function(e){
		e.preventDefault();
		
		var id            	= document.querySelector('#id').value;
		var teacher_id      = document.querySelector('#teacher_id').value;
		var degree_id       = document.querySelector('#degree_id').value;
		var classroom_id 	= document.querySelector('#classroom_id').value;
		var course_id 	    = document.querySelector('#course_id').value;
		var period_id       = document.querySelector('#period_id').value;
		var is_active     	= document.querySelector('#is_active').value;
		
		if(teacher_id == '' || degree_id == '' || classroom_id == '' || course_id == '' || period_id == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/teacherCourses/ajax_teacher_courses.php';
		var form    = new FormData(formTeacherCourse);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					$('#modalTeacherCourse').modal('hide');
					Swal.fire('Proceso', data.msg, 'success');
					formTeacherCourse.reset();
					tableteachercourses.ajax.reload();
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
});

function openModalTeacherCourse()
{
	document.querySelector('#id').value = '';
	document.querySelector('#tituloModal').innerHTML = 'Nuevo Proceso';
	document.querySelector('#action').innerHTML = 'Guardar';
	document.querySelector('#formTeacherCourse').reset();
	$('#modalTeacherCourse').modal('show');
}
/*
function editTeacher(id)
{
	var idTeacher = id;
	
	document.querySelector('#tituloModal').innerHTML = 'Actualizar Profesor';
	document.querySelector('#action').innerHTML = 'Actualizar';
	
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/teachers/edit_teachers.php?id='+idTeacher;
	
	request.open('GET', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			if(data.status){
				document.querySelector('#id').value = data.data.id;
				document.querySelector('#name').value = data.data.name;
				document.querySelector('#address').value = data.data.address;
				document.querySelector('#identification').value = data.data.identification;
				document.querySelector('#phone').value = data.data.phone;
				document.querySelector('#email').value = data.data.email;
				document.querySelector('#level').value = data.data.level;
				document.querySelector('#is_active').value = data.data.is_active;
				
				$('#modalTeacher').modal('show');
			}else{
				Swal.fire('Atencion', data.msg, 'error');
			}
		}
	}
}

function deleteTeacher(id)
{
	var idTeacher = id;
	
	Swal.fire({
		title: "Eliminar Profesor",
		text: "¿Realmente desea eliminar el profesor?",
		showDenyButton: true,
		confirmButtonText: "Si, eliminar",
		denyButtonText: `No, cancelar`
	}).then((result) => {
		if(result.isConfirmed){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var url = './models/teachers/delete_teachers.php';
			
			request.open('POST', url, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Configurar los encabezados antes de enviar
			var strData = "id=" + idTeacher;
			request.send(strData);
			request.onreadystatechange = function () {
			    if (request.readyState == 4 && request.status == 200) {
			        var data = JSON.parse(request.responseText);
			        if (data.status) {
			            Swal.fire('Eliminar', data.msg, 'success');
			            tableteachers.ajax.reload();
			        } else {
			            Swal.fire('Atencion', data.msg, 'error');
			        }
			    }
			};
		}
	});
}*/