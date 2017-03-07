
Vue.component('list-item', {
  template: "#template-list-item",
  props: ['item','swiped'],
  data: function() {
    return {
      hammer: false
    }
  },
  beforeDestroy: function() {
    this.hammer.off('swipe');
    this.hammer.destroy();
  },
  mounted: function() {
    this.hammer = new Hammer(this.$el);
    this.hammer.on('swipe', function(ev) {
	    if(ev.direction === 2) {
        this.$emit('swipeChange', this.item.id)
      } else {
        this.$emit('swipeChange', false)
      }
    }.bind(this));
  },
  methods: {

    updateChecked: function(id,state) {
      App.bus.$emit('update-checked',id,state);
    }
  }

});
