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
    },
    editClick: function(id) {
      this.$emit('editing', id);
    },
    deleteClick: function(id) {
      App.bus.$emit('delete-item',id)
    }
  }

});
