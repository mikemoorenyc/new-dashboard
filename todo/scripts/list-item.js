
Vue.component('list-item', {
  template: "#template-list-item",
  props: ['item','swiped','currentlyEditing'],
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
      if (App.bus.currentlyEditing!== false) {
        return false;
      }
	    if(ev.direction === 2) {
        this.$emit('swipeChange', this.item.id)
      } else {
        this.$emit('swipeChange', false)
      }
    }.bind(this));
  },
  methods: {
editClick: function(id) {
      App.bus.$emit('update-editing',id)
      this.$emit('swipeChange', false)
    },
    deleteClick: function(id) {
      App.bus.$emit('delete-item',id)
      this.$emit('swipeChange', false)
    },
    updateChecked: function(id,state) {
      App.bus.$emit('update-checked',id,state);
    }
  }

});
