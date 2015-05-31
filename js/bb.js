$(function() {

	var app = app || {};

	app.quests = new Quests([],{app: app });
	app.days = new Days([],{ app: app });
	app.days.fill();

	var Workspace = Backbone.Router.extend({

		routes: {
			"day/:ymd": "day",  // #day/
			'*path':  'defaultRoute'
		},

		day: function(ymd) {
			app.days.setDate(ymd);
		},

		defaultRoute: function(path){
			var date = new Date(),
				y = date.getFullYear(),
				m = ((date.getMonth()+1) < 10) ? ('0'+(date.getMonth()+1)) : date.getMonth()+1,
				d = (date.getDate() < 10 ) ? ('0'+date.getDate())  : date.getDate();

			app.days.setDate(y+''+m+''+d);
		}
	});

	app.workspace = new Workspace();
	Backbone.history.start();
});