var PopoverView = Backbone.View.extend({
	
	initialize:function(options){
		this.parent = options.parent;
	},
	
	events: {
		'click #confirmBooking':'confirmBooking',
		'click #removeBooking':'removeBooking',
		'click #cancelDelete':'cancelDelete',
		'click #editBooking':'showEdit',
		'click #addBooking':'showAdd',
		'click #saveBooking':'saveBooking',
		'click #cancelAddBooking':'cancelAddBooking',
		'click #cancelEditBooking':'cancelEditBooking',
		'click #undoBooking':'undoBooking',
	},
	
	render:function(){

		this.attr = {
			id : $(this.parent).attr('data-id') || 0,
			name :  $(this.parent).attr('data-name') || '',
			phone :  $(this.parent).attr('data-phone') || '',
			comment :  $(this.parent).attr('data-comment') || '',
			price :  $(this.parent).attr('data-price') || 0,
		};

		this.$el.html( _.template($('#BookInfWrap').html(), this.attr) );

		$('.pop-row', this.$el).hide();

		if (($(this.parent).hasClass('btn-info') || $(this.parent).hasClass('btn-success')) && this.attr.name !== '') {
			$('#BookInf h3, #btnRow, #phoneRow', this.$el).show();
		} else {
			$('#addRow', this.$el).show();
		}

		$('[data-toggle="tooltip"]', this.$el).tooltip();

		return this;
	},

	undoBooking:function(){
		console.log('undoBooking');
		var self = this;

		$.post('/booking/confirm', {
			id : self.attr.id,
			confirm : 0,
		}, function(result){
			if (result && result.success) {
				// self.$el.removeClass('btn-success').addClass('btn-info');
				location.reload();
			} else {
				console.log(result); // if (result && result.message) { }
				alert('Ошибка!');
			}
		});
		return false;
	},

	confirmBooking:function(){
		console.log('confirmBooking');
		var self = this;

		$.post('/booking/confirm', {
			id : self.attr.id,
			confirm : 1,
		}, function(result){
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

	saveBooking:function(){
		console.log('save new booking');
		return false;
	},

	removeBooking:function(){
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
		//TODO delete booking
		console.log('send del requet');
		return false;
	},

	showEdit:function(){
		var self = this;

		$('#addRow, #btnRow, #BookInf h3, #phoneRow', this.$el).hide();

		$('#editBookingRow .inputName', this.$el).val(self.attr.name);
		$('#editBookingRow .inputPhone', this.$el).val(self.attr.phone);
		$('#editBookingRow .inputComment', this.$el).val(self.attr.comment);
		$('#editBookingRow .inputPrice', this.$el).val(self.attr.price);

		$('#editBookingRow', this.$el).show();
		$(this.parent).popover('setPosition');
		return false;
	},

	showAdd:function(){
		$('#addRow', this.$el).hide();
		$('#addBookingRow', this.$el).show();
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
	
	$('#times-table button[data-toggle="popover"]').popover({
		placement:'auto',
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
	});


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
				console.log(result);

				if (result && result.message) {
					$('.formaModal .alert-danger').html(result.message).fadeIn();
				}

				alert('Ошибка!');
			}
		});
		return false;
	});
});