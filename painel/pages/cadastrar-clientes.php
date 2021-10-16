<?php
    verificaPermissaoPagina(2);
?>
<div class="box-content">
<div class="box-interna">
    <h2><i data-feather="user-plus"></i>Adicionar novo Cliente</h2>
    <form method="post" class="ajax" action="<?php echo INCLUDE_PATH_PAINEL ?>ajax/forms.php" enctype="multipart/form-data">

        <label>Nome:</label>
        <input type="text" name="nome">

        <label>Email:</label>
        <input type="text" name="email">

        <label>Tipo:</label>
        <select name="tipo_cliente">
            <option value="fisico">Físico</option>
            <option value="juridico">Jurídico</option>
        </select>

        <div ref="cpf">
        <label>CPF</label>
        <input type="text" name="cpf">
        </div>

        <div ref="cnpj" style="display:none;">
        <label>CNPJ</label>
        <input type="text" name="cnpj">
        </div>

        <label>Imagem:</label>
        <input type="file" name="imagem">

        <input type="hidden" name="tipo_acao" value="cadastrar_cliente">
        <input type="submit" name="acao" value="Cadastrar!">

    </form>

</div><!--box-interna-->
</div><!--box-content-->