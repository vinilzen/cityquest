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
		$('.modal-title').html(str);
		$('.formaModal .modal-body form').show();
		$('.formaModal .modal-body h4').hide();
		$('.formaModal').modal('show');
	});

});