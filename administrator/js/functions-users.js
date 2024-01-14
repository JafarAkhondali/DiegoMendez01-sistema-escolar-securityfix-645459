$('#tableusers').DataTable();

var tableusers;

document.addEventListener('DOMContentLoaded', function(){
	tableusers = $('#tableusers').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax": {
			"url": "./models/users/table_users.php",
			"dataSrc": ""
		},
		"columns": [
			{"data": "acciones"},
			{"data": "id"},
			{"data": "name"},
			{"data": "user"},
			{"data": "nameRol"},
			{"data": "is_active"},
			{"data": "created"}
		],
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]]
	});
	
	var formUser = document.querySelector('#formUser');
	formUser.onsubmit = function(e){
		e.preventDefault();
		
		var name          = document.querySelector('#name').value;
		var user          = document.querySelector('#user').value;
		var password_hash = document.querySelector('#password_hash').value;
		var role_id       = document.querySelector('#role_id').value;
		var is_active     = document.querySelector('#is_active').value;
		
		if(name == '' || user == '' || password_hash == ''){
			Swal.fire('Atencion', 'Todos los campos son necesarios', 'error');
			return false;
		}
	}
});

function openModal()
{
	$('#modalUser').modal('show');
}