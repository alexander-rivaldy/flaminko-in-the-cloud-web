<?php
$title = "User Page";
session_start();


    //Saving user id to session
    if(isset($_POST['id']) && $_SESSION['userDetails'] == null){
        $_SESSION['userDetails'] = $_POST;
        unset($_POST);
    }

require_once("../layout/header.php");
?>

<?php
if($_SESSION['userDetails']['admin'] == "true"){
    require_once("../user/admin.php");
}else if($_SESSION['userDetails']['admin'] == "false"){
    require_once("../user/player.php");
}else{
    require_once("../error/user_general.php");
}
?>

<?php
require_once("../layout/footer.php");
?>