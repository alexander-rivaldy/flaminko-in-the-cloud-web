<!DOCTYPE html>
<html>
    <div>
        <button id="generate">GENERATE</button>
        <h1 id="type"></h1>
        <h1 id="value"></h1>
        <img id="cardImage" src=""/>
    </div>
    
    <script type="text/javascript">
        var suit;
        var number;
        var deck = "burger_deck";
        function init() {
            gapi.client.load('gameendpoint', 'v1', null, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
            
            document.getElementById("generate").onclick = function(){
                generateCard();
            }
        }
        function generateCard(){
            
            gapi.client.gameendpoint.card().execute(function(resp){
               if(!resp.code) {
                   console.log(resp.items[0]);
                   var cardvalue = resp.items[0].split("-");
                   suit = cardvalue[0];
                   number = cardvalue[1];
                    var requestData = {};
                    requestData.suit = suit;
                    requestData.number = number;
                    requestData.deck = deck;
                    
                   gapi.client.gameendpoint.getCardImageLink(requestData).execute(function(resp){
                        if(!resp.code) {
                            console.log(resp);
                            document.getElementById("cardImage").src = resp.items[0];
                        }
                    });
                   
               }
            });
           
            
        }
    </script>
    
    <script src="https://apis.google.com/js/client.js?onload=init"></script>
</html>