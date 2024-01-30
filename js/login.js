$(document).ready(function(){
	$('#loginUser').on('click', function(){
		loginUser();
	});
	$('#loginTeacher').on('click', function(){
		loginTeacher();
	});
	$('#loginStudent').on('click', function(){
		loginStudent();
	});
});

function loginUser()
{
	var login = $('#user').val();
	var pass  = $('#password_hash').val();
	
	$.ajax({
		url: './includes/loginUser.php',
		method: 'POST',
		data: {
			user : login,
			password_hash : pass
		},
		success: function(data){
			$('#messageUser').html(data);
			if(data.indexOf('Redirecting') >= 0){
				window.location = 'administrator/';
			}
		}
	});
}

function loginTeacher()
{
	var login = $('#identification').val();
	var pass  = $('#password').val();
	
	$.ajax({
		url: './includes/loginTeacher.php',
		method: 'POST',
		data: {
			identification : login,
			password : pass
		},
		success: function(data){
			$('#messageTeacher').html(data);
			if(data.indexOf('Redirecting') >= 0){
				window.location = 'teacher/';
			}
		}
	});
}

function loginStudent()
{
	var login = $('#identificationStudent').val();
	var pass  = $('#passwordStudent').val();
	
	$.ajax({
		url: './includes/loginStudent.php',
		method: 'POST',
		data: {
			identification : login,
			password : pass
		},
		success: function(data){
			$('#messageStudent').html(data);
			if(data.indexOf('Redirecting') >= 0){
				window.location = 'student/';
			}
		}
	});
}