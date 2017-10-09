//preventing same card beiong generated
var deck = [];

function getRandom(min, max){
    var random = 0;

	min = Math.ceil(min);
    max = Math.floor(max);
    
    random = Math.floor(Math.random() * (max-min+1)) + min;
    
    //dumb way of checking deck
    for(var i=0; i<deck.length; i++){
        if(random === deck[i]){
            random = Math.floor(Math.random() * (max-min+1)) + min;
        }
    }
    
    deck.push(random);
        
    return random;
}

function value(score){
    var remainder = score%13;
    
    if(remainder === 0){
        return "KING";
    }
    else if(remainder === 11){
        return "JACK";
    }
    else if(remainder === 12){
        return "QUEEN";
    }
    else if(remainder === 1){
        return "ACE";
    }
    else
        return remainder;
}

function card(){
	var cardType = {type:"", value:""}
    var type;
    var cardValue;
    var score;
    
    score = getRandom(1, 52);
    
    if(score>=1 && score<=13){
        type = "HEART";
        cardValue = value(score);
    }
    else if(score>=14 && score<=26){
        type = "DIAMOND";
        cardValue = value(score);
    }
    else if(score>=27 && score<=39){
        type = "CLUB";
        cardValue = value(score);
    }
    else if(score>=40 && score<=52){
        type = "SPADE";
        cardValue = value(score);
    }
    
    cardType["type"] = type;
    cardType["value"] = cardValue;
    
    //card object
    return cardType;
}