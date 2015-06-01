
var SeanceView = Backbone.View.extend({
	tagName:'button',
	className:'btn btn-xs btn-default',
  template:_.template('<%= time %><br><small><%= price %><%= unit %>.</small>'),
	initialize:function(){
		this.render();
	},
	render:function(){
		var self = this;
		this.$el.html(
      this.template(this.model.attributes)
    );
    if (this.model.has('booking') && this.model.get('booking')){
      console.log(this.model);
      this.$el.addClass('btn-gray');
    } else {
      this.$el.removeClass('btn-gray');
    }
		return this;
	}
});

var Seance = Backbone.Model.extend({
  defaults:{
    time:'00:00',
    price:0,
    unit: 'руб',
  },
  initialize:function(){
  	
  	this.view = new SeanceView({model:this});

  	$('.bb_times',this.collection.quest.view.$el).append(this.view.el);

    this.on('change', function(){ this.view.render(); }, this);

  }
});
var Seances = Backbone.Collection.extend({
  model: Seance,
  initialize:function(models,options){
    var self = this;
  	this.quest = options.quest;
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