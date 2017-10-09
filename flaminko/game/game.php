<?php
    session_start();
    
    //check for login user
    if(!isset($_SESSION['userDetails']) || $_SESSION['userDetails'] == null){
        header("Location:../error/gandalf.php");
    }
    else{
        if(isset($_POST['nobet'])){
            unset ($_SESSION['prize']);
            unset ($_SESSION['bet']);
        }
        /* Note: code moves to blackjack.php
        */
        $title = "Blackjack";
        // var_dump($_SESSION['userDetails']);
        require_once('../layout/header.php');
        require_once("blackjack.php");
    }
?>

<?php
	require_once('../layout/footer.php');
?>
