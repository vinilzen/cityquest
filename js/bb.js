$(function() {

	var app = app || {};

	app.quests = new Quests();
	app.days = new Days();

	var Workspace = Backbone.Router.extend({

		routes: {
			"day/:ymd": "day",  // #day/
		},

		day: function(ymd) {
			app.days.setDate(ymd);
		},
	});

	app.workspace = new Workspace();
	Backbone.history.start();
});