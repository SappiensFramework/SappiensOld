var urlStatic = "//localhost/Sappiens/Static/"; //dev.local
//var urlStatic = "//team.sappiens.com.br/alpha/Sappiens/Static/"; //alpha
//var urlStatic = "//team.sappiens.com.br/beta/Sappiens/Static/"; //beta

var init = [];
init.push(function () {
	var $div = $('<div id="signin-demo" class="hidden-xs"><div>IMAGEM DE FUNDO</div></div>'),
	    bgs  = [ urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-1.jpg', 
	    		 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-2.jpg', 
	    		 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-3.jpg',
	    		 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-4.jpg', 
	    		 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-5.jpg', 
	    		 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-6.jpg',
				 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-7.jpg', 
				 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-8.jpg', 
				 urlStatic+'PixelAdmin/1.3.0/assets/demo/signin-bg-9.jpg' ];
	for (var i=0, l=bgs.length; i < l; i++) $div.append($('<img src="' + bgs[i] + '">'));
	$div.find('img').click(function () {
		var img = new Image();
		img.onload = function () {
			$('#page-signin-bg > img').attr('src', img.src);
			$(window).resize();
		}
		img.src = $(this).attr('src');
	});
	$('body').append($div);
});