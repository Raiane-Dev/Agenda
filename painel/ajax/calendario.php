<?php
    include('../../includeConstants.php');
    
    $data['sucesso'] = true;
    $data['mensagem'] = "";

    if(Painel::logado() == false){
        die("Você não está logado");
    }
    if(isset($_POST['acao']) && $_POST['acao'] == 'inserir'){
        $data = [];
        $data['tarefa'] = $_POST['tarefa'];
        $date = $_POST['data'];
        $sql = \MySql::conectar()->prepare("INSERT INTO `tb_admin.agenda` VALUES(null, ?, ?)");
        $sql->execute(array($data['tarefa'],$date));

        die(json_encode($data));
    }else if(isset($_POST['acao']) && $_POST['acao'] == 'puxar'){
        $data = $_POST['data'];
        $sql = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.agenda` WHERE data = '$data' ORDER BY id DESC");
        $sql->execute();
        $info = $sql->fetchAll();
        $box = "";
        foreach ($info as $key => $value){
            $box.='<div class="box-tarefa-single">';
            $box.='"<p>'.$value['tarefa'].'</p>"';
            $box.='</div>';
        }
        echo $box;
    }
?>