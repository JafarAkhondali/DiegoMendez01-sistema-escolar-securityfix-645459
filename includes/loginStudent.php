<?php 
session_start();
if(!empty($_POST)){
    if(empty($_POST['identification']) OR empty($_POST['password'])){
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">X</button>Todos los campos
        son necesarios</div>';
    }else{
        require_once 'connection.php';
        $identification = $_POST['identification'];
        $password       = $_POST['password'];
        
        $sql = '
            SELECT
                *
            FROM
                students
            WHERE
                identification = ?
        ';
        
        $query = $pdo->prepare($sql);
        $query->execute([$identification]);
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($query->rowCount() > 0){
            if(password_verify($password, $result['password'])){
                $_SESSION['is_student']        = true;
                $_SESSION['is_active']         = $result['is_active'];
                $_SESSION['id']                = $result['id'];
                $_SESSION['name']              = $result['name'];
                $_SESSION['identification']    = $result['identification'];
                
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