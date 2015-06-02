
var SeanceView = Backbone.View.extend({
	tagName:'button',
	className:'btn btn-xs btn-default',
  template:_.template('<%= time %><br><small><%= price %><%= unit %>.</small>'),
  events:{
    'click':'showPopover'
  },
	initialize:function(){
		this.render();
	},
	render:function(){
		var self = this;

		this.$el
      .html( this.template(this.model.attributes) )
      .attr('data-haspopover', 0);

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
      attr: (seance.booking) ? seance.booking.attributes : {},
      seance_attr: seance.attributes,
      seance_view: this
    });

    return this.popover_view.el;
  },
  showPopover:function(){
    var self = this,
        q = this.model.collection.quest;

    if ( parseInt( self.$el.attr('data-haspopover') ) == 1 ) {

      this.$el.popover('destroy');
      this.$el.attr('data-haspopover', 0);

    } else {

      $('.bb_times .btn.btn-xs')
        .popover('destroy')
        .attr('data-haspopover', 0);

      this.$el.popover({

        placement:'left',
        animation: false,
        html: true,
        title:' ',
        trigger:'manual',
        content:self.getPopoverContent()

      }).on('show.bs.popover', function(){
        
        self.$el.attr('data-haspopover', 1);

      }).on('shown.bs.popover', function(){

        $('<button type="button" class="close close-booking">'+
            '<span aria-hidden="true">×</span><span class="sr-only">Close</span></button>')
          .appendTo('.popover-title')
          .click(function(){
            self.$el
              .attr('data-haspopover', 0)
              .popover('hide');
          });

        if (self.model.booking){
          $('.popover-title').prepend('<small>#'+self.model.booking.id+'</small>&nbsp;&nbsp;');
        }

        $('.popover-title .close').before(
          self.model.get('time')+ '&nbsp;' +
          $('.today_is').text()+
          '&nbsp;-&nbsp;'+
          q.get('title')
        );

      });

      console.log('trigger show popover');
      this.$el.popover('show');
    }
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