$(document).ready(function(){
	var dealer;
	var player;
	
	function start(){
		dealer = {
			"name": "dealer",
			"card": [],
			"total": ""
		}
			
		player = {
			"name":"player",
			"card": [],
			"total": ""
		}
	}
	
	//disable hit & stand button
	document.getElementById("hit").disabled = true;
	document.getElementById("stand").disabled = true;
	
	start();
	
	//dealing
	$("#deal").click(function(){
		//dealer draw
		for(var i=0; i<2; i++){
			drawCard(dealer.card, "dealer");
			
	    	document.getElementById("dealer-total").innerHTML = total(dealer.card);
		}
		
		//player draw
		for(var i=0; i<2; i++){            	
			drawCard(player.card, "player");
	    	document.getElementById("player-total").innerHTML = total(player.card);
	    	if(total(player.card) == 21){
	    		document.getElementById("status").innerHTML = 'Dealer Blackjack!'
	    	}
		}
		
		console.log(dealer);
		console.log(player);
		console.log("player sum = " + total(player.card));
		
		//blackjack
		if(total(player) === 21){
			status = "BLACKJACK";
		}
		
		//disabling "deal" button
		document.getElementById("deal").disabled = true;
		
		//enable hit and stand
		document.getElementById("hit").disabled = false;
		document.getElementById("stand").disabled = false;
	});
	
	
	//hit: player draw
	$("#hit").click(function(){
		if(player.card.length < 5){
			drawCard(player.card, "player");
			
			document.getElementById("player-total").innerHTML = total(player.card);
			
			if(total(player.card) > 21){
				document.getElementById("status").innerHTML = "Player busted";
				
				//restart game
			}
		}
	});
	
	//stand: player stop drawing, dealer draw
	$("#stand").click(function(){
		document.getElementById("hit").disabled = true;
	
		while(total(dealer.card) < total(player.card)){
			drawCard(dealer.card, "dealer");
	    	
	    	document.getElementById("dealer-total").innerHTML = total(dealer.card);
		
			if(total(dealer.card) > 21){
				document.getElementById("status").innerHTML = "Dealer Busted"
			}
		}
	});
});

function drawCard(userCard, role){
	var tempCard;
	tempCard = card();
	userCard.push(tempCard);
	
	$("#" + role + "-card").append(tempCard.type + " of " + tempCard.value + "</br>");
}

//calculate total card value
function total(userCard){
	var sum = 0;
	
	for(var i=0; i<userCard.length; i++){
		if(userCard[i].value === "ACE"){
			if(userCard.length < 3)
				sum += 11;
			else
				sum += 1;
		}
		else if(userCard[i].value === "KING" || userCard[i].value === "QUEEN" || userCard[i].value === "JACK")
			sum += 10;
		else
			sum += parseInt(userCard[i].value);
	}
	return sum;
}    

function status(user, msg){
	//blackjack
	if(msg == "BLACKJACK"){
		document.getElementById("status").innerHTML = user.name + msg;
		document.getElementById("restart").hidden = false;
		//reset button
	}
	//push, when player and dealer had the same total
	
	
	//win
	
	//lose
}