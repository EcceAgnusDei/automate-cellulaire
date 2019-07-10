window.addEventListener("load", buttons);

function buttons()
{
	$('.login-btn').click(function(){
		$('.user-login-form').css('display','block'); 
		$('#forgotten-form').css('display','none');
		$('.signin-link').css('display','block');
		if ($('.header-forms').css('display') === 'none')
		{
			$('.header-forms').css('display','flex');
		}
		else
		{
			$('.header-forms').css('display','none');
		}
	});

	$('#forgotten-btn').click(function(){
		$('#forgotten-form').css('display','block');
		$('.user-login-form').css('display','none');   
		$('.signin-link').css('display','none');   
	});

	$("#show-artwork").click(function(){
		$(".user-comments").css('display','none');
		$(".user-artwork").css('display', 'flex');
	});

	$("#show-comments").click(function(){
		$(".user-comments").css('display','flex');
		$(".user-artwork").css('display', 'none');
	});
}
