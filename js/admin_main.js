
function formatFileSize(bytes){
    if (typeof bytes !== 'number') {
        return '';
    }
    if (bytes >= 1000000000) {
        return (bytes / 1000000000).toFixed(2) + ' GB';
    }
    if (bytes >= 1000000) {
        return (bytes / 1000000).toFixed(2) + ' MB';
    }
    return (bytes / 1000).toFixed(2) + ' KB';
}

var PopoverView = Backbone.View.extend({
	
	initialize:function(options){
		this.parent = options.parent;
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
			id : $(this.parent).attr('data-id') || 0,
			quest_id : $(this.parent).attr('data-quest') || 0,
			status : $(this.parent).attr('data-status') || 0,

			payment : $(this.parent).attr('data-payment') || 0,
			source : $(this.parent).attr('data-source') || 0,
			discount : $(this.parent).attr('data-discount') || 0,
			winner_photo : $(this.parent).attr('data-winner-photo') || 0,
			
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
			$('#affilate_container', this.$el)
				// .append('<br><strong>Affiliate</strong>: <span>#'+self.attr.id+' '+self.attr.affiliate+'</span>');
				.append('<br><strong>Affiliate</strong>: <span>'+self.attr.affiliate+'</span>');
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

	if ($('#fileupload').length > 0) {

		// Initialize the jQuery File Upload widget:
		$('#fileupload').fileupload({
			url: 'management'
		})
		.on('fileuploadfinished', function (e, data) {

			$('.delete').on('click', function(){
				var photo_id = $(this).data('image-id');
				$.post('/photo/remove',{ photo_id: photo_id }, function(a,b,c){

					if (a && a.success && a.id)	{
						$('#photo_'+a.id).remove();
					}
				});
				return false;
			});
		})
		.on('fileuploadsubmit', function (e, data) {
			data.formData = data.context.find(':input').serializeArray();
		});

		$.get('/photo/get',function(response,b,c){

			if (response){

				var result = tmpl($('#template-oldfiles').html(), response);

				$('.files').html(result)
					.find('.template-oldfiles').addClass('in')
					.find('.delete').on('click', function(){
						var photo_id = $(this).data('image-id');
						$.post('/photo/remove',{ photo_id: photo_id }, function(a,b,c){

							if (a && a.success && a.id){
								$('#photo_'+a.id).remove();
							}
						});
					});


			}
		});
	}

	$('#ModalSetCover').on('show.bs.modal', function (e) {
		
		$('.select_cover').click(function(){
			var SelectedImage = $('#ModalSetCover input[name="cover_image"]:checked');

			if (SelectedImage.length == 1 ) {

				var image_name = SelectedImage.attr('data-name');

				$('#Quest_cover').val(image_name);
				$('#ModalSetCover').modal('hide');
			}
		});

		$.get('/photo/get',function(response,b,c){

			if (response && response.files){
				
				$('#ModalSetCover .modal-body .row').html('');

				_.each(response.files, function(file){
					$('#ModalSetCover .modal-body .row').append(
						tmpl(
						'<div class="col-sm-4 col-md-3">'+
							'<div class="thumbnail">'+
								'<img width="80" src="/images/thumbnail/{%=o.name%}" >'+
								'<div class="caption text-center">'+
									'{%=o.name%}<br>'+
									'<input type="radio" name="cover_image" data-name="{%=o.name%}" value="{%=o.id%}">'+
								'</div>'+
							'</div>'+
						'</div>',file)
					);
				});


				$('#ModalSetCover input[name="cover_image"]').change(function(){
					$('#quest_cover_image').attr('src','/images/thumbnail/'+$(this).attr('data-name'));
				});

			}
		});
	});

	$('#ModalSelectImage').on('show.bs.modal', function (e) {
		
		$('.select_photo').click(function(){
			var photos = [];
			$( ".quest_photo" ).each(function( index ) {
				photos.push( $(this).attr('data-id') );
			});

			$('input[name="photo"]').val(photos.join(','));
			$('#ModalSelectImage').modal('hide');
		});

		$.get('/photo/get',function(response,b,c){

			if (response && response.files){
				
				$('#ModalSelectImage .modal-body .row').html('');

				_.each(response.files, function(file){
					$('#ModalSelectImage .modal-body .row').append(
						tmpl(
						'<div class="col-sm-4 col-md-3">'+
							'<div class="thumbnail">'+
								'<img width="80" src="/images/thumbnail/{%=o.name%}" >'+
								'<div class="caption text-center">'+
									'{%=o.name%}<br>'+
									'<input type="checkbox" name="photo" data-name="{%=o.name%}" value="{%=o.id%}">'+
								'</div>'+
							'</div>'+
						'</div>',file)
					);
				});

				$( ".quest_photo" ).each(function( index ) {
					var id = $(this).attr('data-id');
					$('#ModalSelectImage input[value="'+id+'"]').attr("checked",true);
				});

				$('#ModalSelectImage input[name="photo"]').change(function(e){
					var self = $(this);

					if (self.prop('checked')){
						$('.photos').append(
							'<img data-id="'+self.val()+'" class="quest_photo" src="/images/thumbnail/'+self.attr('data-name')+'" > '
						);
					} else {
						$('.photos img[data-id="'+self.val()+'"]').remove();
					}
				});


			}
		});
	});

	if ( $(".input-timepicker24").length > 0 ) {

		var val = $('#Quest_time_preregistration').val(),
			time;
		if (val == 0 || val == '0'){
			time = '00:00';
		} else {
			var hours   = Math.floor(val / 3600);
			var minutes = Math.floor((val - (hours * 3600)) / 60);

			if (hours   < 10) {hours   = "0"+hours;}
			if (minutes < 10) {minutes = "0"+minutes;}
			var time = hours+':'+minutes;
		}

	    $(".input-timepicker24")
	        .timepicker({minuteStep: 10,showSeconds: 0,showMeridian: !1})
	        .val(time);

		$('.input-timepicker24').change(function(event) {
			
			var result_time = $(this).val().split(':');
			$('#Quest_time_preregistration').val(
				parseInt(result_time[0])*3600 + parseInt(result_time[1])*60
			);

		});
	}

	if ( $('.promo_days').length == 1 ) {
		var quest_id = $('.promo_days').attr('data-quest');
		function getPromoDays(quest_id) {
			$.post('/promoDays/index', {qid:quest_id}, function(response,b,c){
				if (response && response.days) {

					var promo_days = $('.promo_days').html('');

					_.each(response.days, function(day) {

						var date_year = day.day.substring(0, 4),
							date_month = day.day.substring(4, 6),
							date_day = day.day.substring(6,8);

						$('<div class="btn btn-md btn-primary" id="promoday_'+day.id+'">'+date_year+'/'+date_month+'/'+date_day+
							' ('+day.price_am+'р; '+day.price_pm+'р) <i title="удалить" class="fa fa-times" data-id="'+day.id+'"></i></div>')
							.appendTo(promo_days)
							.find('.fa-times')
							.click(function(){
								var promoday_id = $(this).attr('data-id');
								var answer = confirm("Вы действительно хотите удалить этот промо день?");
							    if (answer == true) {
							        $.post('/promoDays/delete/', {'id':promoday_id}, function(r){
							        	if (r && r.success && r.success == 1) {
							        		$('#promoday_'+promoday_id).fadeOut('400', function() {
							        			$(this).remove();
							        		});
							        	} else alert('Error!')
							        })
							    }
							});
						promo_days.append('&nbsp;')
					});

				}
			});
		}

		getPromoDays(quest_id);
		
		$('#add_promoday').click(function(){
			if ( 	$('input[name="date"]').val() != '' 
					&& $('input[name="price_am"]').val() != '' 
					&& $('input[name="price_pm"]').val() != '' )
			{
				var yyyy = $('input[name="date"]').val().substring(0,4),
					mm = $('input[name="date"]').val().substring(5,7),
					dd = $('input[name="date"]').val().substring(8,11);

				$.post('/promoDays/create', {
						'PromoDays[quest_id]':quest_id,
						'PromoDays[day]': yyyy+mm+dd,
						'PromoDays[price_am]':$('input[name="price_am"]').val(),
						'PromoDays[price_pm]':$('input[name="price_pm"]').val(),
					},
					function(r,b,c){
						if (r && r.success && r.success == 1) {
							getPromoDays(quest_id);
							$('input[name="date"]').val('');
							$('input[name="price_am"]').val('');
							$('input[name="price_pm"]').val('');
						}
					}
				);

			} else {
				alert('Заполните все поля!');
			}
		});
	}
});