<div class="user content">
    <h1>WELCOME, <?php echo $_SESSION['userDetails']['userName']; ?></h1>
    <br/><br/>
    <p class="user-details">
        Name:     <?php echo $_SESSION['userDetails']['name']; ?><br/><br/>
        Username: <?php echo $_SESSION['userDetails']['userName']; ?><br/><br/>
        Credit: <b id="playerCredit" ></b> <img src='../img/coin.png'/><br/>
    </p>
    
    <button class="button" id="btn-cmd" name="btn-cmd"><a href="../utils/EditUser.php">Edit Profile</a></button>
    
    <!-- to the game -->
</div>

<script src="https://apis.google.com/js/client.js"></script>
<script type="text/javascript">
    function init(){
        gapi.client.load('usersendpoint', 'v1', onLoad, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
    }
    function onLoad(){
        var creditRequestData = {};
        creditRequestData.id = <?php print $_SESSION['userDetails']['id']; ?>;
        
        gapi.client.usersendpoint.acquireCredit(creditRequestData).execute(function(resp){
           if(!resp.code){
               document.getElementById("playerCredit").innerHTML = resp.items[0];
               console.log("CREDIT EDIT");
           } 
        });
    }
</script>
