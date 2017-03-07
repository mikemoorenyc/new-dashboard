Vue.component('main-list', {
  template: '#main-list-template',
  props: ["listItems","currentlyEditing"],
  data: function() {
    return {
      dragOptions: {
        handle:'.drag-handle'
      },
      swiped: false
    }
  },

  methods: {
    updateSwipe:function(id) {
      this.swiped = id;
    }
  }

});
