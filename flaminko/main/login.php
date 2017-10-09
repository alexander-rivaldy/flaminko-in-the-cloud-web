<?php
session_start();
    $title = "Log in";
	require_once('../layout/header.php');
	if(!empty($_POST['message'])) {
	    $message = $_POST['message'];
	};
?>
<div class="content">
    <h1>Login</h1>
    <div class="login">
        <form action="../profile/redirect.php" method="POST">
            <p>Usename: </p>
            <input class="text-box" type="text" name="username" required></input><br>
            <p>Password: </p>
            <input class="text-box" type="password" id="password" name="password" required></input><br><br>
            
            <!-- login status -->
            <p><?php echo $message; ?></p>
            
            <input class="button" id="btn-cmd" name="btn-cmd" type="submit" value="Log in" onclick="hash()"></input>
        </form>
    </div>
</div>

<!-- Hashing the password -->
<script src="../js/sha256.js"></script>
<script type="text/javascript">
    function hash() {
        // get password
        var password = document.getElementById('password').value;
        
        // call sha256 hash function
        var hash = SHA256.hash(password);
        
        //set password to hashed value
        document.getElementById('password').value = hash;
    }
</script>

<?php
	require_once('../layout/footer.php');
?>