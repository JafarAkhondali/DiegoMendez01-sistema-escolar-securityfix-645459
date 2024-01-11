<?php 

if(!empty($_POST)){
    if(empty($_POST['user']) OR empty($_POST['password_hash'])){
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">X</button>Todos los campos
        son necesarios</div>';
    }else{
        require_once 'connection.php';
        $user     = $_POST['user'];
        $password = $_POST['password_hash'];
        
        $sql = '
            SELECT
                u.*,
                r.name as nameRol
            FROM
                users as u
            INNER JOIN roles as r ON u.role_id = r.id
            WHERE
                user = ?
        ';
        
        $query = $pdo->prepare($sql);
        $query->execute([$user]);
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($query->rowCount() > 0){
            if(password_verify($password, $result['password_hash'])){
                
                $_SESSION['is_active'] = $result['is_active'];
                $_SESSION['id']        = $result['id'];
                $_SESSION['name']      = $result['name'];
                $_SESSION['role_id']   = $result['role_id'];
                $_SESSION['role']      = $result['nameRol'];
                
                echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>Redirecting</div>';
            }else{
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">X</button>Usuario y/o Clave incorrectos</div>';
            }
        }else{
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">X</button>Usuario y/o Clave incorrectos</div>';
        }
    }
}

?>