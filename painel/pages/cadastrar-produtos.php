<div class="box-content">
<div class="box-interna">
    <h2><i data-feather="grid"></i>Cadastrar Produto</h2>

    <?php
		if(isset($_POST['acao'])){
			$nome = $_POST['nome'];
			$descricao = $_POST['descricao'];
			$largura = $_POST['largura'];
			$altura = $_POST['altura'];
			$peso = $_POST['peso'];
			$comprimento = $_POST['comprimento'];
			$quantidade = $_POST['quantidade'];

			$imagens = array();
			$amountFiles = count($_FILES['imagem']['name']);

			$sucesso = true;

			if($_FILES['imagem']['name'][0] != ''){

			for($i =0; $i < $amountFiles; $i++){
				$imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
				'size'=>$_FILES['imagem']['size'][$i]];
				if(Painel::imagemValida($imagemAtual) == false){
					$sucesso = false;
					Painel::alert('erro','Uma das imagens selecionadas são inválidas!');
					break;
				}
			}

			}else{
				$sucesso = false;
				Painel::alert('erro','Você precisa selecionar pelo menos uma imagem!');
			}


			if($sucesso){
				//TODO: Cadastrar informacoes e imagens e realizar upload.
				for($i =0; $i < $amountFiles; $i++){
					$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
						'name'=>$_FILES['imagem']['name'][$i]];
					$imagens[] = Painel::uploadFile($imagemAtual);
				}

				$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque` VALUES (null,?,?,?,?,?,?,?)");
				$sql->execute(array($nome,$descricao,$largura,$altura,$comprimento,$peso,$quantidade));
				$lastId = MySql::conectar()->lastInsertId();
				foreach ($imagens as $key => $value) {
					MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$lastId,'$value')");
				}
				Painel::alert('sucesso','O produto foi cadastrado com sucesso!');
			}

			
		}
?>

    <form method="post" enctype="multipart/form-data">

        <label>Nome do Produto</label>
        <input type="text" name="nome" />

        <label>Descrição do Produto</label>
        <textarea name="descricao"></textarea>
        
        <div class="peso-produto">
        <label>Largura</label>
        <input type="number" name="largura" min="0" max="900" step="5" />

        <label>Altura</label>
        <input type="number" name="altura" min="0" max="900" step="5" />

        <label>Comprimento</label>
        <input type="number" name="comprimento" min="0" max="900" step="5" />

        <label>Peso</label>
        <input type="number" name="peso" min="0" max="900" step="5" />

        <label>Quantidade</label>
        <input type="number" name="quantidade" min="0" max="900" step="5" />
        </div>

        <label>Selecione as Imagens</label>
        <input multiple type="file" name="imagem[]"> <!--Utilizar [] para passar como array, e assim utilizarmos diversas imagens-->

        <input type="submit" name="acao" value="Cadastrar Produto">

    </form>
</div><!--box-interna-->
</div><!--box-interna-->