<?php
	require_once('header.php');
?>

<div class="content">
	<h1>Flaminko Admin</h1><br><br>
	<div class="buttonPos">
		<div>
        	<form action="javascript:void(0);">
        	  <h2>Delete User</h2>
        		 <div><input id="userID" placeholder="User ID value"></input></div><br>
        		 <div><input id="removeUsers" type="submit" value="Delete User"></div>
        	</form>
    	</div>
	</div>
</div>

<?php
	require_once('footer.php');
?>