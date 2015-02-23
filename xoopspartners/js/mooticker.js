/** mooTicker - Newsticker class
 *  Original copyright 2006 Wolfgang Bartelme, Bartelme Design - http://bartelme.at
 *
 *  Ported and edited for mootools by Huug Helmink
 *  version 0.4.3
 *  date 2009-01-22
 *
 *  Usage:
 *  var myTicker = new Ticker('idOfDivElement');
 *      or (with options)
 *  var myTicker = new Ticker('idOfDivElement',{interval:####});
 *  with #### as an integer > 2000
  */
var mooTicker = new Class({
  Implements: Options,
  options: {
    groupBy: 1,
    interval: 5000
  },
  
  initialize: function(containerElement,options) {  
    // Set options
    this.setOptions(options);
    this.groupBy = this.options.groupBy;
    this.interval = this.options.interval;
    
    // Set container div
    this.container = containerElement;
     
    this.messages = $(this.container).getChildren();
    this.number_of_messages = this.messages.length - 1;
    
    this.group = new Array(this.groupBy);
    this.start_message = 1;
    this.end_message = this.groupBy;
    
    this.FxFade = new Fx.Tween(null,{property:'opacity'});
    
    if(this.number_of_messages > this.groupBy) { // When there are more images than the group size
      // Display first message
      this.hideAllMessages();
      this.showMessage();
      // Install timer
      this.timer = this.showMessage.periodical(this.interval,this);
    }
  },
 
  showMessage: function() {
    for(var i = 0; i < this.groupBy; i++) {
      if(this.start_message > this.number_of_messages) {
        this.start_message = 1;
      }
      this.group[i] = this.messages[this.start_message];
      this.start_message += 1;
    }
   
    this.group.each(function(item) {
      item.setStyle('display','inline-block');
      item.fade('in');
    }.bind(this));

    this.fadeMessage.delay(this.interval-1000,this);
  },
 
  fadeMessage: function() { 
    this.group.each(function(item) {
      item.set('tween',{link:'chain'});
      item.tween('opacity','0');
      item.tween('display','none');
    }.bind(this));
  },
 
  hideAllMessages: function() { 
    this.messages.setStyles({
      'display':'none',
      'opacity':0
    });
  }
});