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
			{"data": "nameTeacher"},
			{"data": "nameDegree"},
			{"data": "nameClassroom"},
			{"data": "nameCourse"},
			{"data": "namePeriod"},
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

window.addEventListener('load', function(){
	showTeacher();
	showDegree();
	showClassroom();
	showCourse();
	showPeriod();
}, false);

function showTeacher()
{
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/options/option_teachers.php';
	
	request.open('POST', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			data.forEach(function(valor){
				data += '<option value="'+valor.id+'">'+valor.name+'</option>';
			});
			document.querySelector('#teacher_id').innerHTML = data;
		}
	}
}

function showDegree()
{
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/options/option_degrees.php';
	
	request.open('POST', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			data.forEach(function(valor){
				data += '<option value="'+valor.id+'">'+valor.name+'</option>';
			});
			document.querySelector('#degree_id').innerHTML = data;
		}
	}
}

function showClassroom()
{
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/options/option_classrooms.php';
	
	request.open('POST', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			data.forEach(function(valor){
				data += '<option value="'+valor.id+'">'+valor.name+'</option>';
			});
			document.querySelector('#classroom_id').innerHTML = data;
		}
	}
}

function showCourse()
{
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/options/option_courses.php';
	
	request.open('POST', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			data.forEach(function(valor){
				data += '<option value="'+valor.id+'">'+valor.name+'</option>';
			});
			document.querySelector('#course_id').innerHTML = data;
		}
	}
}

function showPeriod()
{
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/options/option_periods.php';
	
	request.open('POST', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			data.forEach(function(valor){
				data += '<option value="'+valor.id+'">'+valor.name+'</option>';
			});
			document.querySelector('#period_id').innerHTML = data;
		}
	}
}


function editTeacherCourse(id)
{
	var idTeacherCourse = id;
	
	document.querySelector('#tituloModal').innerHTML = 'Actualizar Profesor Materia';
	document.querySelector('#action').innerHTML = 'Actualizar';
	
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/teacherCourses/edit_teacher_courses.php?id='+idTeacherCourse;
	
	request.open('GET', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			if(data.status){
				document.querySelector('#id').value = data.data.id;
				document.querySelector('#teacher_id').value = data.data.teacher_id;
				document.querySelector('#degree_id').value = data.data.degree_id;
				document.querySelector('#classroom_id').value = data.data.classroom_id;
				document.querySelector('#course_id').value = data.data.course_id;
				document.querySelector('#period_id').value = data.data.period_id;
				document.querySelector('#is_active').value = data.data.is_active;
				
				$('#modalTeacherCourse').modal('show');
			}else{
				Swal.fire('Atencion', data.msg, 'error');
			}
		}
	}
}

function deleteTeacherCourse(id)
{
	var idTeacherCourse = id;
	
	Swal.fire({
		title: "Eliminar Profesor Materia",
		text: "¿Realmente desea eliminar el proceso?",
		showDenyButton: true,
		confirmButtonText: "Si, eliminar",
		denyButtonText: `No, cancelar`
	}).then((result) => {
		if(result.isConfirmed){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var url = './models/teacherCourses/delete_teacher_courses.php';
			
			request.open('POST', url, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Configurar los encabezados antes de enviar
			var strData = "id=" + idTeacherCourse;
			request.send(strData);
			request.onreadystatechange = function () {
			    if (request.readyState == 4 && request.status == 200) {
			        var data = JSON.parse(request.responseText);
			        if (data.status) {
			            Swal.fire('Eliminar', data.msg, 'success');
			            tableteachercourses.ajax.reload();
			        } else {
			            Swal.fire('Atencion', data.msg, 'error');
			        }
			    }
			};
		}
	});
}