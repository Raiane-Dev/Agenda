<?php
    $id = (int)$_GET['id'];
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
    $sql->execute(array($id));
    if($sql->rowCount() == 0){
        Painel::alert('erro','O produto ue você quer editar não existe!');
        die();
    }
    $infoProduto = $sql->fetch();

    $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
    $pegaImagens->execute();
    $pegaImagens = $pegaImagens->fetchAll();

    if(isset($_GET['deletarImagem'])){
        $idImagem = (int)$_GET['deletarImagem'];
        @unlink(BASE_DIR_PAINEL.'/uploads/'.$idImagem);
        MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE imagem = '$idImagem'");
        Painel::alert('sucesso','A imagem foi deletada com sucesso.');
        $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
        $pegaImagens->execute();
        $pegaImagens = $pegaImagens->fetchAll();
    }
?>
<div class="box-content">
<div class="box-interna">
	<h2><i data-feather="edit"></i> Editando Produto com ID: <?php echo $id ?></h2>

        <div class="box-single-produto">
        <div class="box-wraper-produto">
            <div class="box-img">
            <?php
                foreach($pegaImagens as $key => $value){
            ?>
                <img onClick="seleciona-imagem" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']; ?>" />
            <?php } ?>
            </div><!--box-img-->
    </div><!--box-wraper-produto-->

    <div class="box-wraper-produto-2">
    <form method="post" enctype="multipart/form-data">

    <?php
        if(isset($_POST['acao'])){
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $largura = $_POST['largura'];
            $altura = $_POST['altura'];
            $comprimento = $_POST['comprimento'];
            $peso = $_POST['peso'];
            $quantidade = $_POST['quantidade'];
            $imagens = [];

            $sucesso = true;
            $amountFiles = count($_FILES['imagem']['name']);
            if($_FILES['imagem']['name'][0] != ''){
                //Adicionar mais imagens no produto
                for($i = 0; $i < $amountFiles; $i++){
                    $imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],'size'=>$_FILES['imagem']['size'][$i]];
                    if(Painel::imagemValida($imagemAtual) == false){
                        $sucesso = false;
                        Painel::alert('erro','Uma das imagens selecionadas são inválidas');
                        break;
                    }
                }
            }
            if($sucesso){
                //Inserir no banco de dados | Fazer upload da imagem
                if($_FILES['imagem']['name'] != ''){
                    for($i = 0; $i < $amountFiles; $i++){
                        $imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],'name'=>$_FILES['imagem']['name'][$i]];
                        $imagens[] = Painel::uploadFile($imagemAtual);
                    }
                }
                foreach ($imagens as $key => $value){
                    MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$id,'$value')");
                }
            }

            $sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET nome = ?,descricao = ?, altura = ?, largura = ?, comprimento = ?, peso = ?, quantidade = ? WHERE id = $id");
            $sql->execute(array($nome,$descricao,$altura,$largura,$comprimento,$peso,$quantidade));

            Painel::alert('sucesso','Você atualizou seu produto com sucesso!');
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
            $sql->execute(array($id));
            $infoProduto = $sql->fetch();
            $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
            $pegaImagens->execute();
            $pegaImagens = $pegaImagens->fetchAll();
        }
    ?>

        <label>Nome do Produto</label>
        <input type="text" name="nome" value="<?php echo $infoProduto['nome']; ?>"/>

        <label>Descrição do Produto</label>
        <textarea name="descricao"><?php echo $infoProduto['descricao']; ?></textarea>

        <div class="peso-produto">
        <label>Largura</label>
        <input type="number" name="largura" min="0" max="900" value="<?php echo $infoProduto['largura']; ?>"/>

        <label>Altura</label>
        <input type="number" name="altura" min="0" max="900" value="<?php echo $infoProduto['altura']; ?>"/>

        <label>Comprimento</label>
        <input type="number" name="comprimento" min="0" max="900" value="<?php echo $infoProduto['comprimento']; ?>"/>

        <label>Peso</label>
        <input type="number" name="peso" min="0" max="900" value="<?php echo $infoProduto['peso']; ?>"/>

        <label>Quantidade</label>
        <input type="number" name="quantidade" min="0" max="900" value="<?php echo $infoProduto['quantidade']; ?>"/>
        </div>

        <label>Selecione as Imagens</label>
        <input multiple type="file" name="imagem[]"> <!--Utilizar [] para passar como array, e assim utilizarmos diversas imagens-->

        <input type="submit" name="acao" value="Atualizar Produto">
        <a class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>excluir-produto?id=<?php echo $id ?>&deletarImagem=<?php echo $value['imagem'] ?>">deletar</a>

</form>
</div>
</div><!--box-single-produto-->
</div><!--box-interna-->
</div><!--box-content-->