window.addEventListener("load", buttons);

function buttons()
{
	$('.login-btn').click(function(){
		$('.user-login-form').css('display','block'); 
		$('#forgotten-form').css('display','none');
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
	});
}
