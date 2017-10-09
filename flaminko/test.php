

<div class="content">
    <form action="javascript:void(0);">
      <h2>Register Game</h2>
          <div><input id="id" placeholder="id"></input></div><br>
    	 <div><input id="card1" placeholder="card1"></input></div><br>
    	 <div><input id="playerforcard1" placeholder="playerforcard1"></input></div><br>
    	 <div><input id="card2" placeholder="card2"></input></div><br>
    	 <div><input id="playerforcard2" placeholder="playerforcard2"></input></div>
    	 <div><input id="registerGame" type="submit" value="Register Game"></div>
    </form>

</div>




<script type="text/javascript">
    function init(){
        gapi.client.load('gameendpoint', 'v1', null, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
                
        document.getElementById('registerGame').onclick = function() {
                insertGame();
        }
    }
    
    function insertGame(){
        var deck = {};
        var belonging = []
        // json.deck = {};
        // json.deck[document.getElementById("card1").value] = document.getElementById("playerforcard1").value;
        // json.deck[document.getElementById("card2").value] = document.getElementById("playerforcard2").value;
        // json.deck = {};
        // json.deck.used_cards={};
        // json.deck.used_cards[document.getElementById("card1").value] = document.getElementById("playerforcard1").value;
        // json.deck.used_cards[document.getElementById("card2").value] = document.getElementById("playerforcard2").value;
        deck.used_cards = document.getElementById("card1").value;
        // deck.used_cards[0] = document.getElementById("card1").value;
        // deck.used_cards[1] = document.getElementById("card2").value;
        
        belonging[0] = document.getElementById("playerforcard1").value;
        belonging[1] = document.getElementById("playerforcard2").value;
        
        console.log(deck);
        console.log(belonging);
        
        var _Id = document.getElementById('id').value;
        var _Deck = deck;
        var _Belonging = belonging;
        var requestData = {};
        requestData.id = _Id;
        requestData.deck = _Deck;
        requestData.belonging = _Belonging;
        
        gapi.client.gameendpoint.insertGame(requestData).execute(function(resp){
            if (!resp.code) {
                    //Just logging to console now, you can do your check here/display message
                    console.log(resp.id + ":" + resp.deck);
					
					alert('Game Registered');
					
            }
        });
    }
    
</script>
 <script src="https://apis.google.com/js/client.js?onload=init"></script>
	
