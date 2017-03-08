<form id="app-header"  @submit.prevent="addClick">
<div style="display:none;"class="greeting">Hi, {{userInfo.firstname}}</div>

  <input required type="text" id="add_text" value="" placeholder="Add a new to-do item" v-model="title"/>
  <button  class="icon-button" >
    <span style="width:0;height:0; position:absolute; left:-9999px;">Submit</span>
    <?php include 'icon-add.php';?>
  </button>

  <div v-if="saving !== false" class="loader-bar"></div>
</form>
