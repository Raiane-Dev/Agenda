<?php

    if(isset($_GET['deletar'])){
        //Queremos deletar algum produto
        $id = (int)$_GET['deletar'];
        $imagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
        $imagens->execute();
        $imagens = $imagens->fetchAll();
        foreach($imagens as $key => $value){
            @unlink(BASE_DIR_PAINEL.'/uploads/'.$value['imagem']);
        }
        MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
        MySql::conectar()->exec("DELETE FROM `tb_admin.estoque` WHERE id = $id");
        Painel::alert('sucesso','O produto foi deletado com sucesso');
    }

    if(isset($_POST['atualizar'])){
        $quantidade = $_POST['quantidade'];
        $produto_id = $_POST['produto_id'];
        MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
        Painel::alert('sucesso','Você atualizou a quantidade do produto com ID: '.$_POST['produto_id']);
    }
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
    $sql->execute();
    if($sql->rowCount() > 0){
        Painel::alert('atencao','Você está com produtos em falta, <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos?pendentes">clique aqui</a> para visualiza-los!');
    }

    if(isset($_GET['pendentes']) == false){
?>
<div class="box-content">
    <h2><i data-feather="package"></i>Produtos</h2>
    <div class="busca">
        <form method="post">
            <input type="text" name="busca" placeholder="Pesquise aqui">
            <input type="submit" name="acao" value="Buscar!">
        </form>
    </div>

    <div class="secao-produtos">
    <?php
    $query = "";
        if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar!'){
            $nome = $_POST['busca'];
            $query = "WHERE (nome LIKE '%$nome%' OR descricao LIKE '%$nome%')";
        }
        if($query == ''){
            $query2 = "WHERE quantidade > 0";
        }else{
            $query2 = " AND quantidade > 0";
        }
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query $query2");
        $sql->execute();
        $produtos = $sql->fetchAll();
        if($query != ''){
            echo '<h2>Foram encontrado '.count($produtos).' resultado(s)</h2>';
        }

        foreach ($produtos as $key => $value){
            $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
            $imagemSingle->execute();
            $imagemSingle = $imagemSingle->fetch()['imagem'];
    ?>
    <div class="box-single-produto">
        <div class="box-single">
            <div class="box-img">
            <?php
                if($imagemSingle == ''){
                    echo '<i data-feather="package"></i>';
                }else{ ?>
                    <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle; ?>" />
                <?php } ?>
            </div><!--box-img-->
                <div class="produto-info">
                    <p><?php echo $value['nome']; ?></p>
                    <p class="descricao"><?php echo $value['descricao']; ?></p>
                    <div class="divisao"></div>
                    <span><?php echo $value['largura']; ?>cm</span>
                    <span><?php echo $value['altura']; ?>cm</span>
                    <span><?php echo $value['comprimento']; ?>cm</span>
                    <span><?php echo $value['peso']; ?></span>
                    <form method="post">
                        <input type="number" name="quantidade" value="<?php echo $value['quantidade']; ?>">
                        <input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
                        <input type="submit" name="atualizar" value="Atualizar" />
                        <a class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?deletar=<?php echo $value['id']; ?>"><i data-feather="trash"></i></a>
                        <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $value['id']; ?>"><i data-feather="edit"></i></a>
                </form>
            </div><!--produto-info-->
        </div><!--box-single-->
</div><!--box-single-produto-->
    
    <?php } ?>

</div><!--secao-produtos-->
</div><!--box-interna-->
</div><!--box-content-->
<?php }else{ ?>
    <div class="box-content">
    <div class="box-interna">
        <h2>Produtos em Falta</h2>
<?php
    if(isset($_POST['atualizar'])){
        $quantidade = $_POST['quantidade'];
        $produto_id = $_POST['produto_id'];
        MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
        Painel::alert('sucesso','Você atualizou a quantidade do produto com ID: '.$_POST['produto_id']);
    }
    Painel::alert('atencao','Todos os produtos a baixo estão em falta em seu estoque!');
    ?>
    <div class="secao-produtos">
    <?php
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
        $sql->execute();
        $produtos = $sql->fetchAll();
        foreach ($produtos as $key => $value){
            $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
            $imagemSingle->execute();
            $imagemSingle = $imagemSingle->fetch();
    ?>
        <div class="box-single-produto">
            <div class="box-single">
                <div class="box-img">
                    <img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $imagemSingle; ?>" />
                </div><!--box-img-->
                <div class="produto-info">
                    <p><?php echo $value['nome']; ?></p>
                    <p class="descricao"><?php echo $value['descricao']; ?></p>
                    <p><?php echo $value['largura']; ?>cm</p>
                    <p><?php echo $value['altura']; ?>cm</p>
                    <p><?php echo $value['comprimento']; ?>cm</p>
                    <p><?php echo $value['peso']; ?></p>
                    <form method="post">
                        <input type="number" name="quantidade" value="<?php echo $value['quantidade']; ?>">
                        <input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
                        <input type="submit" name="atualizar" value="Atualizar" />
                    </form>
                <a class="btn delete" item_id="<?php echo $value['id']; ?>" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?deletar=<?php echo $value['id']; ?>">Excluir</a>
                <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $value['id']; ?>">Editar</a>
            </div><!--produto-info-->
        </div><!--box-single-->
</div><!--box-single-produto-->
    
    <?php } ?>

</div><!--secao-produtos-->
</div>
    <?php } ?>