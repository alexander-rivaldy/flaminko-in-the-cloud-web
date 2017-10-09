<?php
    session_start();
    
    //check for login user
    if(!isset($_SESSION['userDetails']) || $_SESSION['userDetails'] == null){
        header("Location:../error/gandalf.php");
    }
    else{
        $title = "Edit User";
        // var_dump($_SESSION['userDetails']);
        require_once('../layout/header.php');
    }
?>

<div class="user content">
	<form action="javascript:void(0);">
	  <h1>Update Profile</h1>
		 <div><input id="editUsername" placeholder="User name here"></input></div><br>
		 <div><input id="editPassword" placeholder="Password here"></input></div><br>
		 <div><input id="editName" placeholder="Name here"></input></div><br>

		 <div><input id="updateUser" type="submit" value="Update User"></div>
	</form>
</div>

<?php
	require_once('../layout/footer.php');
?>