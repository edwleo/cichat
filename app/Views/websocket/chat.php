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
  
  <div class="container">
    <div id="chat-header">
      <h4>Chat en tiempo real</h4>
      <div>
        <!-- status de la conexión -->
        <span id="statusText">Desconectado</span>
      </div>
    </div>

    <div class="card my-3">
      <div class="card-body">
        <div id="chat-messages">
          <div class="message">
            Conectando al servidor...
          </div>
        </div>
      </div>
    </div>

    <!-- Caja de texto para enviar los mensajes -->
    <div id="chat-input">
      <div class="mb-2">
        <input type="text" class="form-control" placeholder="Nombre" id="user-name" autofocus>
      </div>
      <div class="mb-2">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Tu mensaje aquí" id="message">
          <button class="btn btn-success" type="button" id="sendButton">Enviar</button>
        </div>
      </div>
    </div> <!-- ./chat-input -->

  </div> <!-- ./container -->

  <script>
    //Función conectar al servidor
    function connect(){

      //1. Objeto conexión
      const conn = new WebSocket('ws://localhost:8080')

      //2. Apertura de conexión
      conn.onopen = function(e){
        console.log("Conexión establecida")
      }

      //3. Envío de mensaje
      conn.onmessage = function(e){
        console.log("Mensaje recibido...")
      }

      //4. Cierre de comunicación
      conn.onclose = function(e){
        console.log("Conexión finalizada")
      }

      //5. Manejo de errores
      conn.onerror = function(e){
        console.error("Problemas en la conexión")
      }
    }
    
    connect();
  </script>

</body>
</html>