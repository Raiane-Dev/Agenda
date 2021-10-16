<div class="box-content">
<div class="box-interna">

<?php
    if(isset($_GET['email'])){
        //Queremos enviar um email avisando o atraso
        $parcela_id = (int)$_GET['parcela'];
        $cliente_id = (int)$_GET['email'];
        if(isset($_COOKIE['cliente_'.$cliente_id])){
            Painel::alert('erro','Você já enviou um email cobrando esse cliente, aguarde mais um pouco.');
        }else{
            //Podemos enviar o email - O email pode ser enviado a cada 7 dias, depois disso destruímos o cookie
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE id = $parcela_id");
            $sql->execute();
            $infoFinanceiro = $sql->fetch();
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE id = $cliente_id");
            $sql->execute();
            $infoClientes = $sql->fetch();
            $corpoEmail = "Olá! $infoCliente[nome], você está com um saldo pendente em $infoFinanceiro[valor] com o vencimento para $infoFinanceiro[vencimento]. Entre em contato conosco para quitar sua parcela!";
            $email = new Email('servidor.de.email','raiane.dev@gmail.com','123456','Raiane');
            $email->addAddress($infoCliente['email'],$infoCliente['nome']);
            $email->formatarEmail(array('assunto'=>'Cobrança','corpo'=>$corpoEmail));
            $email->enviarEmail();
            Painel::alert('sucesso','Email enviado com sucesso');
            setcookie('cliente_'.$cliente_id,'true',time()+(60*60*24*7),'/');
        }
    }
?>

<?php
    if(isset($_GET['pago'])){
        $sql = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");
        $sql->execute(array($_GET['pago']));
        Painel::alert('sucesso','O pagamento foi quitado com sucesso');
    }
?>
<h2>Pagamentos Pendentes</h2>
        <div class="wraper-table-col6">
        <table>
            <tr>
                <td class="title">Pagamento</td>
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
            $clienteNome = MySql::conectar()->prepare("SELECT `nome`,`id` FROM `tb_admin.clientes` WHERE id = $value[client_id]");
            $clienteNome->execute();
            $info = $clienteNome->fetch();
            $clienteNome = $info['nome'];
            $idCliente = $info['id'];
            $style = "";
            if(strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])){
                $style = 'style="background-image:linear-gradient(90deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0)); background-color:#f41127; color:#ffffff;"';
            }
        ?>
        <tr <?php echo $style; ?>>
            <td><?php echo $value['nome']; ?></td>
            <td><?php echo $clienteNome; ?></td>
            <td><?php echo $value['valor']; ?></td>
            <td><?php echo date('d-m-Y',strtotime($value['vencimento'])); ?></td>
            <td><a class="btn email" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos?email=<?php echo $info['id']; ?>&parcela=<?php echo $value['id']; ?>"> E-mail</td>
            <td><a <?php echo $style ?> class="btn pago" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos?pago=<?php echo $value['id']; ?>"> Pago</td>
        </tr>

        <?php } ?>
        </table>
            <div class="gerar-pdf">
                <a href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamento=pendentes" target="_blank">Gerar PDF</a>
            </div>
        </div>
    </div><!--box-interna-->

    <div class="box-interna">
        <h2>Pagamentos Concluídos</h2>
        <div class="wraper-table-col4">
        <table>
            <tr>
                <td class="title">Nome</td>
                <td class="title">Cliente</td>
                <td class="title">Valor</td>
                <td class="title">Vencimento</td>
            </tr>
            <?php
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 1 ORDER BY vencimento ASC"); //status = 0 é pagamento pendente
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
        <div class="gerar-pdf">
            <a href="<?php echo INCLUDE_PATH_PAINEL ?>gerar-pdf.php?pagamento=concluidos" target="_blank">Gerar PDF</a>
        </div>
    </div>
</div><!--box-interna-->
</div><!--box-content-->
