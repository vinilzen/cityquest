var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
window.mobilecheck = function() {
var check = false;
(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
return check; }


$(function() {


	$('.ico-pay').tooltip();

	if ($('#bgr_video').length) {

		function set_video_bgr() {
			if (document.body.clientWidth < 1025) {
				$('#bgr_video').hide();
			} else {
				var w = $('.jumbotron').outerWidth(),
					video = document.getElementById('bgr_video');

				video.addEventListener('loadeddata', function() {
					$('.jumbotron').css('backgroud', 'none');
					$('#bgr_video')
						.css({
							width: '100%',
							height: 'auto',
							display: 'block',
						});
				}, false);

				video.src = '/img/Comp_1_3_1.mp4';
				video.load();
			}
		}

		set_video_bgr();
	}

	var supportsOrientationChange = "onorientationchange" in window,
		orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

	window.addEventListener(orientationEvent, function() {

		if ($('#bgr_video').length) {
			set_video_bgr();
		}

		if (document.body.clientWidth < 1024) {
			$('#top_menu').appendTo('#top_menu_container');
			$('#top_menu').hide();

			if (document.body.clientWidth > 767) {

				if ($('#for-login-pl').text() == '') {
					$('.ico-lock').appendTo('#for-login-pl').show();
					$('#for-login').html('');
				}
				if ($('#for-city').text() == '') {
					$('.city-select').appendTo('#for-city').css('display', 'inline-block');
					$('#for-select-city').html('');
				}
			} else {
				$('.city-select, .ico-lock').hide();
			}
		}

		$('#myModalMenu').modal('hide');
	});


	$('#show-menu').click(function() {

		if (document.body.clientWidth < 768) {
			if ($('#for-select-city').text() == '') {
				$('.city-select').show().appendTo('#for-select-city');
				$('#for-city').html('');
			}

			if ($('#for-login').text() == '') {
				$('.ico-lock').show().css('display', 'inline-block').appendTo('#for-login');
				$('#for-login-pl').html('');
			}
		} else {
			if ($('#for-login-pl').text() == '') {
				$('.ico-lock').hide().appendTo('#for-login-pl');
				$('#for-login').html('')
			}
			if ($('#for-city').text() == '') {
				$('.city-select').hide().appendTo('#for-city');
				$('#for-select-city').html('');
			}
		}

		if ($('#myModalMenu #for-menu').text() == '') {
			$('#top_menu').show().appendTo('#myModalMenu #for-menu');
		}

		$('#myModalMenu').modal('toggle');
	});


	$('.curent_date').click(function() {
		$('.curent_date').removeClass('active');
		$(this).addClass('active');
	});


	if (window.mobilecheck()) {

		$('.calendar_container').css('overflow', 'auto');
		

		$('.move-right').click(function(){
			var step = $('.calendar_container').width();
			$( ".calendar_container" ).scrollTo( '+='+step, 300 );
		});


		$('.move-left').click(function(){
			var step = $('.calendar_container').width();
			$( ".calendar_container" ).scrollTo( '-='+step, 300);
		});			

	} else {

		$('.move-right').click(function(){

			var step = $('.calendar_container').width(),
				ml = parseInt($('.calendar').css('margin-left')) - step,
				sum_w = 0;

			$.each($('.curent_date'), function(i, el){ sum_w += $(el).outerWidth(); });

			if ( -sum_w <= ml  ) $('.calendar').animate({ 'margin-left': '-='+step });
		});

		$('.move-left').click(function(){
			var step = $('.calendar_container').width(),
				ml = parseInt($('.calendar').css('margin-left'));

			if ( ml < 0 ) $('.calendar').animate({ 'margin-left': '+='+step });
		});		
	}

	$('#myModalBook').on('shown.bs.modal', function (e) {
		if (document.body.clientWidth > 768) {
			var h = $('#myModalBook .img-responsive').height();
			$('.shad').height(h);
		}
	});


	$('#myModalAuth .modal-title').click(function(){
		$('#myModalAuth .modal-title').removeClass('active');
		$(this).addClass('active');
	});

	var ModalBook = $('#myModalBook'), book_data = 0, btn_time;

	$('.btn.btn-q').click(function(e){
		btn_time = $(e.target);
		book_data = {
			quest_id : btn_time.attr('data-quest'),
			addres : $('.addr-quest').text() || $('#quest_addr_'+btn_time.attr('data-quest')).val(),
			title : $('#quest_title').text() || $('#quest_title_'+btn_time.attr('data-quest')).text(),
			day : btn_time.attr('data-day'),
			ymd : btn_time.attr('data-ymd'),
			d : btn_time.attr('data-d'),
			m : btn_time.attr('data-m'),
			time : btn_time.attr('data-time'),
			price : btn_time.attr('data-price'),
			phone : user_phone, 
			name : user_name,
			comment : ' ',
		};

		$('img', ModalBook).attr('src', '/images/q/'+book_data.quest_id+'.jpg');
		$('.addr-to', ModalBook).html('<i class="ico-loc"></i>'+book_data.addres);
		$('h2', ModalBook).html('<i class="ico-loc"></i>'+book_data.title);
		$('.book_time', ModalBook).html(
			'<small>'+book_data.day+'</small>'+
			'<span>'+book_data.d+'.'+book_data.m+'</span><em>в</em><span>'+book_data.time+'</span>');

		$('.price', ModalBook).html( book_data.price +'<em class="rur"><em>руб.</em></em>');
		$('.you_phone a', ModalBook).html(user_phone);

		ModalBook.modal('show');
	});

	$('.btn', ModalBook).click(function(e) {

		var btn_book = $(e.target);
		if (book_data!=0)
			$.post('/booking/create',
				book_data,
				function(result){
					
					if (result && result.success) {

						ModalBook.modal('hide');
						
						btn_time.attr({
								'disabled':'disabled',
								'data-toggle':"tooltip",
								'data-delay':"4000",
								'title': 'Квест успешно забронирован',
							})
							.tooltip({
								delay:{ show: 2000, hide: 3000 }
							})
							.tooltip('show')
							.addClass('myDate');

						setTimeout(function(){ btn_time.tooltip("hide"); }, 3000);

					} else {

						if (result && result.message) {

							btn_book
								.attr({
									'data-toggle':"tooltip",
									'title': result.message,
								})
								.tooltip('show');
						}

						alert('Ошибка!');
					}
				}
			);
		else console.log('пустой book_data');

		return false;

	});

	$('#reg-form').submit(function(){

		if ( $('#reg-name').val() !== '' && $('#reg-name').val().length > 2 ) {
			if ( $('#reg-email').val() !== '' && re.test( $('#reg-email').val() ) ) {
				if ( $('#reg-phone').val() !== '' && $('#reg-phone').val().length > 5 ) {
					if ( $('#reg-pass').val() !== '' && $('#reg-pass').val().length > 4 ) {
						if ( $('#reg-rules').is(':checked') ) {

		$.post(
			"/user/registration",
			{
				name : $('#reg-name').val(),
				email : $('#reg-email').val(),
				phone : $('#reg-phone').val(),
				pass : $('#reg-pass').val(),
			},
			function( data ) {
				if (data.error && data.error == 1) {
					
					if (data.msg) alert(data.msg);
					
					console.log(data);

				} else if (data.success && data.success == 1) {

					$('#auth-tab').click();
					
					if (data.msg) alert(data.msg);

				}
			}
		);

						} else alert('Чтобы зарегистрироваться, нужно принять наши условия пользования');
					} else alert('Пароль должен содержать более 4 символов');
				} else alert('Некорректный или неуказан номер телефона');
			} else alert('Некорректный email');
		} else alert('Имя должно содержать более 2 символов');

		return false;
	});

	$('#auth-form').submit(function(){

		if ( $('#auth-email').val() !== '' && $('#auth-email').val().length > 3 ) {
			if ( $('#auth-pass').val() !== '' && $('#auth-pass').val().length > 3 ) {

		$.post( "/user/login",
			{ 
				'UserLogin[username]' : $('#auth-email').val(), 
				'UserLogin[password]' : $('#auth-pass').val()
			},
			function( data ) {
				console.log(data);
			
				if (data.error && data.error == 1) {
					
					if (data.msg) alert(data.msg);

					if (data.msg && data.msg == 'Вы уже авторизованы!') {
						$('#myModalAuth').modal('hide');
						location.reload();
					}

				} else if (data.success && data.success == 1) {
			
					if (data.msg) alert(data.msg);
						$('#myModalAuth').modal('hide');
					
					location.reload();

				}
			}
		);

			} else {

				$('#form-group-username-auth').removeClass('input-error');
				$('#form-group-username-auth span').tooltip('destroy');

				$('#form-group-pass-auth').addClass('input-error');
				$('#form-group-pass-auth span')
					.attr({ 'title': 'Неверный логин или пароль' })
					.on('shown.bs.tooltip', function () {
						$('.tooltip-arrow').attr('style','');
						$('.tooltip').css('left', $('.tooltip').position().left+12);
					})
					.tooltip('show');
			}
		} else {
			$('#form-group-username-auth').addClass('input-error');
			$('#form-group-username-auth span')
				.attr({ 'title': 'Некорректное имя' })
				.on('shown.bs.tooltip', function () {
					$('.tooltip-arrow').attr('style','');
					$('.tooltip').css('left', $('.tooltip').position().left+12);
				})
				.tooltip('show');
		}

		return false;
	});


	$('.decline-book').click(function(e){

		var btn_decline = $(e.target),
			book_id = btn_decline.attr('data-book-id');

		if(confirm('Отменить бронь?')){

			$.post('/booking/decline', {
				id: book_id
			}, function(result){
				if (result && result.success) {

					btn_decline
						.attr({
							'data-toggle':"tooltip",
							'title': 'Бронирование отменено',
						})
						.tooltip('show');


					$('#row_fade_'+book_id).animate({height:0}, 600, function() {
						$('#row_fade_'+book_id).remove();
					});
					$('#row_book_'+book_id).animate({height:0}, 600, function() {
						$('#row_book_'+book_id).remove();
					});

				} else {

					btn_decline
						.attr({
							'data-toggle':"tooltip",
							'title': 'Произошла ошибка, свяжитесь с администрацией',
						})
						.tooltip('show');
				}
			});
		}
	});


	$('#edit-form').submit(function(){

		var name = $('#edit-name').val(),
			btn_edit = $('#editProfile'),
			phone = $('#edit-phone').val();
		
		$.post('/user/profile/edit', {
			username: name,
			phone: phone,
		}, function(result){
						
			if (result && result.success) {

				btn_edit
					.attr({
						'title': result.message,
					})
					.tooltip('show');

				$('.cabinet .name').html(name);
				$('.cabinet .phone').html(phone);

				setTimeout(function(){
					$('#myModalEditProfile').modal('hide');
					$('#editProfile').tooltip('destroy');
				}, 2000);

			} else {

				btn_edit
					.attr({
						'data-toggle':"tooltip",
						'title': 'Произошла ошибка, свяжитесь с администрацией',
					})
					.tooltip('show');

				if (result && result.errors) {
					if (result.errors.username) {
						$('#form-group-username').addClass('input-error');
						$('#form-group-username span')
							.attr({ 'title': result.errors.username.join(', ') })
							.tooltip('show');
					}
					if (result.errors.phone) {
						$('#form-group-phone').addClass('input-error');
						$('#form-group-phone span')
							.attr({ 'title': result.errors.phone.join(', ') })
							.tooltip('show');
					}
				}

			}
		});

		return false;
	});

});