var PopoverView = Backbone.View.extend({
	
	initialize:function(options){
		this.parent = options.parent;
	},
	
	events: {
		'click #showRemoveBooking':'showRemoveBooking',
		'click #cancelDelete':'cancelDelete',
		'click #editBooking':'showEdit',
		'click #addBooking':'showAdd',
		'click #confirmedDelete':'removeBooking',
		'click #saveBooking':'saveBooking',
		'click #cancelAddBooking':'cancelAddBooking',
		'click #cancelEditBooking':'cancelEditBooking',
		'click #reservation':'reservation',
		'click #undoBooking':'undoBooking',
		'click #confirmBooking':'confirmBooking',
		'focus .inputPhone':'addSeven',
		'click #showUserList':'showUserList'
	},
	
	render:function(){
		var self = this,
			name = '';
		if ($('#addBookingRow .inputPhone').val() == '0000000' ) {
			name = 'CQ';
		} else {
			name = $(this.parent).attr('data-name') || '';
		}

		this.attr = {
			id : $(this.parent).attr('data-id') || 0,
			quest_id : $(this.parent).attr('data-quest') || 0,
			status : $(this.parent).attr('data-status') || 0,

			payment : $(this.parent).attr('data-payment') || 0,
			source : $(this.parent).attr('data-source') || 0,
			discount : $(this.parent).attr('data-discount') || 0,
			
			name :  name,
			phone :  $(this.parent).attr('data-phone') || '',
			result :  $(this.parent).attr('data-result') || '',
			comment :  $(this.parent).attr('data-comment') || '',
			price :  $(this.parent).attr('data-price') || 0,
			time :  $(this.parent).attr('data-time') || 0,
			ymd :  $(this.parent).attr('data-ymd') || 0,
			date :  $(this.parent).attr('data-date') || 0,
			vk_id : $(this.parent).attr('data-vk-id') || 0,
			fb_id : $(this.parent).attr('data-fb-id') || 0,
			affiliate : $(this.parent).attr('data-affiliate') || '',
		};


		this.attr.user_url = $(this.parent).attr('data-user-id') != ''
								? '/user/admin/view/id/'+$(this.parent).attr('data-user-id') 
								: '#';

		this.attr.action = 'add';
		if (($(this.parent).hasClass('btn-info') || $(this.parent).hasClass('btn-success')) && this.attr.name !== '') {
			this.attr.action = 'edit';
		}

		this.$el.html( _.template($('#BookInfWrap').html(), this.attr) );

		$('.pop-row', this.$el).hide();

		this.showEdit(this.attr.action); // Add || Edit

		if (this.attr.affiliate != '' ){
			$('#phoneRow', this.$el)
				.append('<br><strong>Affiliate</strong>: <span>#'+self.attr.id+' '+self.attr.affiliate+'</span>');
		}

		$('[data-toggle="tooltip"]', this.$el).tooltip();

		return this;
	},

	afterShow:function(btn){
		var self = this;

		$('.popover').addClass('popover-booking');

		$('<button type="button" class="close close-booking"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>')
			.appendTo('.popover-title')
			.click(function(){
				$(btn).popover('hide');
			});

		$('.popover-title .close').before('&nbsp;-&nbsp;'+$('#q_id_'+self.attr.quest_id).text());


	},

	showUserList:function(){
		var self = this,
			showUserList = $('#showUserList').attr({
								'class': 'progress-bar progress-bar-striped active',
							}).html(' ');
	},

	addSeven:function(e){
		if ($(e.target).val() == ''){
			$(e.target).mask('+7(000)-000-00-00').val('+7(');
		} else {
			$(e.target).mask('+7(000)-000-00-00');
		}
	},

	undoBooking:function(){
		var self = this;
		$.post('/booking/confirm', {
			id : self.attr.id,
			confirm : 0,
		}, function(result){
			if (result && result.success) {
				location.reload();
			} else {
				alert('Ошибка!');
			}
		});
		return false;
	},

	confirmBooking:function(){
		var self = this;
		$.post('/booking/confirm', {
			id : self.attr.id,
			confirm : 1,
		}, function(result){
			if (result && result.success) {
				console.log('confirmed');
				location.reload();
	
			} else {
				console.log(result);
				alert('Ошибка!');
			}
		});

		return false;
	},
	removeBooking:function(){
		var self = this;

		$.post('/booking/delete', {
			id : self.attr.id
		}, function(result){
			if (result && result.success) {
				console.log('removed');
				location.reload();
			} else {
				console.log(result);
				alert('Ошибка!');
			}
		});
		return false;
	},

	saveEditedBooking:function(){

		var self = this;

		$.post('/booking/update', {
			id : self.attr.id,
			ymd : self.attr.ymd,
			date : self.attr.date,
			time : self.attr.time,
			price : $('#editBookingRow .inputPrice').val(),
			result : $('#editBookingRow .inputResult').val(),
			phone : $('#editBookingRow .inputPhone').val(),
			comment : $('#editBookingRow .inputComment').val(),
			name : $('#editBookingRow .inputName').val(),

			payment : $('#payment').val(),
			source : $('#source').val(),
			discount : $('#discount').val(),

		}, function(result){
			
			console.log(result);

			if (result && result.success) {
				console.log('confirmed');
				// self.$el.removeClass('btn-info').addClass('btn-success');
				location.reload();
	
			} else {
				console.log(result);// if (result && result.message) { }
				alert('Ошибка!');
			}
		});

		return false;
	},

	reservation:function(){
		this.saveBooking({reservation:1});
		return false;
	},

	saveBooking:function(options){

		if (this.attr.action == 'edit') {
			this.saveEditedBooking();
		} else {

			var self = this,
				reservation = options.reservation || false;

			$.post('/booking/create', {
				quest_id : self.attr.quest_id,
				ymd : self.attr.ymd,
				date : self.attr.date,
				time : self.attr.time,
				
				payment : $('#payment').val(),
				source : $('#source').val(),
				discount : $('#discount').val(),

				price : $('.inputPrice').val(),
				result : $('.inputResult').val(),
				phone : reservation ? '0000000' : $('.inputPhone').val(),
				comment : $('.inputComment').val(),
				name : $('.inputName').val()!=''?$('.inputName').val() : 'CQ',
				user : reservation ? -1 : $('#selectUser_id').val(),
			}, function(result){
				if (result && result.success) {
					console.log('confirmed');
					location.reload();
				} else {
					console.log(result);
					alert('Ошибка!');
				}
			});

		}

		return false;
	},

	showRemoveBooking:function(){
		$('#btnRow, #BookInf h3, #phoneRow', this.$el).hide();
		$('#confirmRow', this.$el).show();
		$(this.parent).popover('setPosition');
		return false;
	},

	cancelDelete:function(){
		$('#confirmRow', this.$el).hide();
		$('#btnRow, #BookInf h3, #phoneRow', this.$el).show();
		$(this.parent).popover('setPosition');
		return false;
	},

	confirmedDelete:function(){
		console.log('send del requet');
		return false;
	},

	showEdit:function(options){
		var self = this;

		$('#addRow, #btnRow, #BookInf h3, #phoneRow', self.$el).hide();

		$('#editBookingRow .inputName', this.$el).val(self.attr.name);
		$('#editBookingRow .inputPhone', this.$el)
			.val(self.attr.phone)
			.mask('+7(000)-000-00-00')
			.focus(function(){
				var val = $(this).val();
				$(this).unmask().blur(function(){
					$(this).mask('+7(000)-000-00-00');			
				}).val(val);
			}).on('keyup', function(){
				$(this).mask('+7(000)-000-00-00');			
			});

		$('#editBookingRow .inputResult', this.$el).val(self.attr.result);
		$('#editBookingRow .inputComment', this.$el).val(self.attr.comment);
		$('#editBookingRow .inputPrice', this.$el).val(self.attr.price);

		$('#editBookingRow', this.$el).show('fast',function(a,b,c){

			if (options == 'add'){

				$('#dropdown_users').on('hide.bs.dropdown', function () {
					$('#addUser input').popover('hide');
				}).on('show.bs.dropdown', function () {
					setTimeout( "$( '#addUser input' ).focus()", 500 );
				});

				$('#addUser li').click(function(e){
					$('#dropdown_users').addClass('open');
					return false;
				});

				var run = false,
					progress = $( '<li><div class="progress">'+
							'<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'+
						'</div></li>' );

				// search exist user
				var user_input = $('#addUser input')
					.popover('show')
					.on('keyup', function(){
						var self_input = $(this);

						self_input.popover('hide');
						var val = self_input.val();
						if (val.length > 2 && run == false) {
							
							$('#addUser li.result').remove();
							progress.insertAfter( "#addUser li:first" );
							self_input.prop('disabled', true);
							run = true;
							$.get('/user/user/list?val='+val, function(r){
								$('#addUser li.result').remove();
								if ( r && r.success && r.data && r.data.length>0 ) {
									//$('#addUser li.last').hide();
									$('#addUser li.result').remove();
									_.each(r.data, function(user){
										var li = $('<li class="result">').appendTo('#addUser');
										$(	'<a title="'+user.phone+'" data-value="'+user.id+'" data-name="'+user.username+'">'+
												user.username+' ('+user.email+')</a>')
											.on('click', function(){
												$(this).addClass('selected');
												var val = $(this).attr('data-value'),
													phone = $(this).attr('title'),
													name = $(this).attr('data-name');

												$('#selectUser_id').val( val );
												$('.inputPhone', self.$el).val( phone );
												$('.inputName', self.$el).val( name );
											}).appendTo(li);
									});

								} else {
									$('#addUser').append('<li class="result"><a>Ничего не найдено</a></li>');
								}

							}).error(function(e){

								$('#addUser').append('<li class="result"><a>Ошибка!</a></li>');

							}).done(function(e){
								progress.remove();
								self_input.prop('disabled', false).focus();

								run = false;
							});
							
							
						} else {
							$('#addUser li.result').remove();
						}
					});
			}
			
			$(self.parent).popover('setPosition');

		});


		return false;
	},

	cancelEditBooking: function(){
		// $('.pop-row', this.$el).hide();
		// $('#BookInf h3, #btnRow, #phoneRow', this.$el).show();
		$(this.parent).popover('hide');
		return false;
	},
});

