<?php

	include('../../includeConstants.php');
	/**/
	$data['sucesso'] = true;
	$data['mensagem'] = "";

	if(Painel::logado() == false){
		die("Você não está logado!");
	}

	if(isset($_POST['acao']) && $_POST['acao'] == 'inserir_mensagem'){
		$mensagem = $_POST['mensagem'];
		$nome = $_SESSION['nome'];
		$id_user = $_SESSION['id_user'];
		
		$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.chat` VALUES (null,?,?)");
		$sql->execute(array($id_user,$mensagem));


		echo '<div class="chat-mensagem-single">
        <div class="perfil-usuario">
         <img src="https://blog.unyleya.edu.br/wp-content/uploads/2017/12/saiba-como-a-educacao-ajuda-voce-a-ser-uma-pessoa-melhor.jpeg">
         </div><!--perfil-usuario-->
         <div class="mensagem-usuario">
         <h6>'.$nome.'</h6>
         <p>'.$mensagem.'</p>
         </div><!--mensagem-usuario-->
         </div><!--chat-mensagem-single-->';

	$_SESSION['lastIdChat'] = MySql::conectar()->lastInsertId();


	//Recuperar mensagens
	$lastId = $_SESSION['lastIdChat'];


		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.chat` WHERE id >= $lastId");
		$sql->execute();
		$mensagens = $sql->fetchAll();
		$mensagens = array_reverse($mensagens);
		foreach ($mensagens as $key => $value) {
			$nomeUsuario = MySql::conectar()->prepare("SELECT nome FROM `tb_admin.usuarios` WHERE id = $value[id_user]");
			$nomeUsuario->execute();
			$nomeUsuario = $nomeUsuario->fetch()['nome'];
            $imagemUsuario = MySql::conectar()->prepare("SELECT img FROM `tb_admin.usuarios` WHERE id = $value[id_user]");
            $imagemUsuario->execute();
            $imagemUsuario = $imagemUsuario->fetch()['img'];
            
			echo '<div class="chat-mensagem-single">
            <div class="perfil-usuario">
             <img src="https://blog.unyleya.edu.br/wp-content/uploads/2017/12/saiba-como-a-educacao-ajuda-voce-a-ser-uma-pessoa-melhor.jpeg">
             </div><!--perfil-usuario-->
             <div class="mensagem-usuario">
             <h6>'.$nomeUsuario.'</h6>
             <p>'.$value['mensagem'].'</p>
             </div><!--mensagem-usuario-->
             </div><!--chat-mensagem-single-->';

			$_SESSION['lastIdChat'] = $value['id'];
		}
	}
?>