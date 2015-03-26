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
		'click #addBookingRow #saveBooking':'saveBooking',
		'click #editBookingRow #saveBooking':'saveEditedBooking',
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

		this.$el.html( _.template($('#BookInfWrap').html(), this.attr) );

		$('.pop-row', this.$el).hide();

		if (($(this.parent).hasClass('btn-info') || $(this.parent).hasClass('btn-success')) && this.attr.name !== '') {
			$('#BookInf h3, #btnRow, #phoneRow', this.$el).show();
		} else {
			this.showAdd();
		}

		if (this.attr.affiliate != '' ){
			$('#phoneRow', this.$el)
				.append('<br><strong>Affiliate</strong>: <span>#'+self.attr.id+' '+self.attr.affiliate+'</span>');
		}

		$('[data-toggle="tooltip"]', this.$el).tooltip();

		return this;
	},

	showUserList:function(){
		var self = this,
			showUserList = $('#showUserList').attr({
								'class': 'progress-bar progress-bar-striped active',
							}).html(' ');

		$.get('/user/user/list', function(r){
			if (r && r.success && r.data && r.data.length>0) {
				var select_container = $('#selectUser')
						.html('<select name="user"><option value="0">Пользователь</option></select>'),
					select_div = select_container.find('select');

				_.each(r.data, function(user){
					select_div.append(
						'<option value="'+user.id+'" title="'+user.email+'" data-name="'+user.username+'" data-phone="'+user.phone+'">'
							+user.username+' ('+user.email+')</option>'
					);
				});

				select_div.styler({selectSearch:true});
				$('.jq-selectbox').css('display','block');
				$('#users_progress').remove();

				select_div.on('change', function(){
					var val = $(this).val(),
						phone = $('option[value="'+val+'"]', this).attr('data-phone'),
						name = $('option[value="'+val+'"]', this).attr('data-name');

					$('.inputPhone', self.$el).val( phone );
					$('.inputName', self.$el).val( name );
				});

			}
		});
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

		var self = this,
			reservation = options.reservation || false;

		$.post('/booking/create', {
			quest_id : self.attr.quest_id,
			ymd : self.attr.ymd,
			date : self.attr.date,
			time : self.attr.time,
			price : $('#addBookingRow .inputPrice').val(),
			result : $('#addBookingRow .inputResult').val(),
			phone : reservation ? '0000000' : $('#addBookingRow .inputPhone').val(),
			comment : $('#addBookingRow .inputComment').val(),
			name : $('#addBookingRow .inputName').val()!=''?$('#addBookingRow .inputName').val() : 'CQ',
			user : reservation ? -1 : $('#selectUser select').val(),
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

	showEdit:function(){
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
			})

		$('#editBookingRow .inputResult', this.$el).val(self.attr.result);
		$('#editBookingRow .inputComment', this.$el).val(self.attr.comment);
		$('#editBookingRow .inputPrice', this.$el).val(self.attr.price);

		$('#editBookingRow', this.$el).show();
		$(this.parent).popover('setPosition');
		return false;
	},

	showAdd:function(){
		var self = this;

		$('#addRow', this.$el).hide();
		$('#addBookingRow', this.$el).show();

		$('.inputPhone', self.$el).blur(function(){
			$(this).mask('+7(000)-000-00-00');				
		});

		$(this.parent).popover('setPosition');
		return false;
	},

	cancelAddBooking: function(){
		$('.pop-row', this.$el).hide();
		$('#addRow', this.$el).show();
		$(this.parent).popover('setPosition');
		return false;
	},

	cancelEditBooking: function(){
		$('.pop-row', this.$el).hide();
		$('#BookInf h3, #btnRow, #phoneRow', this.$el).show();
		$(this.parent).popover('setPosition');
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

			var self = this;

			$('<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>')
				.css('margin-top', -4)
				.appendTo('.popover-title')
				.click(function(){
					$(self).popover('hide');
				});
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