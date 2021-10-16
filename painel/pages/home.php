<?php
	$usuariosOnline = Painel::listarUsuariosOnline();

	$pegarVisitasTotais = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas`");
	$pegarVisitasTotais->execute();

	$pegarVisitasTotais = $pegarVisitasTotais->rowCount();

	$pegarVisitasHoje = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas` WHERE dia = ?");
	$pegarVisitasHoje->execute(array(date('Y-m-d')));

	$pegarVisitasHoje = $pegarVisitasHoje->rowCount();
?>
<section class="metricas">
<div class="box-content">
		<div class="box-metricas">
			<div class="box-metrica-single">
				<div class="box">
					<h3>Usuários Online</h3>
					<p><?php echo count($usuariosOnline); ?></p>
					<span><i data-feather="corner-down-right"></i> Total de usuários online</span>
				</div><!--box-->
				<div class="box-segundo">
					<span><i data-feather="eye"></i></span>
				</div><!--box-segundo-->
			</div><!--box-metrica-single-->

			<div class="box-metrica-single">
				<div class="box">
					<h3>Total de Visitas</h3>
					<p><?php echo $pegarVisitasTotais; ?></p>
					<span><i data-feather="corner-down-right"></i> Total de sessões</span>
				</div><!--box--->
				<div class="box-segundo">
					<span><i data-feather="mouse-pointer"></i></span>
				</div><!--box-segundo-->
			</div><!--box-metrica-single-->

			<div class="box-metrica-single">
				<div class="box">
					<h3>Visitas Hoje</h3>
					<p><?php echo $pegarVisitasHoje; ?></p>
					<span><i data-feather="corner-down-right"></i> Total de sessões por hoje</span>
				</div><!--box-->
				<div class="box-segundo">
					<span><i data-feather="users"></i></span>
				</div><!--box-segundo-->
			</div><!--box-metrica-single-->

			<div class="clear"></div>
		</div><!--box-metricas-->
</div><!--box-content-->

<div class="box-content">
<div class="box-interna">
<h2>Usuários Online no Site</h2>
	<div class="table-responsive">
		<div class="row">
			<div class="col">
				<span>IP</span>
			</div><!--col-->
			<div class="col">
				<span>Última Ação</span>
			</div><!--col-->
			<div class="clear"></div>
		</div><!--row-->
		<?php
			foreach ($usuariosOnline as $key => $value) {
		?>
		<div class="row">
			<div class="col">
				<span><?php echo $value['ip'] ?></span>
			</div><!--col-->
			<div class="col">
				<span><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao'])) ?></span>
			</div><!--col-->
			<div class="clear"></div>
		</div><!--row-->
		<?php } ?>
	</div><!--table-responsive-->
</div><!--box-interna-->
</div><!--box-content-->

<div class="box-content">
<div class="box-interna">
<h2>Usuários do Painel</h2>

	<div class="table-responsive">
		<div class="row">
			<div class="col">
				<span>Nome</span>
			</div><!--col-->
			<div class="col">
				<span>Cargo</span>
			</div><!--col-->
			<div class="clear"></div>
		</div><!--row-->

		<?php
			$usuariosPainel = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios`");
			$usuariosPainel->execute();
			$usuariosPainel = $usuariosPainel->fetchAll();
			foreach ($usuariosPainel as $key => $value) {

		?>
		<div class="row">
			<div class="col">
				<span><?php echo $value['user'] ?></span>
			</div><!--col-->
			<div class="col">
				<span><?php echo pegaCargo($value['cargo']); ?></span>
			</div><!--col-->
			<div class="clear"></div>
		</div><!--row-->
		<?php } ?>
	</div><!--table-responsive-->
</div><!--box-interna-->
</div><!--box-content-->
</section><!--metricas-->
