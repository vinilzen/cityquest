var PopoverView = Backbone.View.extend({
	
	initialize:function(options){
		this.parent = options.parent;
	},
	
	events: {
		'click #confirmBooking':'confirmBooking',
		'click #removeBooking':'removeBooking',
		'click #editBooking':'showEdit',
		'click #addBooking':'showAdd',
		'click #cancelAddBooking':'cancelAddBooking',
		'click #cancelEditBooking':'cancelEditBooking',
	},
	
	render:function(){

		this.attr = {
			name :  $(this.parent).attr('data-name') || '',
			phone :  $(this.parent).attr('data-phone') || '',
		};

		this.$el.html( _.template($('#BookInfWrap').html(), this.attr) );

		$('.pop-row', this.$el).hide();

		if ($(this.parent).hasClass('btn-success') && this.attr.name !== '') {
			$('#BookInf h3, #btnRow, #phoneRow', this.$el).show();
		} else {
			$('#addRow', this.$el).show();
		}

		$('[data-toggle="tooltip"]', this.$el).tooltip();

		return this;
	},

	confirmBooking: function(){
		return false;
	},

	removeBooking:function(){

		return false;
	},

	showEdit:function(){
		var self = this;

		$('#addRow, #btnRow, #BookInf h3, #phoneRow', this.$el).hide();

		$('#editBookingRow .inputName', this.$el).val(self.attr.name);
		$('#editBookingRow .inputPhone', this.$el).val(self.attr.phone);

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

	$('.time:not(.turnoff, .disabled)').click(function(){
		var str =	$(this).attr('data-date') +
					' ('+ $(this).attr('data-day') +') '+
					$(this).attr('data-time') +
					'<br><strong>'+$(this).attr('data-price')+' </strong>руб.';

		$('#selected_date').val($(this).attr('data-date'));
		$('#selected_time').val($(this).attr('data-time'));
		$('#selected_price').val($(this).attr('data-price'));
		$('#selected_ymd').val($(this).attr('data-ymd'));
		$('.modal-title').html(str);
		$('.formaModal .modal-body form').show();
		$('.formaModal .modal-body h4').hide();
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
			console.log(result);
		});

		return false;
	});

});

