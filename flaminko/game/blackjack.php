<!-- Required CSS and JS -->
<?php
    if(isset($_POST['deck']))
    {
        $_SESSION['deck'] = $_POST['deck'];
    }
    if(isset($_POST['nodeck']))
    {
        unset($_SESSION['deck']);
        unset($_SESSION['bet']);
        unset($_SESSION['prize']);
    }
    if(isset($_POST['dealt']))
    {
        $_SESSION['dealt'] = true;
    }
    
    if(isset($_POST['bet']))
    {
        $_SESSION['bet'] = $_POST['bet'];
        $_SESSION['prize'] = $_POST['bet'] * 2;
        unset($_POST['bet']);
        header("location: " . $_SERVER['REQUEST_URI']);
    }
    
?>
<link rel="stylesheet" type="text/css" href="../css/game.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>

<div class="game-content">
    
    <div id="game-board">
        <?php 
        
            if(!isset($_SESSION['deck']) || empty($_SESSION['deck']))
            {
                print '<form id="choose-deck" action="" method="POST">
                            <h2>Choose your deck:</h2>
                        </form>';
            }
        ?>
        
        
        <div id="game" style="display: 
        <?php
            if(!isset($_SESSION['deck'])){
                print "none";
            }
            else 
                print "block";
        ?>
        ;">
            <?php
            if(isset($_SESSION['bet'])){
                print "<p>You are betting <b>".$_SESSION['bet']."</b> <img src='../img/chip/".$_SESSION['bet']."_chip.png' />"."</p>";
            }
            ?>
            <h1 id="dealername">DEALER</h1>
            
            <div id="dealer-card">
                <div class="card" id="dc0" style="display: none;">
                    <img class="front" id="dealer0"/>
                    <img class="back" />
                </div>
                <div class="card" id="dc1" style="display: none;">
                    <img class="front" id="dealer1"/>
                    <img class="back" />
                </div>
                <div class="card" id="dc2" style="display: none;">
                    <img class="front" id="dealer2"/>
                    <img class="back" />
                </div>
                <div class="card" id="dc3" style="display: none;">
                    <img class="front" id="dealer3"/>
                    <img class="back" />
                </div>
                <div class="card" id="dc4" style="display: none;">
                    <img class="front" id="dealer4"/>
                    <img class="back" />
                </div>
            </div>
        
            <h1 id="playername">PLAYER</h1>
            <div id="player-card">
                <div class="card" id="pc0" style="display: none;">
                    <img class="front" id="player0"/>
                    <img class="back" />
                </div>
                <div class="card" id="pc1" style="display: none;">
                    <img class="front" id="player1"/>
                    <img class="back" />
                </div>
                <div class="card" id="pc2" style="display: none;">
                    <img class="front" id="player2"/>
                    <img class="back" />
                </div>
                <div class="card" id="pc3" style="display: none;">
                    <img class="front" id="player3"/>
                    <img class="back" />
                </div>
                <div class="card" id="pc4" style="display: none;">
                    <img class="front" id="player4"/>
                    <img class="back" />
                </div>
            </div>
            
            <h2>YOUR CREDIT IS: <b id="playerCredit"></b> <img src='../img/coin.png'/></h2>
            <button  id="deal" name="deal"
            <?php
                if(!isset($_SESSION['bet'])){
                    print "disabled";
                    
                }
            ?>
            >DEAL</button>
            
            
            <button class="button" type="submit" id="hit" name="hit" disabled>HIT</button>
            <button class="button" id="stand" name="stand" disabled>STAND</button>
            
            <form id="resetdeck" action="" method="POST">
                 <input type="hidden" name="nodeck" value="true" checked> <br>
                <input class="button" type="submit" onclick="reset" 
                    value="Choose another deck (will restart game)">
            </form>
            
        
            <form id="resetbet" action="" method="POST" style="display: none;">
                 <input type="hidden" name="nobet" value="true" checked> <br>
                <input class="button" type="submit" onclick="reset" 
                value="Play another game">
            </form>
        
            <?php
                if(!isset($_SESSION['bet']))
                    print '<form action="" method="POST">
                            <p>Choose your bet value:</p>
                             <input type="radio" name="bet" value="10" checked>
                                <label for="10">10</label> <img src="../img/chip/10_chip.png" /><br>
                             <input type="radio" name="bet" value="20"> 
                                <label for="20">20</label> <img src="../img/chip/20_chip.png" /><br>
                             <input type="radio" name="bet" value="50">
                                <label for="50">50</label> <img src="../img/chip/50_chip.png" /><br>
                            <input class="button" type="submit" value="Submit">
                        </form> '
            ?>    
        </div>
        
            
    </div>
</div>


