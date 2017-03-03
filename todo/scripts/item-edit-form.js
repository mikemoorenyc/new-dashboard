


var itemEditFormTemplate = (`
  <div class="edit-item-form">
  <form @submit.prevent="sendUpdate(title)">
    <input id="edit-title-input" type="text" v-model="title" :value="title">
    <button> Submit</button>

  </form>
  <button @click.prevent="sendUpdate(initialTitle)">Cancel</button>

  </div>



`);

Vue.component('item-edit-form', {
  template: itemEditFormTemplate,
  props: ['id', 'initialTitle'],
  data: function() {
    return {
      title: this.initialTitle
    }
  },
  mounted: function() {
    $('#edit-title-input').focus();
  },
  methods: {
    sendUpdate:function(title) {

      App.bus.$emit('update-item',this.id,title);
    }
  }

});
