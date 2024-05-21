<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Login</h1>
    <form id="login-form" action="?route=authenticate" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email">
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </form>
    <div id="message"></div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('#login-form').submit(function(e){
            e.preventDefault(); // Impede o envio do formulário padrão

            // Envie o formulário usando Ajax
            $.ajax({
                type: 'POST',
                url: '?route=authenticate',
                data: $(this).serialize(), // Serializa os dados do formulário
                success: function(response){
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        $('#message').html('<div class="alert alert-success mt-3" role="alert">Login realizado com sucesso!</div>');
                        window.location.href = '?route=home';
                    } else {
                        $('#message').html('<div class="alert alert-danger mt-3" role="alert">' + jsonResponse.message + '</div>');
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = JSON.parse(xhr.responseText).message;
                    $('#message').html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>'); // Exibe mensagem de erro formatada na div #message
                }
            });
        });
    });
</script>
</body>
</html>
