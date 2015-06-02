var QuestView = Backbone.View.extend({
	tagName:'tr',
	template: _.template(
		'<td>'+
			'<%= title %> <a href="/quest/update?id=<%= id %>" target="_blank">#</a>'+
			'<small><br>(<%= price_am %>-<%= price_pm %>)'+
			'<br>(<%= price_weekend_am %>-<%= price_weekend_pm %>)</small>'+
		'</td>'+
		'<td class="bb_times"></td>'),
	initialize:function(){
		this.render();
	},
	render:function(){
		var self = this;
		this.$el.html( this.template(this.model.attributes) );
		return this;
	}
})

var Quest = Backbone.Model.extend({
	initialize:function(){
		this.view = new QuestView({model:this});
		this.deferred = $.Deferred();
		this.seances = new Seances([],{
			url: '/quest/getseances/qid/'+this.id,
			quest: this
		});
	},
	setPrice: function(active_day){
		
  		var q = this,
			promodays = q.collection.app.days.promodays,
			promoDay = promodays.find(function(model){
				return parseInt(model.get('quest_id')) == parseInt(q.id) &&
						model.get('day') == active_day.get('ymd');
			});

		this.seances.each(function(seance){
			var hour = parseInt(seance.get('time').split(':'));

			var price_weekend_am = q.get('price_weekend_am'),
				price_weekend_pm = q.get('price_weekend_pm'),
				price_am = q.get('price_am'),
				price_pm = q.get('price_pm');

			if ( typeof(promoDay)!='undefined' ){

				if (hour > 9 && hour < 17) {
					seance.set('price', promoDay.get('price_am'));
				} else {
					seance.set('price', promoDay.get('price_pm'));
				}

			} else if (active_day.get('weekend') || active_day.get('holiday')) {
				
				if (hour > 9 && hour < 17) {
					seance.set('price', price_weekend_am);
				} else {
					seance.set('price', price_weekend_pm);
				}

			} else {
				
				if (hour > 9 && hour < 17) {
					seance.set('price', price_am);
				} else {
					seance.set('price', price_pm);
				}
			}

			if (hour > 2 && hour < 9) {
				seance.view.$el.hide();
			}
		});

		q.bookings = new Bookings([], {
			quest:q,
			day:active_day
		});
		this.bookings.fetch({success:function(collection){
			q.bookings.setupBookings();
		}});
	}
});

var Quests = Backbone.Collection.extend({
  model: Quest,
  url:'/quest/getavailablequest',
  initialize:function(models, options){
  	this.app = options.app;
  	this.deferred = $.Deferred();
  	this.fetch();
  },

  fetch:function(options){

  	if (typeof(options) == 'undefined'){
  		options = {};
  		options.success = function(collection){
	  		collection.deferred.resolve(collection);
	  		collection.render();
	  	}
  	}

	return Backbone.Collection.prototype.fetch.call(this, options);
  },

  render:function(){
  	var quests = $('#bb_quests tbody').html('');
  	this.each(function(model){

  		quests.append(model.view.el);

  	});
  },

  setPrice:function(){

  	var active_day = this.app.days.getActiveDate();

	this.each(function(quest){
  		quest.setPrice(active_day);
  	});
  },

  parse: function(response) {
  	if (response && response.success) {
    	return response.quests;
  	} else {
  		return false;
  	}
  }
});