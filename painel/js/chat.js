$(function(){

    $('.chat-mensagens').scrollTop($('.chat-mensagens-boxes')[0].scrollHeight);

	$('textarea').keyup(function(e){
		 var code = e.keyCode || e.which;
		 if(code == 13) {
		  	insertChat();
		 }
	})

	$('form').ajaxForm(function(e){
		function insertChat(){
			//Função responsável por inserir as mensagens!
			var mensagem = $('textarea').val();
			$('textarea').val('');
			$.ajax({
				url:include_path+'ajax/chat.php',
				method:'post',
				data:{'mensagem':mensagem,'acao':'inserir_mensagem'},
			}).done(function(data){
				$('.chat-mensagem-single').append(data);
				$('.chat-mensagens').scrollTop($('.chat-mensagens-boxes')[0].scrollHeight);
			})
		}
	})

	setTimeout(function(){
		function recuperarMensagens(){
			//Recuperar mensagens novas no banco de dados!
			$.ajax({
				url:include_path+'ajax/chat.php',
				method:'post',
				data:{'acao':'pegarMensagens'}
			}).done(function(data){
				$('.chat-mensagem-single').append(data);
				$('.chat-mensagens').scrollTop($('.chat-mensagens-boxes')[0].scrollHeight);
			},3000);
		}
	})




})