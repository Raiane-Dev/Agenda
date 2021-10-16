<?php
    include('../includeConstants.php');
    $sql = MySql::conectar();
?>
<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }
    h2{
        background:#111;
        color:#fff;
        padding:10px;
    }
    .box{
        width:900px;
        margin:0 auto;
    }
    table{
        width:900px;
        border-collapse:collapse;
    }
    table td{
        font-size:14px;
        padding:8px;
        border:1px solid #eee;
    }
</style>
<div class="box">
<?php
    $nome = (isset($_GET['pagemento']) && $_GET['pagamento'] == 'concluidos') ? 'Concluidos' : 'Pendentes';
?>


        <h2>Pagamentos Concluídos</h2>
        <div class="wraper-table">
        <table>
            <tr>
                <td>Nome do pagamento</td>
                <td>Cliente</td>
                <td>Valor</td>
                <td>Vencimento</td>
            </tr>
            <?php
                if($nome == 'Pendentes')
                    $nome = 0;
                else
                    $nome = 1;
            ?>
            <?php
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 1 ORDER BY vencimento ASC"); //status = 0 é pagamento pendente
            $sql->execute();
            $pendentes = $sql->fetchAll();

            foreach ($pendentes as $key => $value){ 
            $clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[client_id]");
            $clienteNome->execute();
            $clienteNome = $clienteNome->fetch()['nome'];
            
        ?>
        <tr>
            <td><?php echo $value['nome']; ?></td>
            <td><?php echo $clienteNome; ?></td>
            <td><?php echo $value['valor']; ?></td>
            <td><?php echo date('d-m-Y',strtotime($value['vencimento'])); ?></td>
        </tr>
        <?php } ?>

    </table>
    </div>
</div>