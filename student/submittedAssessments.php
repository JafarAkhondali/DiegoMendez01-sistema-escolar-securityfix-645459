<?php 

if(!empty($_GET['course']) AND !empty($_GET['content'] AND !empty($_GET['assessment']))){
    $courseId     = $_GET['course'];
    $contentId    = $_GET['content'];
    $assessmentId = $_GET['assessment'];
}else{
    header("Location: student/");
}

require_once 'includes/header.php';
require_once '../includes/connection.php';
?>
<?php 

require_once 'includes/footer.php';

?>