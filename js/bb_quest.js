var QuestView = Backbone.View.extend({
	tagName:'tr',
	template: _.template(
		'<td>'+
			'<%= title %> <a href="/quest/update?id=<%= id %>" target="_blank">#</a>'+
			'<br>(<%= price_am %>-<%= price_pm %>)'+
			'<br>(<%= price_weekend_am %>-<%= price_weekend_pm %>)'+
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
		this.seances = new Seances([],{
			url: '/quest/getseances/qid/'+this.id,
			quest: this
		});
	}
});

var Quests = Backbone.Collection.extend({
  model: Quest,
  url:'/quest/getavailablequest',
  initialize:function(){

  	this.fetch();

	/*{
        success: function(collection){
	  		console.log('success');
	  		collection.render();
	  	},
	  	error: function(a,b,c){
	  		console.log(a,b,c);
			console.log('error');
		}
  	}*/
  },

  fetch:function(options){

  	if (typeof(options) == 'undefined'){
  		options = {};
  		options.success = function(collection){
	  		console.log('success');
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

  parse: function(response) {
  	if (response && response.success) {
    	return response.quests;
  	} else {
  		return false;
  	}
  }
});