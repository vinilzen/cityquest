
var SeanceView = Backbone.View.extend({
	tagName:'button',
	className:'btn btn-xs btn-default',
  template:_.template('<%= time %><br><small><%= price %><%= unit %>.</small>'),
	initialize:function(){
		this.render();
    var self = this;
    this.$el.popover({
      placement:'auto left',
      animation: false,
      html: true,
      content:'132'
    }).on('show.bs.popover', function(){
      console.log('show.bs.popover', self.getPopoverContent());
    });
	},
	render:function(){
		var self = this;
		this.$el.html(
      this.template(this.model.attributes)
    );
    var m = this.model,
        b = m.booking;
    if (m.has('booking') && m.get('booking')){
      this.$el.addClass('btn-gr');

      if (b.get('status') == 1){
        this.$el.removeClass('btn-gr').removeClass('btn-default').addClass('btn-info');
      }

      if (parseInt(b.get('result'))!=0 && b.get('result')!= '' && b.get('result') != ' '){
        this.$el.removeClass('btn-info').removeClass('btn-default').addClass('btn-success');
      }

      if (b.get('name') == 'CQ') {
        this.$el.removeClass('btn-gr').addClass('btn-gray');
      }

    } else {
      this.$el
        .removeClass('btn-gray')
        .removeClass('btn-gr')
        .removeClass('btn-info')
        .removeClass('btn-success')
        .addClass('btn-default');
    }

		return this;
	},
  getPopoverContent:function(){
    
    console.log('getPopoverContent');

    var seance = this.model;
    
    this.popover_view = new PopoverView({
      attr:seance.booking.attributes,
      seance_attr:seance.attributes
    });
    
    console.log(this.popover_view);
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

    this.on('change', function(){
      this.view.render();
    }, this);

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