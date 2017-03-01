Vue.component('app-header', {
  template: '#app-header-template',
  props: ["userInfo", "lastModified"],
  data: function() {
    return {
      title:''
    }
  },
  methods: {
    addClick: function() {
      this.$emit('additem', this.title)
      this.title = '';
    }
  }

});
