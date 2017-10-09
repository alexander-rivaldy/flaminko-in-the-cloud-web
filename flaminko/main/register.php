<?php
    $title = "Register";
    require_once('../layout/header.php');
    
    if(!empty($_POST['message'])) {
	    $message = $_POST['message'];
	    echo "<script>alert('".$message."');</script>";
	};
	
?>

<div class="content">
    <h1>Register</h1>
    <div id="register-form table" class="datagrid">
        <form action="../profile/redirect.php" method="POST">
            <table>
                <tbody>
                <tr>
                    <th>Username</th>
                    <td><input class="text-box" type="text" id="username" name="username" placeholder="Username" required></input></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><input class="text-box" type="password" id="password1" name="password1" placeholder="Password" required></input></td>
                </tr>
                <tr>
                    <th>Confirm Password</th>
                    <td><input class="text-box" type="password" id="password" name="password" placeholder="Confirm Password" oninput="check()" required></input></td>
                </tr>
                <tr>
                    <th>Fullname</th>
                    <td><input class="text-box" type="text" id="name" name="name" placeholder="Name" required></input></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;"><input class="button" id="btn-cmd" name="btn-cmd" type="submit" value="Register" onclick="hash()" disabled></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div id="status"></div>
</div>

<!-- Hashing the password -->
<script src="../js/sha256.js"></script>
<script type="text/javascript">
	
	//check for password
	function check() {
		var password1 = document.getElementById("password1").value;
		var password = document.getElementById("password").value;
		
		if(password != password1){
			document.getElementById("status").innerHTML = "Password does not match!";
			document.getElementById("btn-cmd").disabled = true;
		}
		else{ //enable submit
			document.getElementById("status").innerHTML = "";
			document.getElementById("btn-cmd").disabled = false;
		}
	}	
	
    function hash() {
        // get password
        var password = document.getElementById('password').value;
        
        // call sha256 hash function
        var hash = SHA256.hash(password);
        
        //set password to hashed value
        document.getElementById('password1').value = hash;
        document.getElementById('password').value = hash;
    }
</script>

<?php
    require_once('../layout/footer.php')
?>