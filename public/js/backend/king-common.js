$(document).ready(function(){

	/************************
	/*	MAIN NAVIGATION
	/************************/

	$('.main-menu .js-sub-menu-toggle').click( function(e){

		e.preventDefault();

		$li = $(this).parents('li');
		if( !$li.hasClass('active')){
			$li.find('.toggle-icon').removeClass('fa-angle-left').addClass('fa-angle-down');
			$li.addClass('active');
		}
		else {
			$li.find('.toggle-icon').removeClass('fa-angle-down').addClass('fa-angle-left');
			$li.removeClass('active');
		} 
	
		$li.find('.sub-menu').slideToggle(300);
	});

	$('.js-toggle-minified').clickToggle(
		function() {
			$('.left-sidebar').addClass('minified');
			$('.content-wrapper').addClass('expanded');

			$('.left-sidebar .sub-menu')
			.css('display', 'none')
			.css('overflow', 'hidden'); 
			
			$('.sidebar-minified').find('i.fa-angle-left').toggleClass('fa-angle-right');
		},
		function() {
			$('.left-sidebar').removeClass('minified');
			$('.content-wrapper').removeClass('expanded');
			$('.sidebar-minified').find('i.fa-angle-left').toggleClass('fa-angle-right');
		}
	);

	// main responsive nav toggle
	$('.main-nav-toggle').clickToggle(
		function() {
			$('.left-sidebar').slideDown(300)
		},
		function() {
			$('.left-sidebar').slideUp(300);
		}
	);


	//*******************************************
	/*	LIVE SEARCH
	/********************************************/

	$mainContentCopy = $('.main-content').clone();
	$('.searchbox input[type="search"]').keydown( function(e) {
		var $this = $(this);
		
		setTimeout(function() {
			var query = $this.val();
			
			if( query.length > 2 ) {
				var regex = new RegExp(query, "i");
				var filteredWidget = [];

				$('.widget-header h3').each( function(index, el){
					var matches = $(this).text().match(regex);

					if( matches != "" && matches != null ) {
						filteredWidget.push( $(this).parents('.widget') );
					}
				});
				
				if( filteredWidget.length > 0 ) {
					$('.main-content .widget').hide();
					$.each( filteredWidget, function(key, widget) {
						widget.show();
					});
				}else{
					console.log('widget not found');
				}
			}else {
				$('.main-content .widget').show();
			}
		}, 0);
	});

	// widget remove
	$('.widget .btn-remove').click(function(e){

		e.preventDefault();
		$(this).parents('.widget').fadeOut(300, function(){
			$(this).remove();
		});
	});

	// widget toggle expand
	$('.widget .btn-toggle-expand').clickToggle(
		function(e) {
			e.preventDefault();
			$(this).parents('.widget').find('.widget-content').slideUp(300);
			$(this).find('i.fa-chevron-up').toggleClass('fa-chevron-down');
		},
		function(e) {
			e.preventDefault();
			$(this).parents('.widget').find('.widget-content').slideDown(300);
			$(this).find('i.fa-chevron-up').toggleClass('fa-chevron-down');
		}
	);

	// widget focus
	$('.widget .btn-focus').clickToggle(
		function(e) {
			e.preventDefault();
			$(this).find('i.fa-eye').toggleClass('fa-eye-slash');
			$(this).parents('.widget').find('.btn-remove').addClass('link-disabled');
			$(this).parents('.widget').addClass('widget-focus-enabled');
			$('<div id="focus-overlay"></div>').hide().appendTo('body').fadeIn(300);

		},
		function(e) {
			e.preventDefault();
			$theWidget = $(this).parents('.widget');
			
			$(this).find('i.fa-eye').toggleClass('fa-eye-slash');
			$theWidget.find('.btn-remove').removeClass('link-disabled');
			$('body').find('#focus-overlay').fadeOut(function(){
				$(this).remove();
				$theWidget.removeClass('widget-focus-enabled');
			});
		}
	);


	/************************
	/*	WINDOW RESIZE
	/************************/

	$(window).bind("resize", resizeResponse);

	function resizeResponse() {

		if( $(window).width() < (992-15)) {
			if( $('.left-sidebar').hasClass('minified') ) {
				$('.left-sidebar').removeClass('minified');
				$('.left-sidebar').addClass('init-minified');
			}

		}else {
			if( $('.left-sidebar').hasClass('init-minified') ) {
				$('.left-sidebar')
				.removeClass('init-minified')
				.addClass('minified');
			}
		}
	}


	/************************
	/*	BOOTSTRAP TOOLTIP
	/************************/

	$('body').tooltip({
		selector: "[data-toggle=tooltip]",
		container: "body"
	});


	/************************
	/*	BOOTSTRAP ALERT
	/************************/

	$('.alert .close').click( function(e){
		e.preventDefault();
		$(this).parents('.alert').fadeOut(300);
	});


	/************************
	/*	BOOTSTRAP POPOVER
	/************************/

	$('.btn-help').popover({
		container: 'body',
		placement: 'top',
		html: true,
		title: '<i class="fa fa-book"></i> Help',
		content: "Help summary goes here. Options can be passed via data attributes <code>data-</code> or JavaScript. Please check <a href='http://getbootstrap.com/javascript/#popovers'>Bootstrap Doc</a>"
	});

	$('.demo-popover1 #popover-title').popover({
		html: true,
		title: '<i class="fa fa-cogs"></i> Popover Title',
		content: 'This popover has title and support HTML content. Quickly implement process-centric networks rather than compelling potentialities. Objectively reinvent competitive technologies after high standards in process improvements. Phosfluorescently cultivate 24/365.'
	});

	$('.demo-popover1 #popover-hover').popover({
		html: true,
		title: '<i class="fa fa-cogs"></i> Popover Title',
		trigger: 'hover',
		content: 'Activate the popover on hover. Objectively enable optimal opportunities without market positioning expertise. Assertively optimize multidisciplinary benefits rather than holistic experiences. Credibly underwhelm real-time paradigms with.'
	});

	$('.demo-popover2 .btn').popover();
	

	/*****************************
	/*	WIDGET WITH AJAX ENABLE
	/*****************************/

	$('.widget-header-toolbar .btn-ajax').click( function(e){
		e.preventDefault();
		$theButton = $(this);

		$.ajax({
			url: 'php/widget-ajax.php',
			type: 'POST',
			dataType: 'json',
			cache: false,
			beforeSend: function(){
				$theButton.prop('disabled', true);
				$theButton.find('i').removeClass().addClass('fa fa-spinner fa-spin');
				$theButton.find('span').text('Loading...');
			},
			success: function( data, textStatus, XMLHttpRequest ) {
				
				setTimeout( function() {
					getResponseAction($theButton, data['msg'])
				}, 1000 );
				/* setTimeout is used for demo purpose only */

			},
			error: function( XMLHttpRequest, textStatus, errorThrown ) {
				console.log("AJAX ERROR: \n" + errorThrown);
			}
		});
	});
	
	function getResponseAction(theButton, msg){

		$('.widget-ajax .alert').removeClass('alert-info').addClass('alert-success')
		.find('span').text( msg );

		$('.widget-ajax .alert').find('i').removeClass().addClass('fa fa-check-circle');

		theButton.prop('disabled', false);
		theButton.find('i').removeClass().addClass('fa fa-floppy-o');
		theButton.find('span').text('Update');
	}


	/**************************************
	/*	MULTISELECT/SINGLESELECT DROPDOWN
	/**************************************/

	if( $('.widget-header .multiselect').length > 0 ) {

		$('.widget-header .multiselect').multiselect({
			dropRight: true,
			buttonClass: 'btn btn-warning btn-sm'
		});
	}


	//*******************************************
	/*	DASHBOARD REMINDER
	/********************************************/

	if( $('.today-reminder').length > 0 ) {
		var count = 0;
		var timer;
		var ringSound = new Audio();

		if ( navigator.userAgent.match("Firefox/") ) {
			ringSound.src = "/audio/backend/bell-ringing.ogg";
		}else {
			ringSound.src = "/audio/backend/bell-ringing.mp3";
		}
		
		function ringIt() {
			if( count < 3)	{ // adjust it with the css ring animation at .today-reminder

				// sound setting saved on localStorage as 0 or 1, by default sound on (null value on localStorage)
				$globalVolume = localStorage.getItem('global-volume');

				if( ($globalVolume == null || $globalVolume == '1' ) ) {
					ringSound.play();
				}

				timer = setTimeout( ringIt, 8000); // adjust it with the css ring animation at .today-reminder
				count++;
			}
		}

		ringIt();
	}
	

	//*******************************************
	/*	SWITCH INIT
	/********************************************/

	if( $('.bs-switch').length > 0 ) {
		$('.bs-switch').bootstrapSwitch();
	}

	/* set minimum height for the left content wrapper, demo purpose only  */
	if( $('.demo-only-page-blank').length > 0 ) {
		$('.content-wrapper').css('min-height', $('.wrapper').outerHeight(true) - $('.top-bar').outerHeight(true));
	}

	
	/************************
	/*	TOP BAR
	/************************/

	if( $('.top-general-alert').length > 0 ) {

		if(localStorage.getItem('general-alert') == null) {
			$('.top-general-alert').delay(800).slideDown('medium');
			$('.top-general-alert .close').click( function() {
				$(this).parent().slideUp('fast');
				localStorage.setItem('general-alert', 'closed');
			});
		}
	}

	$btnGlobalvol = $('.btn-global-volume');
	$theIcon = $btnGlobalvol.find('i');

	// check global volume setting for each loaded page
	checkGlobalVolume($theIcon, localStorage.getItem('global-volume'));

	$btnGlobalvol.click( function() {
			var currentVolSetting = localStorage.getItem('global-volume');
			// default volume: 1 (on)
			if(currentVolSetting == null || currentVolSetting == "1") {
				localStorage.setItem('global-volume', 0);
			} else {
				localStorage.setItem('global-volume', 1);
			}

			checkGlobalVolume($theIcon, localStorage.getItem('global-volume'));
		}
	);

	function checkGlobalVolume(iconElement, vSetting) {
		if(vSetting == null || vSetting == "1") {
			iconElement.removeClass('fa-volume-off').addClass('fa-volume-up');
		} else {
			iconElement.removeClass('fa-volume-up').addClass('fa-volume-off');
		}
	}


	//*******************************************
	/*	SELECT2
	/********************************************/

	if( $('.select2').length > 0) {
		$('.select2').select2();
	}

	if( $('.select2-multiple').length > 0) {
		$('.select2-multiple').select2();
	}

});

// toggle function
$.fn.clickToggle = function( f1, f2 ) {
	return this.each( function() {
		var clicked = false;
		$(this).bind('click', function() {
			if(clicked) {
				clicked = false;
				return f2.apply(this, arguments);
			}

			clicked = true;
			return f1.apply(this, arguments);
		});
	});

}