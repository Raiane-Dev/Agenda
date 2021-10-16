<?php
	if(isset($_GET['loggout'])){
		Painel::loggout();
	}
?>
<!DOCTYPE html>
<html data-theme="dark">
<head>
	<title>Painel de Controle</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>estilo/font-awesome.min.css">
	<script src="https://unpkg.com/feather-icons"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
	<link href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css" rel="stylesheet" />
</head>
<body>

<base base="<?php echo INCLUDE_PATH_PAINEL; ?>">

<main class="main">
<section class="aside-menu hide">
	<div class="menu">
		
	<div class="box-usuario">
		<?php
			if($_SESSION['img'] == ''){
		?>
		<?php }else{ ?>
			<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $_SESSION['img']; ?>" />
		<?php } ?>
		<div class="nome-usuario">
			<p><?php echo $_SESSION['nome']; ?></p>
		</div><!--nome-usuario-->
		<a href="<?php echo INCLUDE_PATH_PAINEL ?>?loggout"><i data-feather="log-out"></i></a>
	</div><!--box-usuario-->

	<div class="items-menu">
		<ul>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('cadastrar-depoimento'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-depoimento"><i data-feather="message-square"></i> Cadastrar Depoimento</a></li>
		<li><a <?php selecionadoMenu('cadastrar-servico'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-servico"><i data-feather="briefcase"></i> Cadastrar Serviço</a></li>
		<li><a <?php selecionadoMenu('cadastrar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-slides"><i data-feather="image"></i> Cadastrar Slides</a></li>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('listar-depoimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos"><i data-feather="bookmark"></i> Listar Depoimentos</a></li>
		<li><a <?php selecionadoMenu('listar-servicos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos"><i data-feather="book-open"></i> Listar Serviços</a></li>
		<li><a <?php selecionadoMenu('listar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides"><i data-feather="book"></i> Listar Slides</a></li>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('editar-usuario'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-usuario"><i data-feather="user"></i> Editar Usuário</a></li>
		<li><a <?php selecionadoMenu('adicionar-usuario'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>adicionar-usuario"><i data-feather="user-plus"></i> Adicionar Usuário</a></li>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('editar-site'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-site"><i data-feather="settings"></i> Editar Site</a></li>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('cadastrar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-categorias"><i data-feather="tag"></i> Cadastrar Categorias</a></li>
		<li><a <?php selecionadoMenu('gerenciar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categorias"><i data-feather="tablet"></i> Gerenciar Categorias</a></li>
		<li><a <?php selecionadoMenu('cadastrar-noticia'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-noticia"><i data-feather="edit"></i> Cadastrar Notícias</a></li>
		<li><a <?php selecionadoMenu('gerenciar-noticias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticias"><i data-feather="edit-3"></i> Gerenciar Notícias</a></li>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('cadastrar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-clientes"><i data-feather="users"></i> Cadastrar Clientes</a></li>
		<li><a <?php selecionadoMenu('gerenciar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-clientes"><i data-feather="folder-plus"></i> Gerenciar Clientes</a></li>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('visualizar-pagamentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos"><i data-feather="credit-card"></i> Visualizar Pagamentos</a></li>
		<h3>Gestão de Serviçõs</h3>
		<li><a <?php selecionadoMenu('cadastrar-produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-produtos"><i data-feather="box"></i> Cadastrar Produtos</a></li>
		<li><a <?php selecionadoMenu('visualizar-produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos"><i data-feather="archive"></i> Visualizar Produtos</a></li>
		</ul>
	</div><!--items-menu-->
</div><!--menu-->
</section><!--aside-menu-->

<section class="conteudo-geral">

<header>
<div class="area-menu">
		<input type="search" /><i data-feather="search"></i>
</div><!--area-menu-->

	<div class="area-menu">
		<div class="loggout">
			<a <?php if(@$_GET['url'] == 'calendarios')?> href="<?php echo INCLUDE_PATH_PAINEL?>calendario"><i data-feather="calendar"></i></a>
			<a <?php if(@$_GET['url'] == 'chat')?> href="<?php echo INCLUDE_PATH_PAINEL?>chat"><i data-feather="message-circle"></i></a>
			<a class="menuAside"><i data-feather="menu"></i></a>
			<a href=""><i data-feather="home"></i></a>
			<a id="temaDark" name="theme" <?php if(@$_GET['url'] == ''){ ?> <?php } ?>><i data-feather="moon"></i></a>
			<a id="temaLight" name="theme" <?php if(@$_GET['url'] == ''){ ?> <?php } ?>><i data-feather="sun"></i></a>
			<a href=""><i data-feather="settings"></i></a>
		</div><!--loggout-->
	</div><!--area-menu-->
</header>

	<div class="conteudo">
		<?php Painel::carregarPagina(); ?>
	</div><!--conteudo-->
</section><!--conteudo-geral-->

</main><!--main-->

<script>
    feather.replace()
</script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL ?>js/ajax.js"></script>
<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.ajaxform.js"></script>
<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL ?>js/constants.js"></script>
<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL ?>js/main.js"></script>
<script type="text/javascript" src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>
  tinymce.init({ 
  	selector:'.tinymce',
  	plugins: "image",
  	height:300
   });
  </script>
  <script src="<?php echo INCLUDE_PATH_PAINEL ?>js/HelpMask.js"></script>
  <?php Painel::loadJS(array('ajax.js'),'gerenciar-clientes'); ?>
  <?php Painel::loadJS(array('ajax.js'),'cadastrar-cliente'); ?>
  <?php Painel::loadJS(array('ajax.js'),'editar-cliente'); ?>
  <?php Painel::loadJS(array('controleFinanceiro.js'),'editar-cliente'); ?>
  <?php Painel::loadJS(array('chat.js'),'chat'); ?>
  <?php Painel::loadJS(array('calendario.js'),'calendario'); ?>
</body>
</html>