var SeanceView = Backbone.View.extend({
	tagName:'button',
	className:'btn btn-xs btn-default',
	initialize:function(){
		this.render();
	},
	render:function(){
		var self = this; 
		this.$el.html(
			self.model.get('time')+'<br><small>2500р.</small>'
		);
		return this;
	}
});

var Seance = Backbone.Model.extend({
  initialize:function(){
  	
  	this.view = new SeanceView({model:this});

  	$('.bb_times',this.collection.quest.view.$el).append(this.view.el);

  }
});
var Seances = Backbone.Collection.extend({
  model: Seance,
  initialize:function(models,options){
  	this.quest = options.quest;
  	this.fetch();
  },
  parse: function(response) {
  	if (response && response.success) {
  		var result = [];
  		_.each(response.seances, function(k,v){
  			result.push({time:k});
  		});
    	return result;
  	} else {
  		return false;
  	}
  }
});