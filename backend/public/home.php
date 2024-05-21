<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            overflow-x: hidden;
            padding-top: 60px;
            transition: 0.5s;
            width: 250px;
            z-index: 1;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar .close-btn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .sidebar .close-btn:hover {
            color: #f8f9fa;
        }
        .sidebar .brand {
            font-size: 28px;
            text-align: center;
            padding: 20px;
        }
        .content {
            margin-left: 250px; /* Ajuste do espaço para a barra lateral */
            padding: 20px;
        }
        .content .card {
            margin-bottom: 20px;
        }
        @media screen and (max-height: 450px) {
            .sidebar {padding-top: 15px;}
            .sidebar a {font-size: 18px;}
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
                transition: 0.5s;
            }
            .content {
                margin-left: 0;
            }
            .open-btn {
                display: block;
            }
            .close-btn {
                display: none;
            }
        }
        .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <button class="open-btn btn btn-primary btn-block mb-3">☰ Menu</button>
            <div class="sidebar">
                <div class="brand">Menu</div>
                <a href="#" class="close-btn">×</a>
                <!-- Links para as páginas de usuários, pedidos e produtos -->
                <a href="#" class="btn btn-primary btn-block mb-3 load-content" data-page="?route=users">Usuários</a>
                <a href="#" class="btn btn-primary btn-block mb-3 load-content" data-page="?route=orders">Pedidos</a>
                <a href="#" class="btn btn-primary btn-block mb-3 load-content" data-page="?route=products">Produtos</a>
                <a href="#" class="btn btn-danger btn-block mb-3" id="logoutBtn">Logout</a>
            </div>
        </div>
        <div class="col-md-9 col-lg-10 content" id="dynamicContent">
            <!-- Conteúdo dinâmico será carregado aqui -->
        </div>
    </div>
</div>

<div class="loading">Carregando...</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('.open-btn').click(function(){
            $('.sidebar').width(250);
        });
        // Função para fechar a barra lateral
        $('.close-btn').click(function(){
            $('.sidebar').width(0);
        });
        // Função para carregar conteúdo dinâmico ao clicar nos links
        $('.load-content').click(function(e){
            e.preventDefault();
            var page = $(this).data('page');
            $('.loading').show(); // Exibindo indicador de carregamento
            $.ajax({
                url: page,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('.loading').hide(); // Ocultando indicador de carregamento
                    if (response.success) {
                        if (page === "?route=users") {
                            var users = response.users;
                            var table = '<table class="table"><thead><tr><th>ID</th><th>Nome</th><th>Sobrenome</th><th>Email</th></tr></thead><tbody>';
                            $.each(users, function(index, user) {
                                table += '<tr><td>' + user.id + '</td><td>' + user.first_name + '</td><td>' + user.last_name + '</td><td>' + (user.email ? user.email : 'N/A') + '</td></tr>';
                            });
                            table += '</tbody></table>';
                            $('#dynamicContent').html(table);
                        } else if (page === "?route=orders") {
                            var orders = response.orders;
                            var table = '<table class="table"><thead><tr><th>ID</th><th>Descrição</th><th>Quantidade</th><th>Preço</th></tr></thead><tbody>';
                            $.each(orders, function(index, order) {
                                table += '<tr><td>' + order.id + '</td><td>' + order.description + '</td><td>' + order.quality + '</td><td>' + (order.price ? order.price : 'N/A') + '</td></tr>';
                            });
                            table += '</tbody></table>';
                            $('#dynamicContent').html(table);
                        } else if (page === "?route=products") {
                            var products = response.products;
                            var table = '<table class="table"><thead><tr><th>ID</th><th>Nome</th><th>Preço</th><th>Descrição</th></tr></thead><tbody>';
                            $.each(products, function(index, product) {
                                table += '<tr><td>' + product.id + '</td><td>' + product.name + '</td><td>' + product.price + '</td><td>' + (product.description ? product.description : 'N/A') + '</td></tr>';
                            });
                            table += '</tbody></table>';
                            $('#dynamicContent').html(table);
                        }
                    } else {
                        $('#dynamicContent').html('<p>' + response.message + '</p>');
                    }
                },
                error: function() {
                    $('.loading').hide();
                    $('#dynamicContent').html('<p>Ocorreu um erro ao carregar o conteúdo</p>');
                }
            });
            $('.sidebar').width(0);
        });
        // Script para o botão de logout
        $('#logoutBtn').click(function(e){
            e.preventDefault();
            alert('Logout realizado com sucesso!');
            window.location.href = '?route=login';
        });
    });
</script>

</body>
</html>
