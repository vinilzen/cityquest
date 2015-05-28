var d_holidays = $.Deferred();
var d_promo = $.Deferred();

var Holidays = Backbone.Collection.extend({
	initialize:function(options) {
		this.url = '/holiday/get?start='+options.start+'&end='+options.end;
		this.fetch({
			success:function(a,b,c){
				d_holidays.resolve(a);
			},	
			error:function(){}
		});
	},
	parse: function(response) {
		if (response && response.success) {
			return response.days;
		} else {
			return false;
		}
	}
});
var PromoDays = Backbone.Collection.extend({
	initialize:function(options) {
		this.url = '/promoDays/get?start='+options.start+'&end='+options.end;
		this.fetch({
			success:function(a,b,c){
				d_promo.resolve(a);
			},	
			error:function(){}
		});
	},
	parse: function(response) {
		if (response && response.success) {
			return response.days;
		} else {
			return false;
		}
	}
});

var DayView = Backbone.View.extend({
	tagName:'a',
	className:'text-center btn btn-default btn-day',
	template: _.template(
		'<span><%= day %></span>'+
		'<small><%= dayOfTheWeek %></small>'+
		'<small><%= month %></small>'+
		'<span class="badge"></span>'
	),
	events:{
		"click":"activate",
	},
	initialize:function(){
		this.render()
	},
	render:function(){

		var day = this.model;

		this.$el
			.html( this.template(day.attributes) )
			.attr( 'href', '#day/'+day.get('ymd') );


		if (day.get('active'))
			this.$el
				.addClass('btn-success').attr("disabled","disabled");
		else
			this.$el
				.removeClass('btn-success').removeAttr('disabled');


		if (day.get('today'))
			this.$el.addClass('active');
		else
			this.$el.removeClass('active');


		if (day.get('weekend') || day.get('holiday'))
			this.$el.addClass('btn-warning');
		else
			this.$el.removeClass('btn-warning');

		return this;
	},

	activate:function(){
		this.model.collection.removeActive();
		this.model.set('active',true);
	}
});

var Day = Backbone.Model.extend({
	defaults:{
		current:false,
		active:false,
		ymd:0,
		day:0,
		dayOfTheWeek:'',
		month:'',
		month_number:0,
		weekend:false,
		holiday:false,
		Y:2015,
		m:00,
		d:00,
	},
	initialize:function(){
		this.view = new DayView({model:this});
		this.on('change:active', function(){
			this.view.render();
		});
		this.on('change:holiday', function(){
			this.view.render();
		});
	}
});

var Days = Backbone.Collection.extend({
	model:Day,
	days_of_week:['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	months:['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Ноя','Окт','Дек'],
	period:12,
	day_offset:-1,
	initialize:function(){
		var i = 0;
		var date = new Date(),
			today_date = new Date(),
			active_date = new Date();

		date.setDate(date.getDate() + this.day_offset);

		while (i < this.period) {
			i++;
			var y = date.getFullYear();
			var m = ((date.getMonth()+1) < 10) ? ('0'+(date.getMonth()+1)) : date.getMonth()+1;
			var d = (date.getDate() < 10 ) ? ('0'+date.getDate())  : date.getDate();
			this.push({
				'dayOfTheWeek': this.days_of_week[date.getDay()],
				'day': date.getDate(),
				'month': this.months[date.getMonth()],
				'today': (today_date.getDate() == date.getDate()) ? true : false,
				'active': (active_date.getDate() == date.getDate()) ? true : false,
				'weekend':(date.getDay() == 0 || date.getDay() == 6) ? true : false,
				'Y': y,
				'm': m,
				'd': d,
				'ymd': y + '' + m + '' + d
			});

			date.setDate(date.getDate() + 1);
		}

		this.render();
	},
	render:function(){
		var days_container = $('#bb_days'),
			self = this;

		this.each(function(model){
			days_container.append(model.view.el)
		});
		
		var last_day = this.last(),
			first_day = this.first();

		this.holidays = new Holidays({
			start: first_day.get('ymd'),
			end: last_day.get('ymd')
		});

		this.promodays = new PromoDays({
			start: first_day.get('ymd'),
			end: last_day.get('ymd')
		});

		$.when( d_holidays, d_promo ).done(function ( holidays, promodays ) {
			self.markHolidays();
			self.markPromo();
		});
	},
	markPromo:function(){
		var self = this;

		this.promodays.each(function(promo){
			var day = self.find(function(model) {
				return model.get('ymd') == promo.get('day');
			});

			if (day) day.view.$el.attr('data-promo',1);
		});
	},
	markHolidays:function(){
		var self = this;

		this.holidays.each(function(promo){
			var day = self.find(function(model) {
				return model.get('ymd') == promo.get('holiday_date');
			});

			if (day){
				day.view.$el.attr('data-holiday',1);
				day.set('holiday',1);
			}
		});

	},
	removeActive:function(){
		this.each(function(model){
			model.set('active',false);
		});
	},
	setDate: function(ymd){
		this.each(function(model){

			if (model.get('ymd') == ymd) {
				model.set('active', true);
			} else {
				model.set('active', false);
			}
		})
	}
});