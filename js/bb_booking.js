var Booking = Backbone.Model.extend({
	initialize:function(){
		//console.log(this);
	}
});

var Bookings = Backbone.Collection.extend({
	model:Booking,
	initialize:function(models, options){
		this.quest = options.quest;
		this.day = options.day;
		this.url = '/booking/get?quest='+this.quest.id+'&day='+this.day.get('ymd');
	},
	setupBookings:function(){
		var q = this.quest;
		this.each(function(model){
			
			q.seances.each(function(s){
				if (s.get('time') == model.get('time')){
					s.booking = model;
					s.set('booking', true);
				} else {
					delete s.booking;
					s.set('booking', false);
				}
			});
		});
	},
	parse:function(response){
		if (response && response.success) {
			return response.bookings;
		}
	}
});