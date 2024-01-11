<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UFT-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<title>Ingreso al Sistema</title>
</head>
<body>
	<header class="main-header">
		<div class="main-cont">
			<div class="desc-header">
				<img src="images/school.svg" alt="Image School" />
				<p>School</p>
			</div>
		</div>
		<div class="cont-header">
			<h1>Bienvenid@</h1>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
					aria-selected="true">Administrador</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher"
					aria-selected="false">Profesor</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    				<form action="" onSubmit="return validar()">
        				<label for="user">Usuario</label>
        				<input type="text" name="user" id="user" placeholder="Nombre de Usuario" />
        				<label for="password_hash">Clave</label>
        				<input type="text" name="password_hash" id="password_hash" placeholder="Clave de Seguridad" />
        				<div id="messageUser"></div>
        				<button id="loginUser" type="button">Iniciar Sesión</button>
        			</form>
				</div>
				<div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
    				<form action="" onSubmit="return validar()">
        				<label for="user">Usuario</label>
        				<input type="text" name="user" id="user" placeholder="Nombre de Usuario" />
        				<label for="password_hash">Clave</label>
        				<input type="text" name="password_hash" id="password_hash" placeholder="Clave de Seguridad" />
        				<div id="messageTeacher"></div>
        				<button id="loginTeacher" type="button">Iniciar Sesión</button>
        			</form>
				</div>
			</div>
		</div>
	</header>
	<script src="js/jquery-3.7.0.min.js"></script>
	<script src="js/login.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>