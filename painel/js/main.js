$(function(){

	var open  = true;
	var windowSize = $(window)[0].innerWidth;

	var targetSizeMenu = (windowSize <= 400) ? 200 : 250;

	$('.menu-btn').click(function(){
		$('.aside-menu').slideToggle('slow',function(){});
		$('.conteudo-geral').css('width','100vw');
	})

	$('[formato=data]').mask('99/99/9999');

	$('[actionBtn=delete]').click(function(){
			var txt;
			var r = confirm("Deseja excluir o registro?");
			if (r == true) {
			    return true;
			} else {
			    return false;
			}
	})

	const temaDark = document.getElementById('temaDark');
	const temaLight = document.getElementById('temaLight');
	temaDark.addEventListener('click', (e)=>{
		document.documentElement.setAttribute('data-theme','light');
		temaDark.style.display="none";
		temaLight.style.display="inline-block";
	});

	temaLight.addEventListener('click', (e)=>{
		document.documentElement.setAttribute('data-theme','dark');
		temaDark.style.display="inline-block";
		temaLight.style.display="none";
	});

    var toggleMenu = document.querySelectorAll('.menuAside');
    var asideMobile = document.querySelector('.aside-menu');

    for(var i = 0; i < toggleMenu.length; i++){
    toggleMenu[i].addEventListener('click', menuAction);
    }

    function menuAction(){
        if(asideMobile.classList.contains('hide')){
            asideMobile.classList.remove('hide');
        }else{
            asideMobile.classList.add('hide');
        }
    }

})