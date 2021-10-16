$(function(){
    $('td[dia]').click(function(){
        $('td').removeClass('hoje');
        $(this).addClass('hoje');

        var novoDia = $(this).attr('dia').split('-');
        var novoDia = novoDia[2]+'/' + novoDia[1]+'/' + novoDia[0];
        trocarDatas($(this).attr('dia'),novoDia);

        aplicarEventos($(this).attr('dia'));
    })

    $('form').ajaxForm({
        dataType: 'json',
        success:function(data){
            $('.box-alert').remove();
            $('form h2').after('<div class="box-alert sucesso">O evento foi adicionado com sucesso</div>');
            $('.box-tarefas').after('<div class="box-tarefa-single"><p>'+data.tarefa+'</p></div>');
            $('form')[0].reset();
        }
    })

    function trocarDatas(nformatado,formatado){
        $('input[name=data]').attr('value',nformatado);
        $('form h2').html('Adicionar tarefa para: '+ formatado);
        $('.box-tarefas h2').html('Adicionar tarefa para: '+ formatado);
    }

    function aplicarEventos(data){
        $('.box-tarefa-single').remove();
        $.ajax({
            url:include_path+'ajax/calendario.php',
            method:'post',
            data:{'data':data,'acao':'puxar'}
        }).done(function(data){
            $('.box-tarefa-single').after(data);
        })
    }
})