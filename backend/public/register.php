<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            max-width: 600px;
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
    <h1>Register</h1>
    <form id="register-form" action="?route=register" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstName">Nome:</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Digite seu nome">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastName">Sobrenome:</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Digite seu sobrenome">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="document">Documento:</label>
                    <input type="text" class="form-control" id="document" name="document" placeholder="Digite seu documento">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phoneNumber">Telefone:</label>
                    <input type="text" class="form-control" id="phoneNumber" name="phone_number" placeholder="Digite seu telefone">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthDate">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="birthDate" name="birth_date">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
    </form>
    <div id="message"></div>
    <div class="login-link">
        <p>Você já tem cadastro? <a href="?route=login">Faça login aqui</a>.</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('#register-form').submit(function(e){
            e.preventDefault();
            // Envie o formulário usando Ajax
            $.ajax({
                type: 'POST',
                url: '?route=create_user',
                data: $(this).serialize(),
                success: function(response){
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        $('#message').html('<div class="alert alert-success mt-3" role="alert">Registro realizado com sucesso!</div>');
                        window.location.href = '?route=home';
                    } else {
                        $('#message').html('<div class="alert alert-danger mt-3" role="alert">' + jsonResponse.message + '</div>');
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = JSON.parse(xhr.responseText).message;
                    $('#message').html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
                }
            });
        });
    });
</script>
</body>
</html>
