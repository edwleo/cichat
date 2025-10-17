<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CHAT</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>
<body>

  <style>
    .message {
      margin: 1rem 0rem; /* margen: Y - X */
      max-width: 70%; /* Ancho máximo */
      border-radius: 18px; /* Borde redondeado */
      box-shadow: 0px 2px 5px 0px gray; /* sombra */
      padding: 1rem;  /* relleno */
    }

    .message-user{
      background-color: rgb(190, 255, 233);
      margin-left: auto;
    }

    .message-system{
      color: gray;
      font-style: italic; /* Cursiva */
      font-size: 0.75rem;
    }

    .header{
      font-weight: bold; /* negrita */
      color: dodgerblue;
    }

    .time{
      font-size: 0.75rem;
      color: gray;
    }

    #chat-container{
      height: 700px;
      border: 1px solid rgb(228, 228, 228);
      padding: 1rem;
      border-radius: 10px;

      overflow-y: auto;
    }
  </style>
  
  <div class="container">
    <div id="chat-header">
      <h4>Chat en tiempo real</h4>
      <div>
        <!-- status de la conexión -->
        <span id="statusText">Desconectado</span>
      </div>
    </div>

    <div id="chat-container">
      <div class="card">
        <div class="card-body">
          <div id="chat-messages">
            
          </div>
        </div>
      </div>
    </div>

    <!-- Caja de texto para enviar los mensajes -->
    <div id="chat-input" class="mt-2">
      <div class="mb-2">
        <input type="text" class="form-control" placeholder="Nombre" id="userNameInput" autofocus>
      </div>
      <div class="mb-2">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Tu mensaje aquí" id="messageInput">
          <button class="btn btn-success" type="button" id="sendButton">Enviar</button>
        </div>
      </div>
    </div> <!-- ./chat-input -->

  </div> <!-- ./container -->

  <script>
    let conn = null;

    const chatContainer = document.getElementById("chat-container")
    const messageInput = document.getElementById("messageInput")
    const usernameInput = document.getElementById("userNameInput")
    const sendButton = document.getElementById("sendButton")
    const chatMessages = document.getElementById("chat-messages")
    const statusText = document.getElementById("statusText")

    //Función conectar al servidor
    function connect(){

      //1. Objeto conexión
      conn = new WebSocket('ws://localhost:8080')

      //2. Apertura de conexión
      conn.onopen = function(e){
        console.log("Conexión establecida")
        statusText.textContent = "Conectado"
        addSystemMessage("Conectado al servidor")
      }

      //3. Envío de mensaje
      conn.onmessage = function(e){
        //console.log(e.data)
        const data = JSON.parse(e.data)
        console.log(data)

        if (data.type === 'system'){
          addSystemMessage(data.message) //mensaje (texto)
        }else{
          addMessage(data) //objeto (id, nombreusuario, mensaje, tiempo)
        }
      }

      //4. Cierre de comunicación
      conn.onclose = function(e){
        console.log("Conexión finalizada")
        statusText.textContent = "Desconectado"
        addSystemMessage("Desconectado del servidor, reconectando...")

        setTimeout(connect, 3000)
      }

      //5. Manejo de errores
      conn.onerror = function(e){
        console.error("Problemas en la conexión")
      }
    } //connect

    function sendMessage(){
      const message = messageInput.value.trim()
      const username = usernameInput.value.trim()

      if (message && conn.readyState == WebSocket.OPEN){
        const data = {
          message: message,
          username: username
        }

        conn.send(JSON.stringify(data))
        messageInput.value = ''
      }
    } //sendMessage

    function addSystemMessage(text){
      const messageDiv = document.createElement("div")
      messageDiv.textContent = text
      messageDiv.classList.add("message-system")
      chatMessages.appendChild(messageDiv)

      scrollToBottom()
    } //addSystemMessage

    function addMessage(data){
      const messageDiv = document.createElement("div")
      const isCurrentUser = data.username === usernameInput.value.trim()
      //Se debe incluir CSS

      const contentDiv = document.createElement("div")
      contentDiv.classList.add("message")

      if (!isCurrentUser){
        const headerDiv = document.createElement("div") //Mostrar nombre del otro USUARIO
        headerDiv.textContent = data.username
        headerDiv.classList.add("header")
        contentDiv.appendChild(headerDiv)
      }else{
        //Es mi propio mensaje (alinear derecho)
        contentDiv.classList.add("message-user")
      }

      //Capa mensaje
      const textDiv = document.createElement("div")
      textDiv.textContent = data.message
      contentDiv.appendChild(textDiv)

      //Capa hora mensaje
      const timeDiv = document.createElement("div")
      timeDiv.textContent = data.timestamp
      timeDiv.classList.add("time")
      contentDiv.appendChild(timeDiv)

      messageDiv.appendChild(contentDiv)
      chatMessages.appendChild(messageDiv)
      
      //Enviamos un mensaje y scroll hacia abajo
      scrollToBottom()
    } //addMessage

    function scrollToBottom(){
      chatContainer.scrollTop = chatContainer.scrollHeight
    }

    //¿Cuándo enviamos como USUARIO un mensaje?
    //EVENTOS...
    sendButton.addEventListener("click", sendMessage)
    
    messageInput.addEventListener("keypress", (event) => {
      if (event.key == "Enter"){
        sendMessage()
      }
    })

    connect();
  </script>

</body>
</html>