$(function() {

	$('.setHoliday, .page-header, .btn-group a.btn').tooltip({
		container:'body'
	});

	$('.setHoliday').click(function(e){
		$.post(
			'/holiday/update',
			{
				id:1,
				city:city_id,
				is_holiday:$(e.target).attr('data-holiday'),
				date:$(e.target).attr('data-date')
			},
			function(r){
				if (r.success){
					if (r.same){
						if (r.message)	alert(r.message);
					} else {
						if (r.message)	alert(r.message);
						window.location.reload(true);
					}
				}
			});

		return false;
	});

	if (document.body.clientWidth < 769) {

		window.button_popovers = $('#times-table button[data-toggle="popover"]');

		window.button_popovers.popover('destroy');

		setTimeout("window.button_popovers.popover('destroy')", 1000);


		window.button_popovers.click(function () {
			
			$(this)[0].popover_view = new PopoverView({parent:this});
			$('#addBookModal .modal-title').html( $(this).attr('data-title') );
			$('#addBookModal .modal-body').html($(this)[0].popover_view.render().el);
			$('#addBookModal').modal('show');
			
		});

	} else {
		$('#times-table button[data-toggle="popover"]').popover({
			placement:'auto left',
			animation: false,
			container: 'body',
			trigger: 'click',
			html: true,
			content:function(){

				if (!$(this)[0].popover_view)
					$(this)[0].popover_view = new PopoverView({parent:this});

				return $(this)[0].popover_view.render().el;
			}
		}).on('show.bs.popover', function (e) {
			
			$('[data-toggle="popover"]').each(function () {
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
					$(this).popover('hide');
			});

		}).on('shown.bs.popover', function (e) {

			$(this)[0].popover_view.afterShow(this);

		});
	}


	var modal = '<div aria-hidden="true" aria-labelledby="myModalLabel" class="formaModal modal fade" role="dialog" tabindex="-1">'+
				'<div class="modal-dialog">'+
					'<div class="modal-content">'+
						'<div class="modal-header">'+
							'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
							'<h4 class="modal-title">6 июня (пятница)   10:15<br><strong>3 000 </strong>руб.</h4>'+
						'</div>'+
						'<div class="modal-body">'+
							'<form role="form" class="form-horizontal">'+
								'<input type="hidden" value="" name="date" id="selected_date" />'+
								'<input type="hidden" value="" name="quest_id" id="quest_id" />'+
								'<input type="hidden" value="" name="ymd" id="selected_ymd" />'+
								'<input type="hidden" value="" name="time" id="selected_time" />'+
								'<input type="hidden" value="" name="price" id="selected_price" />'+
								'<div class="form-group">'+
									'<label class="col-sm-3" for="name">Имя</label>'+
									'<div class="col-sm-9">'+
										'<input class="form-control input-sm" id="name" value="" type="text">'+
									'</div>'+
								'</div>'+
								'<div class="form-group">'+
									'<label class="col-sm-3" for="phone">Телефон</label>'+
									'<div class="col-sm-9">'+
										'<input class="form-control input-sm" id="phone" value="" type="text">'+
									'</div>'+
								'</div>'+
								'<div class="form-group">'+
									'<label class="col-sm-3" for="result">Результат</label>'+
									'<div class="col-sm-9">'+
										'<input class="form-control input-sm" id="result" value="" type="text">'+
									'</div>'+
								'</div>'+
								// '<div class="form-group isGuest">'+
								// '<label class="col-sm-3" for="mail">Email</label>'+
								// '<div class="col-sm-9"><input class="form-control input-sm" value="" id="mail" type="text" value="" ></div>'+
								// '</div>'+
								'<div class="form-group">'+
									'<label for="mail" class="col-sm-3">Примечание</label>'+
									'<div class="col-sm-9"><textarea class="form-control input-sm" id="comment"></textarea></div>'+
								'</div>'+
								'<button class="btn btn-default btn-block btn-success btn-sm" id="book" type="submit">Забронировать</button>'+
							'</form>'+
							'<span class="text-center alert alert-success" style="display:none;">Ваша заяка успешно отправлена.</span>'+
							'<span class="text-center alert alert-danger" style="display:none;">Ошибка бронирования.</span>'+
			'</div></div></div></div>';

	$('body').append(modal);

	$('.time:not(.turnoff, .disabled)').click(function(){

		var str =	$(this).attr('data-date') +
					' ('+ $(this).attr('data-day') +') '+
					$(this).attr('data-time') +
					'<br><strong>'+$(this).attr('data-price')+' </strong>руб.';

		$('#name').val($(this).attr('data-name'));
		$('#phone').val($(this).attr('data-phone'));
		$('#result').val($(this).attr('data-result'));
		$('#selected_date').val($(this).attr('data-date'));
		$('#selected_time').val($(this).attr('data-time'));
		$('#selected_price').val($(this).attr('data-price'));
		$('#selected_ymd').val($(this).attr('data-ymd'));
		$('#quest_id').val($(this).attr('data-quest'));
		$('.modal-title').html(str);

		$('.formaModal .alert-success, .formaModal .alert-danger').hide();

		$(this).addClass('active_time');

		$('.formaModal').modal('show');
	});

	$('#book').click(function(){
		$.post('/booking/create', {
			quest_id : $('#quest_id').val(),
			date : $('#selected_date').val(),
			ymd : $('#selected_ymd').val(),
			time : $('#selected_time').val(),
			price : $('#selected_price').val(),
			phone : $('#phone').val(),
			result : $('#result').val(),
			comment : $('#comment').val(),
			name : $('#name').val(),
		}, function(result){
			if (result && result.success) {
				$('.active_time').attr('disabled','disabled');
				$('.formaModal .alert-success').fadeIn('slow', function(){
					$('.formaModal').fadeOut(function(){
						$('#comment').val('');
						$('.formaModal').modal('hide');
					});
				});
			} else {

				if (result && result.message) {
					$('.formaModal .alert-danger').html(result.message).fadeIn();
				}

				alert('Ошибка!');
			}
		});
		return false;
	});


	if ( typeof adminschedule != 'undefined') {
		var time = new Date().getTime();

		$(document.body).bind("mousemove keypress", function(e) {
			time = new Date().getTime();
		});

		function refresh() {
			
			if(new Date().getTime() - time >= 10000){

				$.get('', {'hash':hash}, function(a,b,c){
					if (a != hash){
			    		window.location.reload(true);
					} else {
			    		setTimeout(refresh, 10000);
					}
				});				
			} else {
			    setTimeout(refresh, 10000);
			}
		}

		setTimeout(refresh, 10000);
	}

	if ($('#User_superuser').length > 0){
		$('#User_superuser').change(function(){
			if ( $(this).val() != 2 ) {
				$('.set_moderator_quests').hide();
			} else {
				$('.set_moderator_quests').show();
			}
		});
	}

	$('input[name="City"]').change(function(e) {
		var city_id = $(this).val();
		$('input[data-city="'+city_id+'"]').prop('checked', $(this).is(":checked"));
	});

	$('.show_qs').click(function(){
		var city_id = $(this).data('city'),
			showed = $('.city-list-'+city_id).css('height');

		if (showed=='0px' || showed=='0' || showed==0) {
			$(this).html('-');
		} else {
			$(this).html('+');
		}

		$('.city-list-'+city_id).css('height',(showed=='0px' || showed=='0' || showed==0)?'auto':'0');
	});

});