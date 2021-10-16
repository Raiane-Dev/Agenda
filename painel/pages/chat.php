<?php
	verificaPermissaoPagina(2);
?>
<div class="box-content chat">
<div class="box-interna chat">
	<h2><i data-feather="message-circle"></i> Chat Online</h2>

    <div class="chat">
        <div class="chat-interno">

            <div class="chat-pessoas">
                <?php
                $usuarioChat = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios`");
                $usuarioChat->execute();
                $usuarioChat = $usuarioChat->fetchAll();
                foreach($usuarioChat as $key => $value){
                ?>
                <div class="usuario">
                    <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['img'] ?>" />
                    <label><?php echo $value['nome'] ?></label>
                </div><!--usuario-->
                <?php } ?>
            </div><!--chat-pessoas-->

            <div class="chat-mensagens">
                <div class="chat-mensagens-boxes">

                <?php
                    $mensagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.chat` ORDER BY id DESC LIMIT 10");
                    $mensagens->execute();
                    $mensagens = $mensagens->fetchAll();
                    $mensagens = array_reverse($mensagens);
                    foreach ($mensagens as $key => $value) {
                    $nomeUsuario = MySql::conectar()->prepare("SELECT nome FROM `tb_admin.usuarios` WHERE id = $value[id_user]");
                    $nomeUsuario->execute();
                    $nomeUsuario = $nomeUsuario->fetch()['nome'];
                    $imagemUsuario = MySql::conectar()->prepare("SELECT img FROM `tb_admin.usuarios` WHERE id = $value[id_user]");
                    $imagemUsuario->execute();
                    $imagemUsuario = $imagemUsuario->fetch()['img'];
                    $lastId = $value['id'];
                ?>
                    <div class="chat-mensagem-single">
                        <div class="perfil-usuario">
                            <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemUsuario; ?>">
                        </div><!--perfil-usuario-->
                        <div class="mensagem-usuario">
                            <h6><?php echo $nomeUsuario; ?></h6>
                            <p><?php echo $value['mensagem']; ?></p>
                        </div><!--mensagem-usuario-->
                    </div><!--chat-mensagem-single-->
                    <?php 
		        	$_SESSION['lastIdChat'] = $lastId;
		            } ?>
                    
                </div><!--chat-mensagens-boxes-->
            </div><!--chat-mensagens-->

            <div class="escrever-mensagem">
                <form method="post" action="<?php echo INCLUDE_PATH_PAINEL ?>ajax/chat.php">
                    <textarea id="message" name="mensagem"></textarea>
                    <input type="hidden" name="acao" value="inserir_mensagem">
                    <input type="submit" value="Enviar" />
                </form>
            </div><!--escrever-mensagem-->

        </div><!--chat-interno-->
    </div><!--chat-->

</div><!--box-content-->
</div><!--box-interna-->

