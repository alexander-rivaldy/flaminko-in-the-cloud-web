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
        var used_card = ["heart-5", "clover-5"];
        function init() {
            gapi.client.load('gameendpoint', 'v1', null, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
            
            document.getElementById("generate").onclick = function(){
                generateCard();
            }
        }
        function generateCard(){
            var requestData = {};
            requestData.cards = used_card;
            requestData.usedCards = used_card;
            console.log(requestData);
            gapi.client.gameendpoint.hit(requestData).execute(function(resp){
               if(!resp.code) {
                   console.log(resp);
               }
            });
            
        }
    </script>
    
    <script src="https://apis.google.com/js/client.js?onload=init"></script>
</html>