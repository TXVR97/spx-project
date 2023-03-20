document.getElementById("chatbot_toggle").onclick = function () {
    if (document.getElementById("chatbot").classList.contains("collapsed")) {
      document.getElementById("chatbot").classList.remove("collapsed")
      document.getElementById("chatbot_toggle").children[0].style.display = "none"
      document.getElementById("chatbot_toggle").children[1].style.display = ""
      
    }
    else {
      document.getElementById("chatbot").classList.add("collapsed")
      document.getElementById("chatbot_toggle").children[0].style.display = ""
      document.getElementById("chatbot_toggle").children[1].style.display = "none"
    }
  }

  var sendForm = document.querySelector('#chatform'),
      textInput = document.querySelector('.chatbox'),
      chatList = document.querySelector('.chatlist'),
      userBubble = document.querySelectorAll('.userInput'),
      botBubble = document.querySelectorAll('.bot__output'),
      animateBotBubble = document.querySelectorAll('.bot__input--animation'),
      overview = document.querySelector('.chatbot__overview'),
      hasCorrectInput,
      imgLoader = false,
      animationCounter = 1,
      animationBubbleDelay = 600,
      input,
      previousInput,
      isReaction = false,
      unkwnCommReaction = "je n'ai pas bien compris 😟",
      chatbotButton = document.querySelector(".submit-button")

sendForm.onkeydown = function(e){
  if(e.keyCode == 13){
    e.preventDefault();

    //No mix ups with upper and lowercases
    var input = textInput.value.toLowerCase();

    //Empty textarea fix
    if(input.length > 0) {
      createBubble(input)
    }
  }
};

sendForm.addEventListener('submit', function(e) {
  //so form doesnt submit page (no page refresh)
  e.preventDefault();

  //No mix ups with upper and lowercases
  var input = textInput.value.toLowerCase();

  //Empty textarea fix
  if(input.length > 0) {
    createBubble(input)
  }
}) //end of eventlistener

var createBubble = function(input) {
  //create input bubble
  var chatBubble = document.createElement('li');
  chatBubble.classList.add('userInput');

  //adds input of textarea to chatbubble list item
  chatBubble.innerHTML = input;

  //adds chatBubble to chatlist
  chatList.appendChild(chatBubble)

  checkInput(input);
}

var checkInput = function(input) {
  hasCorrectInput = false;
  isReaction = false;
  //Checks all text values in possibleInput
  for(var textVal in possibleInput){
    //If user reacts with "oui" and the previous input was in textVal
    if(input == "oui" || input.indexOf("oui") >= 0){
      if(previousInput == textVal) {
        console.log("sausigheid");

        isReaction = true;
        hasCorrectInput = true;
        botResponse(textVal);
      }
    }
    if(input == "non" && previousInput == textVal){
      unkwnCommReaction = "Pour avoir une liste des commandes disponible tape: Commandes";
      unknownCommand("Aucun problème 😀 ")
      unknownCommand(unkwnCommReaction);
      hasCorrectInput = true;
    }
    //Is a word of the input also in possibleInput object?
    if(input == textVal || input.indexOf(textVal) >=0 && isReaction == false){
			console.log("succes");
      hasCorrectInput = true;
      botResponse(textVal);
		}
	}
  //When input is not in possibleInput
  if(hasCorrectInput == false){
    console.log("failed");
    unknownCommand(unkwnCommReaction);
    hasCorrectInput = true;
  }
}

// debugger;

function botResponse(textVal) {
  //sets previous input to that what was called
  // previousInput = input;

  //create response bubble
  var userBubble = document.createElement('li');
  userBubble.classList.add('bot__output');

  if(isReaction == true){
    if (typeof reactionInput[textVal] === "function") {
    //adds input of textarea to chatbubble list item
      userBubble.innerHTML = reactionInput[textVal]();
    } else {
      userBubble.innerHTML = reactionInput[textVal];
    }
  }

  if(isReaction == false){
    //Is the command a function?
    if (typeof possibleInput[textVal] === "function") {
      // console.log(possibleInput[textVal] +" is a function");
    //adds input of textarea to chatbubble list item
      userBubble.innerHTML = possibleInput[textVal]();
    } else {
      userBubble.innerHTML = possibleInput[textVal];
    }
  }
  //add list item to chatlist
  chatList.appendChild(userBubble) //adds chatBubble to chatlist

  // reset text area input
  textInput.value = "";
}

