var asite = 'cityquest.ru',
	order_id = 0,
	price = 0;
var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
window.mobilecheck = function() {
var check = false;
(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
return check; };

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		factory(require('jquery'));
	} else {
		factory(jQuery);
	}
}(function ($) {
	var pluses = /\+/g;
	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}
	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}
	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}
	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}
		try {
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}
	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}
	var config = $.cookie = function (key, value, options) {
		if (arguments.length > 1 && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);
			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setTime(+t + days * 864e+5);
			}
			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}
		var result = key ? undefined : {};
		var cookies = document.cookie ? document.cookie.split('; ') : [];
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = parts.join('=');
			if (key && key === name) {
				result = read(cookie, value);
				break;
			}
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}
		return result;
	};
	config.defaults = {};
	$.removeCookie = function (key, options) {
		if ($.cookie(key) === undefined) {
			return false;
		}
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};
}));

$(function() {
	$('.ico-pay').tooltip();

	if ($('body').hasClass('video')) {

		function set_video_bgr() {
			if (document.body.clientWidth > 1023) {
				var w = $('.jumbotron').outerWidth();
				var $video = $('<div id="video_container" style="display:none"><video autoplay="autoplay" id="bgr_video" loop="loop"></video></div>')
						.prependTo('body.video');

				video = document.getElementById('bgr_video');
				video.addEventListener('loadeddata', function() {
					$('.jumbotron').css('backgroud', 'none');

					var jh = $('.jumbotron').outerHeight();
					
					$video
						.css({
							width:'100%',
							height:jh,
							overflow:'hidden',
							position:'absolute',
						})
						.fadeIn(2000)
						.find('video')
						.css({
							width: '100%',
							height: 'auto',
							display: 'block',
						});
				}, false);
				
				video.src = '/img/fog_bg3.mp4';
				video.load();
			}
		}

		set_video_bgr();
	}

	$('#bookgift-comment').elastic();

	var supportsOrientationChange = "onorientationchange" in window,
		orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

	window.addEventListener(orientationEvent, function() {

		// if ($('#bgr_video').length) {
		// 	set_video_bgr();
		// }

		if (document.body.clientWidth < 1024) {
			$('#top_menu').appendTo('#top_menu_container');
			$('#top_menu').hide();

			if (document.body.clientWidth > 767) {

				if ($('#for-login-pl').text() == '') {
					$('#for-login-pl .btn').appendTo('#for-login-pl').show();
					$('#for-login').html('');
				}
				if ($('#for-city').text() == '') {
					$('.city-select').appendTo('#for-city').css('display', 'inline-block');
					$('#for-select-city').html('');
				}
			} else {
				$('.city-select, #for-login-pl .btn').hide();
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
				$('#for-login-pl .btn').show().css('display', 'inline-block').appendTo('#for-login');
				$('#for-login-pl').html('');
			}
		} else {
			if ($('#for-login-pl').text() == '') {
				$('#for-login-pl .btn').hide().appendTo('#for-login-pl');
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

	$('#myModalBook').on('show.bs.modal', function (e) {
		if (user_name && user_name != '') {
			return true;
		} else {
			$('#myModalAuth').modal('show');
			return false;
		}
	});

	$('#myModalBook').on('shown.bs.modal', function(e){

		if (document.body.clientWidth > 767){
			var h = $('#myModalBook .img-responsive').height();
			$('.shad').height(h);
		}

		if ( typeof yaCounter25221941 != 'undefined') yaCounter25221941.reachGoal('openBookWindow');
		if ( typeof ga != 'undefined') ga('send', 'event', 'book', 'openWindow');
	});


	$('#myModalAuth .modal-title').click(function(){
		$('#myModalAuth .modal-title').removeClass('active');
		$(this).addClass('active');
	});

	var ModalBook = $('#myModalBook'), book_data = 0, btn_time;

	$('.btn.btn-q').click(function(e){
		if (user_phone == '00000'){
			user_phone = '';
		}
		$('.you_phone input', ModalBook).val(user_phone).mask('+7(000)-000-00-00');

		btn_time = $(e.target);

		book_data = {
			quest_id : btn_time.attr('data-quest'),
			quest_cover : btn_time.attr('data-quest-cover'),
			addres : $('.addr-quest span').text() || $('#quest_addr_'+btn_time.attr('data-quest')).val(),
			title : $('#quest_title').text() || $('#quest_title_'+btn_time.attr('data-quest')).text(),
			day : btn_time.attr('data-day'),
			ymd : btn_time.attr('data-ymd'),
			d : btn_time.attr('data-d'),
			m : btn_time.attr('data-m'),
			time : btn_time.attr('data-time'),
			price : btn_time.attr('data-price'),
			phone : $('.you_phone input').val(), 
			name : user_name,
			comment : ' ',
		};

		$('img', ModalBook).attr('src', '/images/'+book_data.quest_cover);
		$('.addr-to', ModalBook).html('<i class="ico-loc iconm-Pin"></i>'+book_data.addres);
		$('.h2', ModalBook).html(book_data.title);
		$('.book_time', ModalBook).html(
			'<small>'+book_data.day+'</small>'+
			'<span>'+book_data.d+'.'+book_data.m+'</span><em>в</em><span>'+book_data.time+'</span>');

		$('.price', ModalBook).html( book_data.price +'<em class="rur"><em>руб.</em></em> <b class="team">за команду</b>');

		ModalBook.modal('show');
	});

	$('.btn', ModalBook).click(function(e) {
		if (user_name && user_name != '') {
			book_data.phone = $('.you_phone input').val() || user_phone;
			var btn_book = $(e.target);
			if (book_data.phone == '00000' || book_data.phone == '' || book_data.phone.length != 17){
				$('.you_phone input')
					.attr({
						'data-toggle':"tooltip",
						'title': 'Необходимо указать корректный номер телефона',
					}).tooltip('show');
			} else {
				if (book_data!=0)
					$.post('/booking/create',
						book_data,
						function(result){
							if (result && result.success) {
								if ( typeof yaCounter25221941 != 'undefined') yaCounter25221941.reachGoal('confirmBook');
								if ( typeof ga != 'undefined') ga('send', 'event', 'book', 'confirmBook');
								
								// TODO admitad

								order_id = result.id;
								uid = result.uid;
								price = book_data.price;


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
										}).tooltip('show');
								}

								alert('Ошибка!');
							}
						}
					);
				else console.log('пустой book_data');
			} 
		} else {

			ModalBook.modal('hide');
			$('#myModalAuth').modal('show');

		}

		return false;

	});


	$('#reg-phone, .you_phone input, #edit-phone')
		.mask('+7(000)-000-00-00')
		.focus(function(e) {
			if ($(e.target).val() == '') $(e.target).val('+7(');
		});

	$('#form-group-reg-email input').keypress(function(){
		$('#form-group-reg-email span').tooltip('destroy');
		$('#form-group-reg-email').removeClass('input-error');
	});

	$('#form-group-reg-name input').keypress(function(){
		$('#form-group-reg-name span').tooltip('destroy');
		$('#form-group-reg-name').removeClass('input-error');
	});

	$('#form-group-reg-phone input').keypress(function(){
		$('#form-group-reg-phone span').tooltip('destroy');
		$('#form-group-reg-phone').removeClass('input-error');
	});

	$('#form-group-reg-pass input').keypress(function(){
		$('#form-group-reg-pass span').tooltip('destroy');
		$('#form-group-reg-pass').removeClass('input-error');
	});

	$('#reg-form').submit(function(){

		$('#form-group-reg-pass, #form-group-reg-email, #form-group-reg-name, #form-group-reg-phone').removeClass('input-error');
		$('#form-group-reg-email span, #form-group-reg-name span, #form-group-reg-phone span, #form-group-reg-pass span, #reg-form button').tooltip('destroy');

		if ( $('#reg-name').val() !== '' && $('#reg-name').val().length > 2 ) {
			if ( $('#reg-email').val() !== '' && re.test( $('#reg-email').val() ) ) {
				if ( $('#reg-phone').val() !== '' && $('#reg-phone').val().length == 17 ) {
					if ( $('#reg-pass').val() !== '' && $('#reg-pass').val().length > 4 ) {
						//if ( $('#reg-rules').is(':checked') ) {

						$.post(
							"/user/registration",
							{
								name : $('#reg-name').val(),
								email : $('#reg-email').val(),
								phone : $('#reg-phone').val(),
								pass : $('#reg-pass').val(),
							},
							function( data ) {

								if (data.success && data.success == 1) {

									yaCounter25221941.reachGoal('registrationSuccess');
									ga('send', 'event', 'registration', 'registrationSuccess');

									$('#reg-form button')
										.attr({ 'title': 'Вы успешно зарегистрировались' })
										.tooltip('show');

									setTimeout(function(){
										$('#reg-form button').tooltip('destroy');
										location.reload();
									}, 1000);
									

								}

								if (data && data.error && data.errors){

									if (data.errors.email){
										$('#form-group-reg-email').addClass('input-error');
										$('#form-group-reg-email span')
											.attr({ 'title': data.errors.email.join(', ') })
											.tooltip('show');
									}

									if (data.errors.username){
										$('#form-group-reg-name').addClass('input-error');
										$('#form-group-reg-name span')
											.attr({ 'title': data.errors.email.join(', ') })
											.tooltip('show');
									}
								}
							
								$('#reg-form button')
									.attr({ 'title': 'Ошибка при регистрации' })
									.tooltip('show');
							}
						);

					} else {

						$('#form-group-reg-pass').addClass('input-error');
						$('#form-group-reg-pass span')
							.attr({ 'title': 'Пароль должен содержать более 4 символов' })
							.tooltip('show');
					}
				} else {
					
					$('#form-group-reg-phone').addClass('input-error');

					$('#form-group-reg-phone span')
						.attr({ 'title': 'Некорректный или неуказан номер телефона' })
						.tooltip('show');
				}
			} else {

				$('#form-group-reg-email').addClass('input-error');

				$('#form-group-reg-email span')
					.attr({ 'title': 'Пустой или некорректный email' })
					.tooltip('show');
			} 
		} else {

			$('#form-group-reg-name').addClass('input-error');

			$('#form-group-reg-name span')
				.attr({ 'title': 'Имя не может быть пустым и должно содержать менее 2 символов' })
				.tooltip('show');
		}

		return false;
	});

	$('#form-group-username-auth input').keypress(function(){
		$('#auth-form button').tooltip('destroy');
		$('#form-group-username-auth span').tooltip('destroy');
		$('#form-group-username-auth').removeClass('input-error');
	});

	$('#form-group-pass-auth input').keypress(function(){
		$('#auth-form button').tooltip('destroy');
		$('#form-group-pass-auth span').tooltip('destroy');
		$('#form-group-pass-auth').removeClass('input-error');
	});

	$('#auth-form').submit(function(){

		$('#form-group-username-auth, #form-group-pass-auth').removeClass('input-error');

		$('#form-group-username-auth span').tooltip('destroy');
		$('#form-group-pass-auth span').tooltip('destroy');
		$('#auth-form button').tooltip('destroy');

		if ($('#auth-form button').html().toLowerCase() == 'войти') {


			if ( $('#auth-email').val() !== '') {
				if ( re.test( $('#auth-email').val() ) ) {
					$('#form-group-username-auth').removeClass('input-error');

					if ( $('#auth-pass').val() !== '' ) {

						if ( $('#auth-pass').val().length > 3 ) {

							$.post( "/user/login",
								{ 
									'UserLogin[username]' : $('#auth-email').val(), 
									'UserLogin[password]' : $('#auth-pass').val()
								},
								function( data ) {
								
									if (data.error && data.error == 1) {
										
										if (data.msg && data.msg == 'Вы уже авторизованы!') {
											$('#myModalAuth').modal('hide');
											if (window.location.pathname == '/user/login') {
												console.log('lh',window.location.pathname);
												window.location.href = '/';
											} else {
												console.log('lr', window.location.pathname);
												location.reload();
											}
										} else {
											$('#auth-form button')
												.attr({ 'title': 'Неверный логин или пароль' })
												.tooltip('show');
										}

									} else 
									if (data.success && data.success == 1) {
									
										$('#auth-form button')
											.attr({ 'title': 'Вы успешно авторизовались' })
											.tooltip('show');


										setTimeout(function(){
											$('#myModalAuth').modal('hide');
											if (data.admin > 0 ){
												window.location.href = '/quest/adminschedule/ymd';
											} else {
												location.reload();
											}
										},500);

										return true;

									}
								}
							);

						} else {

							$('#form-group-pass-auth').addClass('input-error');
							$('#form-group-pass-auth span')
								.attr({ 'title': 'Пароль должен содержать более 3 символов' })
								.tooltip('show');
						}

					} else {

						$('#form-group-pass-auth').addClass('input-error');
						$('#form-group-pass-auth span')
							.attr({ 'title': 'Пароль не может быть пустым' })
							.tooltip('show');
					}
				} else {
					$('#form-group-username-auth').addClass('input-error');
					$('#form-group-username-auth span')
						.attr({ 'title': 'Некорректный Email' })
						.tooltip('show');
				}
			} else {
				$('#form-group-username-auth').addClass('input-error');
				$('#form-group-username-auth span')
					.attr({ 'title': 'Поле Email не может быть пустым' })
					.tooltip('show');
			}

		// forgot password
		} else {

			$('#form-group-forgot-auth').removeClass('input-error');
			$('#form-group-forgot-auth span').tooltip('destroy');
			$('#auth-form button').tooltip('destroy');

			if ( $('#auth-forgot').val() !== '') {
				if ( re.test( $('#auth-forgot').val() ) ) {

					$.post( "/user/recovery",
						{ 'UserRecoveryForm[email]' : $('#auth-forgot').val() },
						function( result ) {
							console.log(result);
							if (result && result.error && result.error == 1) {

								if (result.errors.email) {
									$('#form-group-forgot-auth').addClass('input-error');
									$('#form-group-forgot-auth span')
										.attr({ 'title': result.errors.email.join(', ') })
										.tooltip('show');
								} else {

									$('#auth-form button')
										.attr({ 'title': 'Неизвестная ошибка, свяжитесь с администрацией' })
										.tooltip('show');
								}
							} else if (result && result.success && result.success == 1) {

									$('#auth-form button')
										.attr({ 'title': result.msg })
										.tooltip('show');

							}
						}
					);

				} else {
					
					$('#form-group-forgot-auth').addClass('input-error');
					$('#form-group-forgot-auth span')
						.attr({ 'title': 'Некорректный Email' })
						.tooltip('show');
				}
			} else {
				
				$('#form-group-forgot-auth').addClass('input-error');
				$('#form-group-forgot-auth span')
					.attr({ 'title': 'Поле Email не может быть пустым' })
					.tooltip('show');
			}

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


	$('#myModalEditProfile #form-group-username input').keypress(function(){
		$('#myModalEditProfile #form-group-username span').tooltip('destroy');
		$('#myModalEditProfile #form-group-username').removeClass('input-error');

		$('#editProfile').tooltip('destroy');
	});

	$('#form-group-forgot-auth input').keypress(function(){
		$('#form-group-forgot-auth span').tooltip('destroy');
		$('#form-group-forgot-auth').removeClass('input-error');

		$('#auth-form button').tooltip('destroy');
	});


	$('#myModalEditProfile #form-group-phone input').keypress(function(){
		$('#myModalEditProfile #form-group-phone span').tooltip('destroy');
		$('#myModalEditProfile #form-group-phone').removeClass('input-error');

		$('#editProfile').tooltip('destroy');
	});


	$('#myModalEditProfile').on('shown.bs.modal', function(){
		$('#edit-name').val( $('.cabinet .name').text() );
		$('#edit-phone').val( $('.cabinet .phone').text() );
	});

	$('#form-group-origin-pass input').keypress(function(){
		$('#form-group-origin-pass span').tooltip('destroy');
		$('#form-group-origin-pass').removeClass('input-error');

		$('#editProfile').tooltip('destroy');
	});

	$('#form-group-new-pass input').keypress(function(){
		$('#form-group-new-pass span').tooltip('destroy');
		$('#form-group-new-pass').removeClass('input-error');

		$('#editProfile').tooltip('destroy');
	});

	$('#form-group-new-confirm-pass input').keypress(function(){
		$('#form-group-new-confirm-pass span').tooltip('destroy');
		$('#form-group-new-confirm-pass').removeClass('input-error');

		$('#editProfile').tooltip('destroy');
	});

	$('#edit-form').submit(function(){

		// смена пароля
		if ( $('#edit-pass').hasClass('active') ) {

			if ( $('#form-group-origin-pass input').val() != '' && $('#form-group-origin-pass input').val().length > 3 ) {

				if ($('#form-group-new-pass input').val() != '' && $('#form-group-new-pass input').val().length > 3) {

					if ($('#form-group-new-pass input').val() == $('#form-group-new-confirm-pass input').val()) {

						$.post(
							'/user/profile/changepassword',
							{
								'UserChangePassword[password]':$('#form-group-new-pass input').val(),
								'UserChangePassword[verifyPassword]':$('#form-group-new-confirm-pass input').val(),
								'UserChangePassword[oldpassword]':$('#form-group-origin-pass input').val(),
							},
							function(result){
								if (result && result.success && result.success == 1) {
									$('#editProfile')
										.attr({ 'title': result.message })
										.tooltip('show');

									setTimeout(function(){
										$('#myModalEditProfile').modal('hide');
										$('#editProfile').tooltip('destroy');
									}, 2000);
								}
							}
						);


					} else {

						$('#form-group-new-confirm-pass').addClass('input-error');
						$('#form-group-new-confirm-pass span')
							.attr({ 'title': 'Пароли не совпадают' })
							.tooltip('show');
					}


				} else {

					$('#form-group-new-pass').addClass('input-error');
					$('#form-group-new-pass span')
						.attr({ 'title': 'Новый пароль должен содержать более 4 символов' })
						.tooltip('show');
				}


			} else {

				$('#form-group-origin-pass').addClass('input-error');
				$('#form-group-origin-pass span')
					.attr({ 'title': 'Пароль должен содержать более 4 символов' })
					.tooltip('show');

			}

		// смена имени и телефона
		} else {

			if ( $('#edit-name').val() !== '' && $('#edit-name').val().length > 2 ) {
				if ( $('#edit-phone').val() !== '' && $('#edit-phone').val().length == 17 ) {

					var name = $('#edit-name').val(),
						btn_edit = $('#editProfile'),
						phone = $('#edit-phone').val();

					$.post('/user/profile/edit', {
						username: name,
						phone: phone,
					}, function(result){
									
						if (result && result.success) {

							btn_edit
								.attr({ 'title': result.message })
								.tooltip('show');

							$('.cabinet .name').html(name);
							$('.cabinet .phone').html(phone);
							$('.you_phone input').val(phone);

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
							} else {

								btn_edit
									.attr({
										'data-toggle':"tooltip",
										'title': 'Произошла ошибка, свяжитесь с администрацией',
									})
									.tooltip('show');
							}

						}
					});
				
				} else {

					$('#myModalEditProfile #form-group-phone').addClass('input-error');

					$('#myModalEditProfile #form-group-phone span')
						.attr({ 'title': 'Номер телефона должен содержать 10 символов' })
						.tooltip('show');
				}

			} else {

				$('#myModalEditProfile #form-group-username').addClass('input-error');

				$('#myModalEditProfile #form-group-username span')
					.attr({ 'title': 'Имя не может быть пустым и должно содержать менее 2 символов' })
					.tooltip('show');

			}
		}


		return false;
	});


	/* ВОССТАНОВИТЬ ПАРОЛЬ */
	$('#forgot').click(function(){
		$(this).hide();
		$('#auth_toogl').show();

		$('#form-group-username-auth, #form-group-pass-auth').hide();
		$('#form-group-forgot-auth').show();

		$('#myModalAuth button.btn').html('ВОССТАНОВИТЬ');
	});

	$('#auth_toogl').click(function(event) {
		$('#forgot').show();
		$(this).hide();

		$('#form-group-username-auth, #form-group-pass-auth').show();
		$('#form-group-forgot-auth').hide();


		$('#myModalAuth button.btn').html('войти');
	});


	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		$('a[data-toggle="tab"]').removeClass('active');
		$(e.target).addClass('active');
	});

	$('#bookgift-phone').mask('+7(000)-000-00-00');

	$('#bookgift-form').submit(function(){

		$('#mytxt').val(my_text);

		if ( $('#bookgift-name').val() != '' ){
			if ( $('#bookgift-phone').val() != '' ){
				if ( $('bookgift-addres').val() != '' ){
					return true;
				} else {
					alert('Зполните пожалуйста поле "Адрес"');
					$('#bookgift-addres').focus();
					return false;
				}
			} else {
				alert('Зполните пожалуйста поле "Телефон"');
				$('#bookgift-phone').focus();
				return false;
			}
		} else {
			alert('Зполните пожалуйста поле "Имя"');
			$('#bookgift-name').focus();
			return false;
		}
	});

	$('.priceTbl').tooltip();

	$(window).load(function() {
		if (typeof ordergiftcard != 'undefined' && ordergiftcard == 1){
			yaCounter25221941.reachGoal("ordergiftcard");
			ga("send", "event", "order", "giftcard");
		}
	});

	$('.city-select').on('show.bs.dropdown', function () {
		var dropdown_menu = parseInt($('.city-select .dropdown-menu').width()  ), // -56px
			abtn_link = parseInt($('.ico-msq').outerWidth() );

		if (dropdown_menu > abtn_link) {
			var imw = $('.ico-msq').width();
			$('.ico-msq').width(dropdown_menu - 26);
			var mr = $('.ico-msq').width() - imw;
			$('.city-select').css('margin-right','-'+mr+'px');
		}
	});

	if($('.img-container').length>0){
		function setSize(resize){
			var ww = $(window).width();
			if (ww>1023){
				$('.img-container').width(ww-514);
			} else {
				$('.img-container').width('100%');
			}
		}

		setSize();
		window.addEventListener(orientationEvent, setSize);

		if($('.img-container').length>1){
			var offset = 0;
			$('.img-container').each(function(index){
				$(this).css('right',offset);
				offset = offset - $(this).width();
			});
			// $( ".img-container" ).animate({    right: "-=1151" }, 2000);
		}
	}

	$('#myModalAuth').on('show.bs.modal', function () {
		if ($(window).width() < 768){
			window.location.href = '/user/login';
			return false;
		}
	});
});