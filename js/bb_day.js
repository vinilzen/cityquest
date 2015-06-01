var Holidays = Backbone.Collection.extend({
	initialize:function(options) {
		this.app = options.app;
		this.url = '/holiday/get?start='+options.start+'&end='+options.end;
		this.fetch({
			success:function(a,b,c){
				options.deferred_holidays.resolve(a);
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
		this.app = options.app;
		this.url = '/promoDays/get?start='+options.start+'&end='+options.end;
		this.fetch({
			success:function(a,b,c){
				options.deferred_promo.resolve(a);
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
		this.render();
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
	model: Day,
	days_of_week: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	months: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Ноя','Окт','Дек'],
	period: 12,
	day_offset: -1,
	holidays_ready:false,
	promo_ready:false,
	initialize:function(models, options){
		this.app = options.app;
		this.deferred_holidays = $.Deferred();
		this.deferred_promo = $.Deferred();
		this.deferred = $.Deferred();
	},
	fill:function(){
		var date = new Date(),
			today_date = new Date(),
			active_date = new Date(),
			i = 0,
			self = this;

		date.setDate(date.getDate() + this.day_offset);

		while (i < this.period) {
			i++;
			var y = date.getFullYear(),
				m = ((date.getMonth()+1) < 10) ? ('0'+(date.getMonth()+1)) : date.getMonth()+1,
				d = (date.getDate() < 10 ) ? ('0'+date.getDate())  : date.getDate();

			self.add({
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

		models = this.models;

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
			end: last_day.get('ymd'),
			app: self.app,
			deferred_holidays: self.deferred_holidays
		});

		this.promodays = new PromoDays({
			start: first_day.get('ymd'),
			end: last_day.get('ymd'),
			app: self.app,
			deferred_promo: self.deferred_promo
		});
	},
	markPromo:function(){
		var self = this;

		this.promodays.each(function(promo){
			var day = self.find(function(model) {
				return model.get('ymd') == promo.get('day');
			});
		});
		this.promo_ready = true;
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

		this.holidays_ready = true;
	},

	setDayOff: function(active_day){
		$('.today_is')
			.html(active_day.get('day')+' '+active_day.get('month')+'. '+active_day.get('Y'));


		$('.setHoliday')
			.attr({
				'data-date':active_day.get('ymd'),
				'data-holiday':(active_day.get('holiday') || active_day.get('weekend'))?1:0
			});

		if (active_day.get('holiday') || active_day.get('weekend')) {
			
			$('.setHoliday').addClass('hi-star').removeClass('hi-star-empty')
				.attr('title','Сделать рабочим');
			$('.block-title h2').attr('title','Выходной день');

		} else {
			
			$('.setHoliday').addClass('hi-star-empty').removeClass('hi-star')
				.attr('title','Сделать выходным');
			$('.block-title h2').attr('title','Рабочий день');

		}

		$('.setHoliday, .block-title h2')
			.tooltip('destroy')
			.tooltip({ container:'body'});
	},

	removeActive:function(){
		this.each(function(model){
			model.set('active',false);
		});
	},

	getActiveDate:function(){
		return this.find(function(m){
			return m.get('active');
		});
	},

	setDate: function(ymd){
		var self = this;

		this.each(function(model){
			if (model.get('ymd') == ymd) {
				model.set('active', true);
			} else {
				model.set('active', false);
			}
		});

		var active_day = self.getActiveDate();

		if (this.holidays_ready && this.promo_ready){

			self.setDayOff(active_day);

			self.app.quests.each(function(quest){
				quest.setPrice(active_day);
			});

		} else {

			$.when( this.deferred_holidays, this.deferred_promo, self.app.quests.deferred ).done(function( holidays, promodays, quests ){
				
				holidays.app.days.markHolidays();
				holidays.app.days.setDayOff(active_day);
				promodays.app.days.markPromo();

				quests.each(function(quest){
					quest.seances.fetch({success:function(collection,response){
						if (response && response.success){
							quest.setPrice(active_day);
						}
					}});

					quest.setPrice(active_day);
				});

			});
		}
	}
});