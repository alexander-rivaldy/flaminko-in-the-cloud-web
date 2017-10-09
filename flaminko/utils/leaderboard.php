<?php
    session_start();
    $title = "Leaderboard";
	require_once('../layout/header.php');
?>

<div class="content">
    <h1>Leaderboard</h1>
    <div class="datagrid" id="leaderboard">
        <!-- table for leaderboard -->
    </div>
</div>


<script type="text/javascript">
    function init(){
        gapi.client.load("usersendpoint", "v1", onLoad, "https://flaminko-in-the-cloud-api.appspot.com/_ah/api");
    }
    
    //will run after gapi load
    function onLoad(){
        //load leaderboard
        document.getElementById("leaderboard").innerHTML = "Getting the best patty-flipper....";
        
        gapi.client.usersendpoint.leaderboard().execute(function(resp){
            console.log("hi there");
            if(!resp.code){
                // console.log(resp);
                resp.items = resp.items || [];
                var result = "<table><thead><tr><th>Rank</th><th>Username</th><th>Credit</th></tr></thead><tbody>";
                
                //test JSON
                console.log("here");
                var i = 1;
                for(var username in resp){
                    if(username != "kind" && username != "etag" && username != "result" && username != "items"){
                        console.log(username, resp[username]);
                        
                        //label login user
                        if(username === "<?php echo $_SESSION['userDetails']['userName']?>"){
                            result = result + "<tr style='background: rgba(230, 101, 116, 1);'><td style='color:white;'>" + i + "</td><td style='color:white;'>" + username + "</td><td style='color:white;'>" +  resp[username] +  "</td></tr>";
                        }
                        else
                            result = result + "<tr><td>" + i + "</td><td>" + username + "</td><td>" +  resp[username] +  "</td></tr>";
                        i++;
                    }
                }
				result = result + "</tbody></table>";
                document.getElementById('leaderboard').innerHTML = result;
            }
        });
    }
</script>
<script src="https://apis.google.com/js/client.js"></script>

<?php
    require_once('../layout/footer.php');
?>