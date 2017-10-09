<?php
session_start();
error_reporting(0);

//check where it was redirect from by button command (btn-cmd)
$cmd = $_POST['btn-cmd'];
    if($cmd == "Log in"){
        $username = $_POST['username'];
        $password = $_POST['password'];
    }
    else if($cmd == "Register"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
    }
    else if($cmd == "Log out"){
        session_destroy();
        
        //check for session
        var_dump($_SESSION);
        header("Location: ../main/index.php");
    }
?>
<head>
    <title>Redirecting...</title>
</head>

<p id="status"></p>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
<script type="text/javascript">
    document.getElementById("status").innerHTML = "Shuffling Cards...";
    
    function init(){
        gapi.client.load('usersendpoint', 'v1', onLoad, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
    }
    
    var cmd = "<?php echo $cmd?>";
    
    function onLoad(){
        if(cmd === "Log in"){
            document.getElementById("status").innerHTML = "Getting Ingredients...";
            // wait for gapi fully load
            login();
        }
        else if(cmd === "Register"){
            document.getElementById("status").innerHTML = "Chopping up veggies...";
            //wait for gapi fully load
            register();
        }
    }
    
    //register function
    function register(){
        var _Username = "<?php echo $username; ?>";
        var _Password = "<?php echo $password; ?>";
        var _Name = "<?php echo $name?>";
        var _Credit = 100;
        var _Admin = "false";
        
        //Build the Request Object
        var requestData = {};
        requestData.userName = _Username;
        requestData.password = _Password;
		requestData.name = _Name;
		requestData.credit = _Credit;
		requestData.admin = _Admin;
		
		gapi.client.usersendpoint.insertUsers(requestData).execute(function(resp) {
                if (!resp.code) {
                    //return to register page with status
                    $message = "Register successfull";
                    $.redirect("../main/register.php", {message:$message}, "POST");
                }
                else if(resp.code == "503"){
                    $message = "Username taken. Please try again.";
                    $.redirect("../main/register.php", {message:$message}, "POST");
                }
        });
    }
    
    //login function
    function login(){
        var _Username = "<?php echo $username; ?>";
        var _Password = "<?php echo $password; ?>";
        
        var requestData = {};
        
        requestData.username = _Username;
        requestData.password = _Password;
        console.log(requestData);
        
        gapi.client.usersendpoint.loginUsers(requestData).execute(function(resp){
            if(!resp.code) {
                console.log(resp);
                
                if(jQuery.isEmptyObject(resp.result)){
                    console.log("login fail");
                    //return message to login page
                    $message = "Login failed. Invalid username or password";
                    $.redirect("../main/login.php", {message:$message}, "POST");
                }
                else{
                    //redirect to userpage
                    console.log("redirecting");
                    $.redirect("../profile/user.php", resp.result, "POST");
                }
            }
        });
        
    }
</script>
<script src="https://apis.google.com/js/client.js?onload=init"></script>