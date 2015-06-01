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

		q.seances.each(function(s){
			s.set('booking', false);
		});

		this.each(function(model){


			var seance = q.seances.find(function(s){
				return s.get('time') == model.get('time');
			});

/*			if (q.id == 15){
				console.log(s.get('time'), model.get('time'));
			}*/

			if (seance) {
				seance.booking = model;
				seance.set('booking', true);
			}
		});
	},
	parse:function(response){
		if (response && response.success) {
			return response.bookings;
		}
	}
});