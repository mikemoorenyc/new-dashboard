<form id="app-header"  @submit.prevent="addClick">
<div style="display:none;"class="greeting">Hi, {{userInfo.firstname}}</div>

  <input type="text" id="add_text" value="" placeholder="Add a new to-do item" v-model="title"/>
  <button :disabled="!title.length" class="icon-button" style="background:green;"></button>


</form>
