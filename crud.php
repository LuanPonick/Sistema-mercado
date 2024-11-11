<?php
    // pegar o que foi digitado nos inputs 
    $codigo = $_POST["codigo"];
    $nome = $_POST["nome"];

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