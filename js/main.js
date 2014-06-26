$(function() {
	$('#times-table button').popover();

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