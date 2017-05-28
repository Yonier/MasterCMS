$(document).ready(function(){

	// by Yonier Espinosa (HabboAdictos1)

	var EXSmall = 992;

	if (window.innerWidth <= EXSmall){

		$('#Head').addClass('fixed-top');
		$('#menu-left').removeClass('navbar-toggler-left');
		$('#menu-right').removeClass('navbar-toggler-right');
		
		alertify.set('notifier','position', 'bottom-right');

	}
	else{

		$('#Head').removeClass('fixed-top');
		$('#menu-left').addClass('navbar-toggler-left');
		$('#menu-right').addClass('navbar-toggler-right');

		alertify.set('notifier','position', 'top-right');

	}

	$(window).resize(function(){

		if (window.innerWidth <= EXSmall){

			$('#Head').addClass('fixed-top');
			$('#menu-left').removeClass('navbar-toggler-left');
			$('#menu-right').removeClass('navbar-toggler-right');

			alertify.set('notifier','position', 'bottom-right');

		}
		else{

			$('#Head').removeClass('fixed-top');
			$('#menu-left').addClass('navbar-toggler-left');
			$('#menu-right').addClass('navbar-toggler-right');

			alertify.set('notifier','position', 'top-right');			

		}


	});	

	$('#nSlider').unslider({
      animation: 'fade',
      autoplay: true,
      arrows: false
    });

});