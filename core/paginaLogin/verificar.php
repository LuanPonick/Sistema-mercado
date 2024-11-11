<?php
    // pegar o que foi digitado nos inputs 
    $login = $_POST["login"];
    $senha = $_POST["senha"];

    // conexão com a base de dados
    include("conecta.php");

    if (isset($_POST["entrar"])) {
        // Preparar o comando
        $comando = $pdo->prepare("SELECT * FROM usuarios WHERE login = :login AND senha = :senha");
        
        $comando->bindParam(':login', $login);
        $comando->bindParam(':senha', $senha);


        // Executar o comando
        if ($comando->execute()) {
            $usuario = $comando->fetch(PDO::FETCH_ASSOC);
            console.log("teste");
            if ($usuario) {
                // Verificar se o perfil é "A"
                if ($usuario['perfil'] === 'A') {
                    // Se o perfil for "A", redireciona para cadastrar.html
                    header("Location: home.html");
                    exit(); // Certifique-se de sair após o redirecionamento
                } else {
                    echo "<h4>Acesso negado: perfil não autorizado.</h4>";
                }
            } else {
                echo "<h4>Nenhum usuário encontrado.</h4>";
            }
        } else {
            echo "<h4>Erro ao BUSCAR o usuário</h4>";
        }
  }
?>