const automaticMessages = [
    "Bem-vindo! Como posso ajudá-lo hoje?",
    "Já encaminhamos sua mensagem para um dos nossos colaboradores.",
    "Obrigado pela sua mensagem!",
    "Estou aqui para ajudar.",
    "Como posso assisti-lo?",
    "Espero que você esteja tendo um ótimo dia!",
  ];
  let messageIndex = 0;
  
  function addAutomaticMessage() {
    const message = automaticMessages[messageIndex];
    addMessageToList(message, "received");
    messageIndex = (messageIndex + 1) % automaticMessages.length;
  }
  
  function addMessageToList(message, type) {
    const li = document.createElement("li");
    li.className = `chat-message ${type}`;
  
    const img = document.createElement("img");
    img.className = "avatar";
    if (type === "sent") {
      img.src = "http://localhost/celfix-v3/public/imagens/boneco2.png"; 
    } else {
      img.src = "http://localhost/celfix-v3/public/imagens/boneco1.png"; 
    }
  
    const messageContent = document.createElement("div");
    messageContent.className = "message";
    messageContent.textContent = message;
  
    if (type === "sent") {
      li.appendChild(messageContent);
      li.appendChild(img);
    } else {
      li.appendChild(img);
      li.appendChild(messageContent);
    }
  
    const messageList = document.getElementById("messageList");
    messageList.appendChild(li);
  }
  
  function addMessage() {
    const input = document.getElementById("messageInput");
    const message = input.value;
  
    if (message) {
      addMessageToList(message, "sent");
      input.value = "";
      input.focus();
      setTimeout(() => {
        addAutomaticMessage();
      }, 1000);
    }
  }
  
  window.onload = function () {
    addAutomaticMessage();
  };
  