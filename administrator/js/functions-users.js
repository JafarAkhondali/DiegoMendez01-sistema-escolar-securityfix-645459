$('#tableusers').DataTable();

var tableusers;

document.addEventListener('DOMContentLoaded', function(){
	tableusers = $('#tableusers').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/spanish.json"
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
			{"data": "role_id"},
			{"data": "is_active"},
			{"data": "created"}
		],
		"responsive": true,
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]]
	});
});

function openModal()
{
	$('#modalUser').modal('show');
}