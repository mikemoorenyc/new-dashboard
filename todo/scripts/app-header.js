Vue.component('app-header', {
  template: '#app-header-template',
  props: ["userInfo", "lastModified", 'saving'],
  data: function() {
    return {
      title:''
    }
  },
  methods: {
    addClick: function() {
      if(this.title.length == 0) {
        return false;
      }
      this.$emit('additem', this.title)
      this.title = '';
    }
  }

});
