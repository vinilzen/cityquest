var PopoverView = Backbone.View.extend({
	
	initialize:function(options){
		console.log(options);
		this.attr = options.attr;
		this.render();
	},
	
	events: {
		'click #showRemoveBooking':'showRemoveBooking',
		'click #cancelDelete':'cancelDelete',
		'click #editBooking':'showEdit',
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
			id : self.attr.id || 0,
			quest_id : self.attr.quest || 0,
			status : self.attr.status || 0,

			payment : self.attr.payment || 0,
			source : self.attr.source || 0,
			discount : self.attr.discount || 0,
			winner_photo : self.attr.winner_photo || 0,
			
			name :  name,
			phone :  self.attr.phone || '',
			result :  self.attr.result || '',
			comment :  self.attr.comment || '',
			price :  self.attr.price || 0,
			time :  self.attr.time || 0,
			ymd :  self.attr.ymd || 0,
			date :  self.attr.date || 0,
			affiliate : self.attr.affiliate || '',
		};


		this.attr.user_url = $(this.parent).attr('data-user-id') != ''
								? '/user/admin/view/id/'+$(this.parent).attr('data-user-id') 
								: '#';

		this.attr.action = 'add';
		if (($(this.parent).hasClass('btn-info') || $(this.parent).hasClass('btn-success') || $(this.parent).hasClass('btn-gray')) && this.attr.name !== '') {
			this.attr.action = 'edit';
		}

		this.$el.html( _.template($('#BookInfWrap').html(), this.attr) );

		$('.pop-row', this.$el).hide();

		this.showEdit(this.attr.action); // Add || Edit

		if (this.attr.affiliate != '' ){
			$('#affilate_container', this.$el)
				.append('<br><strong>Affiliate</strong>: <small>'+self.attr.affiliate+'</small>');
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

		$('.popover-title').prepend('<small>#'+self.attr.id+'</small>&nbsp;&nbsp;');

		$('.popover-title .close').before(
			'&nbsp;-&nbsp;'+$('#q_id_'+self.attr.quest_id).text()//+' ('+self.attr.price+'р)'
		);
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
			.focus(function(e){
				var val = $(this).val();
				
				if (val == '') $(this).val('+7(');

				/*$(this).unmask().blur(function(){
					$(this).mask('+7(000)-000-00-00');		
				}).val(val);*/

			});/*.on('keyup', function(){
				// if ($(e.target).val() == '') $(e.target).val('+7(');
				//$(this).mask('+7(000)-000-00-00');
			});*/

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
			} else {
				self.addUpload();
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

	addUpload: function(){
		var self = this,
			sizeBox = $('#editBookingRow #sizeBox', self.$el),
			progress = $('#progress', self.$el).hide();

		$('#uploadWinnerPhoto', this.$el).show();

		if (self.attr.winner_photo != '') {
			$('#picbox').fadeIn();
		} else {
			$('#picbox').hide();
		}

		var uploader = new ss.SimpleUpload({
			button: 'upload-btn', // file upload button
			url: '/booking/upload/'+self.attr.id, // server side handler
			name: 'uploadfile', // upload parameter name        
			//progressUrl: 'uploadProgress.php', // enables cross-browser progress support (more info below)
			responseType: 'json',
			allowedExtensions: ['jpg', 'jpeg'],
			maxSize: 5120, // kilobytes
			onSubmit: function(filename, extension) {
				progress.removeClass('hide').fadeIn('fast');
				this.setFileSizeBox(sizeBox); // designate this element as file size container
				this.setProgressBar(progress); // designate as progress bar
			},
			onError: function( filename, errorType, status, statusText, response, uploadBtn ){
				console.log('onSubmit', filename, errorType, status, statusText, response, uploadBtn);
			},
			onSizeError: function( filename, fileSize ) {
				$('#errormsg')
					.removeClass('hide')
					.html('Размер файла: '+filename+' - '+fileSize+'Kb больше разрешенного (5Mb)')
					.css('color','red')
					.fadeIn('fast');
			},
			onComplete: function(filename, response) {
				progress.fadeOut();
				$('#errormsg').fadeOut();
				if (!response) {
					alert(filename + 'upload failed');
					return false;            
				} else {
					$('#picbox a img').remove();
					$('#picbox a')
						.attr({'href':'/images/winner_photo/'+response.file})
						.html('<img class="img-responsive" style="max-height: 100px; height: 200px;" src="/images/winner_photo/'+self.attr.id+'.jpg?'+Date.now()+'"></a>');
					$('#picbox').removeClass('hide').fadeIn();
					$('button[data-id="'+self.attr.id+'"]')
						.attr('data-winner-photo',self.attr.id+'.jpg')
						.append('<i style="position:absolute;font-size:7px;bottom:0;right:0;" class="fa fa-camera"></i>');
				}
			}
		});
	}
});