<script type="text/javascript">
    var dealercardnum = 0;
    var playercardnum = 0;
    var dealer = [];
    var player = [];
    var usedCards = ["test-6"];
    var cardBack;
    
    
    
    function init(){
        gapi.client.load('usersendpoint', 'v1', onLoad, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
        gapi.client.load('gameendpoint', 'v1', null, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
             
        document.getElementById("deal").onclick = function(){
            deal();
        }
        document.getElementById("hit").onclick = function(){
            hit();
        }
        document.getElementById("stand").onclick = function(){
            stand();
        }
        
        console.log("init");
    }

    //get cardback image onload        
    function onLoad(){
        var requestData = {};
        
        requestData.deck = "<?php print $_SESSION['deck']; ?>";
        
        gapi.client.usersendpoint.getBackCover(requestData).execute(function(resp){
            if(!resp.code){
                //set card back
                console.log("I GOT YOUR BACK!!! ");
                cardBack = resp.items[0];
                
                //set all back to cardBack
                $(".back").attr('src', cardBack);
            }
        });
        gapi.client.usersendpoint.getDecks().execute(function(resp){
            if(!resp.code){
                var decks = resp.items;
                decks.forEach(function(deck) {
                    if(deck != null){
                        var label = document.createElement('label');
                      label.innerHTML = deck.split("_")[0].charAt(0).toUpperCase() + deck.split("_")[0].slice(1);
                      label.for = deck.replace("/","");
                        var input = document.createElement('input');
                      input.type = "radio";
                      input.name = "deck";
                      input.value = deck.replace("/", "");
                      document.getElementById("choose-deck").appendChild(input);
                      document.getElementById("choose-deck").appendChild(label);
                      document.getElementById("choose-deck").appendChild(document.createElement('br'));
                    }
                });
                var submit = document.createElement("input");
                submit.type="submit";
                submit.name="Submit";
                submit.innerHTML = "SUBMIT";
                submit.className ="button";
                document.getElementById("choose-deck").appendChild(submit);
            }
        });
        editCredit();
    }
    
    function test(){
        var requestData = {};
        usedCards.shift();
        requestData.testValue = usedCards;
        gapi.client.gameendpoint.test(requestData).execute(function(resp){
            if(!resp.code){
                console.log(resp.items);
            }
        });
    }
    
    function editCredit(){
        var creditRequestData = {};
        creditRequestData.id = <?php print $_SESSION['userDetails']['id']; ?>;
        
        gapi.client.usersendpoint.acquireCredit(creditRequestData).execute(function(resp){
           if(!resp.code){
               document.getElementById("playerCredit").innerHTML = resp.items[0];
               console.log("CREDIT EDIT");
           } 
        });
    }
    
    function deal(){
        
        var creditRequestData = {};
        creditRequestData.id = <?php print $_SESSION['userDetails']['id']; ?>;
        creditRequestData.credit = "<?php print $_SESSION['bet']; ?>";
        console.log("bet: <?php print $_SESSION['bet']; ?>")
        
        var requestData = {};
        requestData.usedCards = usedCards;
        requestData.deck = "<?php print $_SESSION['deck']; ?>";
        gapi.client.usersendpoint.reduceCredit(creditRequestData).execute(function(resp){
            if(!resp.code){
                
                if(resp.items[0] == "FAIL")
                {
                    alert("CREDIT IS LESS THAN <?php print $_SESSION['bet']; ?>");
                    reset_bet();
                }
                else
                {
                    editCredit();
                    gapi.client.gameendpoint.deal(requestData).execute(function(resp){
                    if(!resp.code){
                        var cards = resp.items;
                        
                        //This is because the return value of the api needs to be separated
                        //note to change
                        dealer.push(cards[0]);
                        dealer.push(cards[1]);
                        player.push(cards[2]);
                        player.push(cards[3]);
                        usedCards.push(cards[0]);
                        usedCards.push(cards[1]);
                        usedCards.push(cards[2]);
                        usedCards.push(cards[3]);
                        document.getElementById("dealer0").src = cards[4];
                        document.getElementById("dc0").style.display = "inline-block";
                        
                        document.getElementById("dealer1").src = cards[5];
                        document.getElementById("dc1").style.display = "inline-block";
                        
                        document.getElementById("player0").src = cards[6];
                        document.getElementById("pc0").style.display = "inline-block";
                        
                        document.getElementById("player1").src = cards[7];
                        document.getElementById("pc1").style.display = "inline-block";
                        
                        dealercardnum = 2;
                        playercardnum = 2;
                        console.log(usedCards);
                        
                        document.getElementById("hit").disabled = false; 
                        document.getElementById("stand").disabled = false; 
                        document.getElementById("deal").disabled = true;
                        
                        var id = "";
                        var message = "";
                        
                        if(cards[9] == "BLACKJACK"){
                            blackjack("PLAYER");
                            id = "playername";
                            message = "BLACKJACK"
                        }
                        else if(cards[8] == "BLACKJACK"){
                            blackjack("DEALER");
                            id = "dealername";
                            message = "BLACKJACK"
                        }
                        document.getElementById(id).innerHTML =
                        document.getElementById(id).innerHTML + message;
                    }
                });
                }
                console.log("CREDIT REDUCED");
            }
        });
        
    }
    
    function showcard(card, person, message){
        var cardvalue = card.split("-");
        var requestData = {};
        var id;
        requestData.suit = cardvalue[0];
        requestData.number = cardvalue[1];
        requestData.deck = "<?php print $_SESSION['deck']; ?>";
        gapi.client.gameendpoint.getCardImageLink(requestData).execute(function(resp){
            if(!resp.code){
                var num;
                if(person == "dealer"){
                    console.log(card);
                    console.log(num);
                    num = dealercardnum;
                    dealercardnum = dealercardnum + 1;
                    id = "dc";
                } 
                else if(person == "player"){
                    num = playercardnum;
                    playercardnum = playercardnum + 1;
                    id = "pc";
                }
                document.getElementById(person + "" + num).src = resp.items[0];
                document.getElementById(id + "" + num).style.display = "inline-block";
                document.getElementById(person+"name").innerHTML =
                    document.getElementById(person+"name").innerHTML + message;
            }
        });
    }
    
    
    function hit(){
        var requestData = {};
        requestData.cards = player;
        requestData.usedCards = usedCards;
        gapi.client.gameendpoint.hit(requestData).execute(function(resp){
            if(!resp.code){
                usedCards.push(resp.items[resp.items.length - 1]);
                player.push(resp.items[resp.items.length - 1]);
                var message = " " +resp.items[0];
               
                
                if(resp.items[0] == "BLACKJACK")
                    blackjack("PLAYER");
                else if(resp.items[0] == "BUSTED")
                    busted();
                else if(resp.items[0] == "CHARLIE")
                    charlie("PLAYER");
                else
                    message = "";
                
                 showcard(resp.items[resp.items.length - 1], "player", message);
            }
        });
    }
    
    function stand(){
        
        var requestData = {};
        usedCards.shift();
        requestData.usedCards = usedCards;
        gapi.client.gameendpoint.stand(requestData).execute(function(resp){
            if(!resp.code){
                if(resp.items[0] == "PLAYER"){
                    console.log("PLAYER WON");
                    var requestData = {};
                    requestData.id = <?php print $_SESSION['userDetails']['id'] ?>;
                    requestData.credit = "<?php print $_SESSION['prize']; ?>";
                    console.log( "<?php print $_SESSION['prize']; ?>");
                    gapi.client.usersendpoint.increaseCredit(requestData).execute(function(resp){
                        if(!resp.code){
                            console.log("CREDIT INCREASED");
                            editCredit();
                        }
                    });
                    
                    document.getElementById("playername").innerHTML =
                    document.getElementById("playername").innerHTML + " WON";
                    
                }
                else if(resp.items[0] == "DEALER"){
                    document.getElementById("dealername").innerHTML =
                    document.getElementById("dealername").innerHTML + " WON";
                    console.log("DEALER WON");
                }
                for(var i=0; i<resp.items.length-1; i++){
                    console.log("test");
                    console.log(resp.items[i+1]);
                    setTimeout(showcard(resp.items[i+1],"dealer", ""), 1000)
                }
                    
                document.getElementById("hit").disabled = true; 
                document.getElementById("stand").disabled = true; 
                document.getElementById("deal").disabled = true; 
                console.log(resp.items);
            }
        });
        
        reset_bet();
    }
    
    function blackjack(player){
        console.log(player + " BLACKJACK");
        document.getElementById("hit").disabled = true; 
        document.getElementById("stand").disabled = true; 
        document.getElementById("deal").disabled = true; 
        reset_bet();
        if(player == "PLAYER"){
            var requestData = {};
            requestData.id = <?php print $_SESSION['userDetails']['id'] ?>;
            requestData.credit = "<?php print $_SESSION['prize'] ?>";
            
            gapi.client.usersendpoint.increaseCredit(requestData).execute(function(resp){
                if(!resp.code){
                    console.log("CREDIT INCREASED");
                    editCredit();
                }
            });
        }
        
    }
    function charlie(player){
        console.log(player + " CHARLIE WIN");
        document.getElementById("hit").disabled = true; 
        document.getElementById("stand").disabled = true; 
        document.getElementById("deal").disabled = true; 
        reset_bet();
        if(player == "PLAYER"){
            var requestData = {};
            requestData.id = <?php print $_SESSION['userDetails']['id'] ?>;
            requestData.credit = "<?php print $_SESSION['prize'] ?>";
            
            gapi.client.usersendpoint.increaseCredit(requestData).execute(function(resp){
                if(!resp.code){
                    console.log("CREDIT INCREASED");
                }
            });
        }
    }
    
    function busted(){
        console.log("BUSTED");
        document.getElementById("hit").disabled = true; 
        document.getElementById("stand").disabled = true; 
        document.getElementById("deal").disabled = true; 
        reset_bet();
    }
    
    function reset(){
        player = [];
        dealer = [];
        dealercardnum = 0;
        playercardnum = 0;
        usedCards = ["test-6"];
        for (var i = 0; i < 5; i++) { 
            document.getElementById("dealer" + i).src = "";
            document.getElementById("player" + i).src = "";
        }
        document.getElementById("hit").disabled = true; 
        document.getElementById("stand").disabled = true; 
        document.getElementById("deal").disabled = false; 
    }
    
    function reset_bet(){
        console.log("TEST");
        document.getElementById('resetbet').style.display = 'block';
    }
    
    
    //for flipping card
    $('.card').flip();
    
</script>
<script src="https://apis.google.com/js/client.js"></script>