$(document).ready(function(){
	$('#loginUser').on('click', function(){
		loginUser();
	});
	$('#loginTeacher').on('click', function(){
		loginTeacher();
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
	var login = $('#user').val();
	var pass  = $('#password_hash').val();
	
	$.ajax({
		url: './includes/loginTeacher.php',
		method: 'POST',
		data: {
			user : login,
			password_hash : pass
		},
		success: function(data){
			$('#messageTeacher').html(data);
			if(data.indexOf('Redirecting') >= 0){
				window.location = 'teacher/';
			}
		}
	});
}