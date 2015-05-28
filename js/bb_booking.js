var Booking = Backbone.Model.extend({
	initialize:function(){
		console.log(this);
	}
});

var Bookings = Backbone.Collection.extend({
	model:Booking,
	initialize:function(){
		this.fetch();
	}
});