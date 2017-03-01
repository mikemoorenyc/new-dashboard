Vue.component('main-list', {
  template: '#main-list-template',
  props: ["listItems","currentlyEditing"],
  methods: {
    editClick: function(id) {
      this.$emit('editing', id);
    }
  }

});
