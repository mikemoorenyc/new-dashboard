Vue.component('main-list', {
  template: '#main-list-template',
  props: ["listItems","currentlyEditing"],
  methods: {
    editClick: function(id) {
      this.$emit('editing', id);
    },
    deleteClick: function(id) {
      App.bus.$emit('delete-item',id)
    }
  }

});
