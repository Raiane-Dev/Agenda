<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$cliente = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes`");
        $cliente->execute();
        $cliente = $cliente->fetchAll();
        foreach($cliente as $value);
	}else{
		Painel::alert('erro','Você precisa passar o parametro ID.');
		die();
	}
?>
<div class="box-content">
<div class="box-interna">
	<h2><i data-feather="edit"></i> Editar Usuário</h2>

	<form atualizar class="ajax" action="<?php echo INCLUDE_PATH_PAINEL ?>ajax/forms.php" method="post" enctype="multipart/form-data">

        <label>Nome:</label>
        <input type="text" value="<?php echo $value['nome']; ?>" name="nome">

        <label>Email:</label>
        <input type="text" value="<?php echo $value['email']; ?>" name="email">

        <label>Tipo:</label>
        <select name="tipo_cliente">
            <option <?php if($value['tipo'] == 'fisico') echo 'selected'; ?> value="fisico">Físico</option>
            <option <?php if($value['tipo'] == 'juridico') echo 'selected'; ?> value="juridico">Jurídico</option>
        </select>

        <?php
            if($value['tipo'] == 'fisico'){
        ?>

        <div ref="cpf">
        <label>CPF</label>
        <input type="text" value="<?php echo $value['cpf_cnpj']; ?>" name="cpf">
        </div>

        <div ref="cnpj" style="display:none;">
        <label>CNPJ</label>
        <input type="text" name="cnpj">
        </div>

        <?php 
            }else{
        ?>

        <div ref="cpf" style="display:none;">
        <label>CPF</label>
        <input type="text" name="cpf">
        </div>

        <div ref="cnpj" style="display:block;">
        <label>CNPJ</label>
        <input type="text" value="<?php echo $value['cpf_cnpj']; ?>" name="cnpj">
        </div>
        
        <?php } ?>

        <label>Imagem:</label>
        <input type="file" name="imagem">

        <input type="hidden" name="imagem_original" value="<?php echo $value['imagem']; ?>">
        <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
        <input type="hidden" name="tipo_acao" value="atualizar_cliente">
        <input type="submit" name="acao" value="Atualizar!">

    </form>

    <h2>Adicionar Pagamentos</h2>
    <form method="post">

    <?php
        if(isset($_POST['acao'])){
            $cliente_id = $id;
            $nome = $_POST['nome_pagto'];
            //$valor = str_replace('.','',$_POST['valor']);
            //$valor = str_replace(',','.',$valor);
            $valor = $_POST['valor'];
            $intervalo = $_POST['intervalo'];
            $vencimento = $_POST['vencimento'];
            $numero_parcelas = $_POST['parcelas'];
            $status = 0;
            $vencimentoOriginal = $_POST['vencimento'];
            

            if(strtotime($vencimentoOriginal) < time()){
                Painel::alert('erro','Você selecionou uma data negativa.');
            }else{

            }

            for($i = 0; $i < $numero_parcelas; $i++){
                $vencimento = strtotime($vencimentoOriginal) + (($i * $intervalo) *(60*60*24));
                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.financeiro` VALUES (null,?,?,?,?,?)");
                $sql->execute(array($cliente_id,$nome,$valor,date('Y-m-d',$vencimento),0));
            }
        }

            if(isset($_GET['pago'])){
                $sql = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");
                $sql->execute(array($_GET['pago']));
                Painel::alert('sucesso','O pagamento foi quitado com sucesso');
            }
           
    ?>
        <label>Nome do Pagamento</label>
        <input type="text" name="nome_pagto" />

        <label>Valor do Pagamento</label>
        <input type="text" name="valor" />

        <label>Número de Parcelas</label>
        <input type="text" name="parcelas" />

        <label>Intervalo</label>
        <input type="text" name="intervalo" />
        
        <label>Vencimento</label>
        <input type="text" name="vencimento" />

        <input type="submit" name="acao" value="Inserir Pagamento">
    </form>

    <h2>Pagamentos Pendentes</h2>
        <div class="wraper-table-col6">
        <table>
            <tr>
                <td class="title">Nome do pagamento</td>
                <td class="title">Cliente</td>
                <td class="title">Valor</td>
                <td class="title">Vencimento</td>
                <td class="title">Enviar E-mail</td>
                <td class="title">Concluir</td>
        </tr>

        <?php
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 ORDER BY vencimento ASC"); //status = 0 é pagamento pendente
            $sql->execute();
            $pendentes = $sql->fetchAll();

            foreach ($pendentes as $key => $value){ 
            $clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[client_id]");
            $clienteNome->execute();
            $clienteNome = $clienteNome->fetch()['nome'];
            $style = "";
            if(strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])){
                $style = 'style="background-color:#ff0023;color:#fff;"';
            }
        ?>
        <tr <?php echo $style; ?>>
            <td><?php echo $value['nome']; ?></td>
            <td><?php echo $clienteNome; ?></td>
            <td><?php echo $value['valor']; ?></td>
            <td><?php echo date('d-m-Y',strtotime($value['vencimento'])); ?></td>
            <td><a <?php echo $style; ?>class="btn email" href="<?php echo INCLUDE_PATH_PAINEL ?>"> E-mail</td>
            <td><a <?php echo $style; ?>class="btn pago" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-cliente?id=<?php echo $id; ?>&pago=<?php echo $value['id']; ?>"> Pago</td>
        </tr>

        <?php } ?>
        </table>
        </div>

        <h2>Pagamentos Concluídos</h2>
        <div class="wraper-table">
        <table>
            <tr>
                <td class="title">Nome do pagamento</td>
                <td class="title">Cliente</td>
                <td class="title">Valor</td>
                <td class="title">Vencimento</td>
            </tr>
            <?php
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 1 AND client_id=$id ORDER BY vencimento ASC"); //status = 0 é pagamento pendente
            $sql->execute();
            $pendentes = $sql->fetchAll();

            foreach ($pendentes as $key => $value){ 
            $clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[client_id]");
            $clienteNome->execute();
            $clienteNome = $clienteNome->fetch()['nome'];
            
        ?>
        <tr <?php echo $style; ?>>
            <td><?php echo $value['nome']; ?></td>
            <td><?php echo $clienteNome; ?></td>
            <td><?php echo $value['valor']; ?></td>
            <td><?php echo date('d-m-Y',strtotime($value['vencimento'])); ?></td>
        </tr>
        <?php } ?>

    </table>
    </div><!--box-interna-->
</div><!--box-content-->