function unknownCommand(unkwnCommReaction) {
  // animationCounter = 1;

  //create response bubble
  var failedResponse = document.createElement('li');

  failedResponse.classList.add('bot__output');
  failedResponse.classList.add('bot__output--failed');

  //Add text to failedResponse
  failedResponse.innerHTML = unkwnCommReaction; //adds input of textarea to chatbubble list item

  //add list item to chatlist
  chatList.appendChild(failedResponse) //adds chatBubble to chatlist

  animateBotOutput();

  // reset text area input
  textInput.value = "";

  //Sets chatlist scroll to bottom
  chatList.scrollTop = chatList.scrollHeight;

  animationCounter = 1;
}

function responseText(e) {

  var response = document.createElement('li');

  response.classList.add('bot__output');

  //Adds whatever is given to responseText() to response bubble
  response.innerHTML = e;

  chatList.appendChild(response);

  animateBotOutput();

  console.log(response.clientHeight);

  //Sets chatlist scroll to bottom
  setTimeout(function(){
    chatList.scrollTop = chatList.scrollHeight;
    console.log(response.clientHeight);
  }, 0)
}

function responseImg(e) {
  var image = new Image();

  image.classList.add('bot__output');
  //Custom class for styling
  image.classList.add('bot__outputImage');
  //Gets the image
  image.src = "/images/"+e;
  chatList.appendChild(image);

  animateBotOutput()
  if(image.completed) {
    chatList.scrollTop = chatList.scrollTop + image.scrollHeight;
  }
  else {
    image.addEventListener('load', function(){
      chatList.scrollTop = chatList.scrollTop + image.scrollHeight;
    })
  }
}

//change to SCSS loop
function animateBotOutput() {
  chatList.lastElementChild.style.animationDelay= (animationCounter * animationBubbleDelay)+"ms";
  animationCounter++;
  chatList.lastElementChild.style.animationPlayState = "running";
}

function commandReset(e){
  animationCounter = 1;
  previousInput = Object.keys(possibleInput)[e];
}

// hlep

var possibleInput = {
  // "hlep" : this.help(),
  "service" : () => {
    responseText("Pour ajouter un service, clique sur le bouton Menu puis Services");
    responseText("Sur l'écran suivant tu pourras rentrer les informations souhaitées, et enfin ajouter un service après une vérification.");
    responseText("Tu pourras visualiser les services créés dans la section 'ajouter services', le bouton services existants");
    commandReset(0);
    return;
  },
  "partenaire" : () => {
    responseText("Pour ajouter un partenaire, clique sur le bouton Menu puis Partenaires");
    responseText("Sur l'écran suivant tu pourras rentrer les informations souhaitées, et enfin ajouter un partenaire après une vérification. ( n'oublie pas de cocher la case 'status' si le partenaire est actif)");
    responseText("Les partenaires seront visibles sur l'accueil.");
    responseText("Souhaites tu retourner sur le menu des commandes? (Oui/Non)");
    commandReset(1);
    return;
  },
  "utilisateur" : () => {
      responseText("Pour ajouter un utilisateur, clique sur le bouton Menu puis Utilisateurs");
      responseText("Sur l'écran suivant tu pourras rentrer les informations souhaitées, et enfin ajouter un utilisateur après une vérification.");
      responseText("Tu pourras visualiser les utilisateurs créés dans la section 'ajouter utilisateurs', le bouton utilisateurs existants");
      responseText("Souhaites tu retourner sur le menu des commandes? (Oui/Non)");
      commandReset(2);
      return;
  },
  "structure" : () => {
    responseText("Pour ajouter une structure, cherche la carte du partenaire souhaité et clique sur le bouton details");
    responseText("Sur l'écran des details du partenaire, clique sur le bouton Ajouter Structure, tu pourras rentrer les informations souhaitées, et enfin ajouter ta structure après une vérification.");
    responseText("Pour modifier une structure ou la supprimer , rend toi sur un partenaire et sur la carte du dessous tu verras les bouttons modifier / supprimer.");
    commandReset(3);
    return;
  },
  "commandes" : () => {
    responseText("Voici ce que je peux comprendre:");
    responseText("partenaire,service, utilisateur, structure");
    commandReset(8);
    return;
  },
  
  
}

var reactionInput = {
  
    "partenaire" : () => {
      responseText("Les sujets que je peux traiter:");
      responseText("Ajouter un 'Partenaire' ");
      responseText("Ajouter un 'Utilisateur'");
      responseText("Ajouter un 'Service'");
      responseText("Ajouter une 'Structure'");
      animationCounter = 1;
      return;
    },
    "utilisateur" : () => {
      responseText("Les sujets que je peux traiter:");
      responseText("Ajouter un 'Partenaire' ");
      responseText("Ajouter un 'Utilisateur'");
      responseText("Ajouter un 'Service'");
      responseText("Ajouter une 'Structure'");
      animationCounter = 1;
      return;
    }
}



