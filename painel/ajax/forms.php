<?php
    if(Painel::logado() == false){
        die("Você não está logado!"); //Proteção contra ataques.
    }

    include('../../includeConstants.php');

    $data['sucesso'] = true;
    $data['mensagem'] = "";

    if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'cadastrar_cliente'){


    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo_cliente'];
    $cpf = '';
    $cnpj = '';

    if($tipo == 'fisico'){
        $cpf = $_POST['cpf'];
    }else if($tipo == 'juridico'){
        $cnpj = $_POST['cnpj'];
    }


    $imagem = "";
    if($nome == '' || $email == '' || $tipo == ''){
        $data['sucesso'] = false;
        $data['mensagem'] = 'Atenção! Campos vázios não são permitidos.';
    }
    if(isset($_FILES['imagem'])){
        if(Painel::imagemValida($_FILES['imagem'])){
            $imagem = $_FILES['imagem'];
        }else{
            $imagem = "";
            $data['sucesso'] = false;
            $data['mensagem'] = 'Você está tentando realizar um upload com imagem';
        }
    }
    if($data['sucesso']){
        //Tudo ok, só cadastrar.
        if(is_array($imagem))
            $imagem = Painel::uploadFile();
        //Enviando dados...
        $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.clientes` VALUES (null,?,?,?,?,?)");
        $dadoFinal = ($cpf == '') ? $cnpj : $cpf;
        $sql->execute(array($nome,$email,$tipo_clientes,$dadoFinal,$imagem));
        
        $data['mensagem'] = 'O cliente foi cadastrado com sucesso!';
    }

    }else if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'atualizar_cliente'){
        
        $data['sucesso'] == true;
        $data['mensagem'] = 'O cliente foi editado com sucesso';

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $tipo = $_POST['tipo_cliente'];
        $cpf = '';
        $cnpj = '';
        $imagem = $_POST['imagem_original'];
        if($tipo == 'fisico'){
            $cpf = $_POST['cpf'];
        }else if($tipo == 'juridico'){
            $cnpj = $_POST['cnpj'];
        }

        //Agora vamos verificar
        if('nome' == '' || $email == ''){
            $data['sucesso'] = false;
            $data['mensagem'] = 'Campos vázios não são permitidos!';
        }
        if(isset($_FILES['imagem'])){
            if(Painel::imagemValida($_FILES['imagem'])){
                @unlink('../uploads/'.$imagem);
                $imagem = $_POST['imagem'];
            }else{
                $data['sucesso'] = false;
                $data['mensagem'] = "Você está tentando realizar um upload com uma imagem inválida!";
            }
        }
        if($data['sucesso']){
            if(is_array($imagem)){
                $imagem = Painel::uploadFile($imagem);
            }

            $sql = MySql::conectar()->prepare("UPDATE `tb_admin.clientes` SET nome = ?,email = ?,tipo = ?,cpf_cnpj = ?,imagem = ? WHERE id = $id");
            $dadoFinal = ($cpf == '') ? $cnpj : $cpf;
            $sql->execute(array($nome,$email,$tipo,$dadoFinal,$imagem));

            $data['mensagem'] = 'O cliente foi atualizado com sucesso!';
        }
        

    }else if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'deletar_cliente'){
        $id = $_POST['id'];

        $sql = MySql::conectar()->prepare("SELECT imagem FROM `tb_admin.clientes` WHERE id = $id");
        $sql->execute();
        $imagem = $sql->fetch()['imagem'];
        @unLink('../uploads/'.$imagem);
        MySql::conectar()->exec("DELETE FROM `tb_admin.clientes` WHERE = $id");
        MySql::conectar()->exec("DELETE FROM `tb_admin.financeiro` WHERE cliente_id = $id");
    }


    die(json_encode($data));

?>