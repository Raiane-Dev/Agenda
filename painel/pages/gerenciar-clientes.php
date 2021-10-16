<div class="box-content">
<div class="box-interna">
	<h2><i data-feather="server" aria-hidden="true"></i> Clientes Cadastradas</h2>

    <div class="busca">
        <form method="post">
            <input placeholder="Procure por nome,email ou cpf/cnpj" type="text" name="busca">
            <input type="submit" name="acao" value="buscar">
        </form>
    </div><!--busca-->
    <div class="boxes-clientes">
    <?php
        $query = "";
        if(isset($_POST['acao'])){
            $busca = $_POST['busca'];
            $query = " WHERE nome LIKE '%$busca%'";
        }
            $clientes = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` $query");
            $clientes->execute();
            $clientes = $clientes->fetchAll();
            if(isset($_POST['acao'])){
                echo '<div class="busca-result">Foram encontrados <b>'.count($clientes).'<br> resultado(s)</div>';
            }
            foreach($clientes as $value){
        ?>
        <div class="box-single-wraper">
            <div class="box-single-cliente">
                <div class="topo-box">
                    <div class="fundo-imagem">
                    <?php 
                        if($value['imagem'] == ''){
                    ?>
                        <h3><i data-feather="user"></i></h3>
                    <?php }else{ ?>
                        <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value=['imagem']; ?>" />
                    <?php } ?>
                    </div><!--fundo-imagem-->
                    </div><!--topo-box-->
                <div class="body-box">
                    <p class="nome-do-cliente"><?php echo $value['nome']; ?> </p>
                    <div class="group-btn">
                        <a class="btn delete" item_id="<?php echo $value['id']; ?>" href="<?php echo INCLUDE_PATH_PAINEL ?>">Excluir</a>
                        <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-cliente?id=<?php echo $value['id']; ?>">Editar</a>
                    </div><!--group-btn-->
                    <p class="email-do-cliente">Email: <span><?php echo $value['email']; ?></span></p>
                    <p class="tipo-de-cliente">Tipo: <span><?php echo $value['tipo']; ?> </span></p>
                    <p><?php
                        if($value['tipo'] == 'fisico')
                            echo '<p class="cpf_cnpj-do-cliente">CPF:';
                        else
                            echo '<p class="cpf_cnpj-do-cliente">CNPJ: ';
                    ?> <span><?php echo $value['cpf_cnpj']; ?></span></p>
                </div><!--body-box--> 
            </div><!--box-single-->
        </div><!--box-single-wraper-->
        <?php } ?>
        
        <div class="clear"></div>

    </div><!--boxes-clientes-->
</div><!--box-content-->
</div><!--box-content-->