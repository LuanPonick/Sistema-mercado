<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro de produtos</title>
</head>
<body>
    <header>
        <nav>
            <a href="home.html">Home</a>
            <a href="cadastrar_usuario.html">Cadastro de Usuário</a>
            <a href="cadastrar_produto.php">Cadastro de Produto</a>
            <a href="index.html">Sair</a>
        </nav>
    </header>

    <div class="container">
        <h1>Cadastro de produtos</h1>
        <form action="cadastrar_produto.php" method="post">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo">
            
            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="nome">
            
            <input type="submit" value="Inserir" name="inserir" id="inserir" class="green">
            <input type="submit" value="Deletar" name="deletar" id="deletar" class="red">
            <input type="submit" value="Listar" name="listar" id="listar" class="blue">
            <input type="submit" value="Alterar" name="alterar" id="alterar" class="yellow">
        </form>

        <div class="tabela-container" style="margin-top: 20px;">
            <h2>Produtos Cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>                    
                <?php    
                    // pegar o que foi digitado nos inputs 
                    $codigo = $_POST["codigo"];
                    $nome = $_POST["nome"];
        
                    // Verificar se o formulário foi enviado
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["listar"])) {
                        // Conectar ao banco de dados
                        include("conecta.php");

                        // Preparar o comando
                        $comando = $pdo->prepare("SELECT * FROM produto");

                        // Executar o comando
                        if ($comando->execute()) {
                            $produtos = $comando->fetchAll(PDO::FETCH_ASSOC);
                            
                            if ($produtos) {
                                foreach ($produtos as $linha) {
                                    $codigo2 = htmlspecialchars($linha["codigo"]);
                                    $nome2 = htmlspecialchars($linha["nome"]);
                                    echo "<tr>
                                            <td>$codigo2</td>
                                            <td>$nome2</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>Nenhum produto encontrado.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Erro ao BUSCAR dados</td></tr>";
                        }
                    }                    
                    // conexão com a base de dados
                    include("conecta.php");

                    // Verificar se o botão 'inserir' foi pressionado
                    if (isset($_POST["inserir"])) {
                        // Preparar o comando
                        $comando = $pdo->prepare("INSERT INTO produto VALUES(:codigo, :nome)");
                        $comando->bindParam(':codigo', $codigo);
                        $comando->bindParam(':nome', $nome);
                        
                        // Executar o comando
                        $resultado = $comando->execute();

                        if ($resultado) {
                            echo "
                                <script>
                                    alert('Dados gravados com sucesso!');
                                    window.location.href = 'index.html';
                                </script>
                            ";
                        } else {
                            echo "<h4>Erro ao gravar dados</h4>";
                        }
                    }

                    if (isset($_POST["deletar"])) {
                        // Preparar o comando
                        $comando = $pdo->prepare("DELETE FROM produto WHERE codigo = $codigo");

                        // Executar o comando
                        $resultado = $comando->execute();

                        if ($resultado) {
                            echo "
                                <script>
                                    alert('Dados deletados com sucesso!');
                                    window.location.href = 'index.html';
                                </script>
                            ";
                        } else {
                            echo "<h4>Erro ao Erro ao tentar deletar o item dados</h4>";
                        }
                    }

                    if (isset($_POST["alterar"])) {
                        // Preparar o comando
                        $comando = $pdo->prepare("UPDATE produto SET nome = '$nome' WHERE codigo = $codigo");
                        
                        // Executar o comando
                        $resultado = $comando->execute();

                        if ($resultado) {
                            echo "
                                <script>
                                    alert('Dados gravados com sucesso!');
                                    window.location.href = 'index.html';
                                </script>
                            ";
                        } else {
                            echo "<h4>Erro ao gravar dados</h4>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
