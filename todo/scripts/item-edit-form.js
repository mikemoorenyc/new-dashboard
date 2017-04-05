


var itemEditFormTemplate = (`
  <div class="edit-item-form">
  <form @submit.prevent="sendUpdate(title)">
    <input id="edit-title-input" @blur="sendUpdate(title)" type="text" v-model="title" :value="title" placeholder="I need to do...">
    <button style="display:none;" :disabled="title.length < 1"> Submit</button>

  </form>
  <button class="icon-button cancel" @click.prevent="sendUpdate(initialTitle)"><span style="display:none;">Cancel</span>
  <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
      <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
      <path d="M0 0h24v24H0z" fill="none"/>
  </svg>
  </button>

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
