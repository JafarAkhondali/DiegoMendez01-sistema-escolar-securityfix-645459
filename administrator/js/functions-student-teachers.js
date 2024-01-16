$('#tablestudentteacher').DataTable();

var tablestudentteacher;

document.addEventListener('DOMContentLoaded', function(){
	tablestudentteacher = $('#tablestudentteacher').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": "./models/studentTeachers/table_student_teachers.php",
			"dataSrc": "",
		},
		"columns": [
			{"data": "acciones"},
			{"data": "id"},
			{"data": "nameStudent"},
			{"data": "nameTeacher"},
			{"data": "nameDegree"},
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
	
	var formStudentTeacher = document.querySelector('#formStudentTeacher');
	formStudentTeacher.onsubmit = function(e){
		e.preventDefault();
		
		var id            	= document.querySelector('#id').value;
		var student_id      = document.querySelector('#student_id').value;
		var teacher_id      = document.querySelector('#teacher_course_id').value;
		var period_id       = document.querySelector('#period_id').value;
		var is_active     	= document.querySelector('#is_active').value;
		
		if(student_id == '' || teacher_id == '' || period_id == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
		
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		var url     = './models/studentTeachers/ajax_student_teachers.php';
		var form    = new FormData(formStudentTeacher);
		
		request.open('POST', url, true);
		request.send(form);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var data = JSON.parse(request.responseText);
				if(data.status){
					$('#modalStudentTeacher').modal('hide');
					Swal.fire('Proceso', data.msg, 'success');
					formStudentTeacher.reset();
					tablestudentteacher.ajax.reload();
				}else{
					Swal.fire('Atencion', data.msg, 'error');
				}
			}
		}
	}
});

function openModalStudentTeacher()
{
	document.querySelector('#id').value = '';
	document.querySelector('#tituloModal').innerHTML = 'Nuevo Proceso Alumno';
	document.querySelector('#action').innerHTML = 'Guardar';
	document.querySelector('#formStudentTeacher').reset();
	$('#modalStudentTeacher').modal('show');
}

window.addEventListener('load', function(){
	showTeacherCourse();
	showStudent();
	showPeriod();
}, false);

function showTeacherCourse()
{
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/options/option_teacher_courses.php';
	
	request.open('POST', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			data.forEach(function(valor){
				data += '<option value="'+valor.id+'">Profesor: '+valor.nameTeacher+', Grado: '+valor.nameDegree+', Aula: '+valor.nameClassroom+', Materia: '+valor.nameCourse+'</option>';
			});
			document.querySelector('#teacher_course_id').innerHTML = data;
		}
	}
}

function showStudent()
{
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
	var url     = './models/options/option_students.php';
	
	request.open('POST', url, true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var data = JSON.parse(request.responseText);
			data.forEach(function(valor){
				data += '<option value="'+valor.id+'">'+valor.name+'</option>';
			});
			document.querySelector('#student_id').innerHTML = data;
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
/*
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
}*/