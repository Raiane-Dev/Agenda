<?php
    $mes = date('m',time());
    $ano = date('Y',time());

    if($mes > 12)
        $mes = 12;
    if($mes < 1)
        $mes = 1;

    $numeroDias = cal_days_in_month(CAL_GREGORIAN,$mes,$ano);
    $diaInicialdoMes = date('N',strtotime("$ano-$mes-01"));
    $diaDeHoje = date('d',time());
    
    
    $diaDeHoje = "$ano-$mes-$diaDeHoje";

    $meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
    $nomeMes = $meses[(int)$mes-1];

?>

<div class="box-content">
<div class="box-interna">
	<h2><i data-feather="calendar"></i> Calendário | <?php echo $nomeMes; ?>/<?php echo $ano;?></h2>

    <div class="wraper-table-col7 calendario">
	<table>
		<tr>
			<td class="title">Domingo</td>
			<td class="title">Segunda</td>
			<td class="title">Terça</td>
			<td class="title">Quarta</td>
			<td class="title">Quinta</td>
			<td class="title">Sexta</td>
            <td class="title">Sábado</td>
		</tr>

        <?php
        /*
        $numeroDias+= irá incrementar com $diaInicialdoMes
        while rodará um looping, está dizendo que enquanto o meu $n for menor ou igual a $numeroDias do mês faça isso
        Mas antes disso vou fazer uma verificação...
        Sí o meu $diaInicialdoMes for igual a 7 e $z diferente de $diaInicialdoMes significa que vou ficar com uma coluna vazia! Então quando chegar a fazer isso não irá renderizar pois já estou incrementando automaticamente os valores
        Sí minha váriavel $n % 7 == 1 (porcentagem significa o restante) ou seja, quando for o primeiro dia da semana, ta ná hora de abrir uma <tr> por que é uma nova linha que eu estou começando
        Sí o meu $z for maior ou igual a $diaInicialdoMes eu vou decrementar, pois estou encrementando no inicio e as validações também. Com isso eu já posso renderizar o meu dia por que já tenho na váriavel o valor correto
        */
        $n = 1;
        $z = 0;
        $numeroDias+=$diaInicialdoMes;
        while($n <= $numeroDias){
            if($diaInicialdoMes == 7 && $z != $diaInicialdoMes){
                $z = 7;
                $n = 8;
            }
            if($n % 7 == 1){
                echo '<tr>';
            }
            if($z >= $diaInicialdoMes){
                $dia = $n - $diaInicialdoMes;
                if($dia < 10){
                    $dia = str_pad($dia, strlen($dia)+1, "0", STR_PAD_LEFT); //Adicionando 0 antes da string (Arrumando Bug de quando o dia for menor do que 10)
                }
                $atual = "$ano-$mes-$dia";
                if($atual != $diaDeHoje){
                    echo "<td dia=\"$atual\">$dia</td>";
                }else{
                    echo '<td dia="'.$atual.'" class="hoje">'.$dia.'</td>';
                }
            }else{
                //Dias vázios antes de iniciar o mês
                echo "<td></td>";
                $z++;
            }
            //Quando for o último dia da semana
            if($n % 7 == 0){
                echo '</tr>';
            }
            //Fechar looping
            $n++;
        }
        ?>

	</table>
	</div>
    
</div><!--box-interna-->

    
<div class="box-interna">
    <form method="post" action="<?php echo INCLUDE_PATH_PAINEL ?>ajax/calendario.php">
        <h2>Adicionar tarefa para <?php echo date('d/m/Y',time()); ?></h2>
        <input type="text" name="tarefa">
        <input type="hidden" name="data" value="<?php echo date('Y-m-d'); ?>" />
        <input type="hidden" name="acao" value="inserir">
        <input type="submit" value="Cadastrar">
    </form>
</div><!--box-interna-->

    <div class="box-interna">

        <div class="box-tarefas">
            <h2>Tarefas de <?php echo date('d/m/Y',time()) ?></h2>
        <div class="tarefas-boxes">
        <?php
        $pegarTarefas = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.agenda` WHERE data = '$diaDeHoje' ORDER BY id DESC");
        $pegarTarefas->execute();
        $pegarTarefas = $pegarTarefas->fetchAll();
        foreach ($pegarTarefas as $key => $value){
        ?>
            <div class="box-tarefa-single">
                <p><?php echo $value['tarefa']; ?></p>
            </div>
            <?php } ?>
        </div>

    </div><!--box-interna-->
</div><!--box-content-->