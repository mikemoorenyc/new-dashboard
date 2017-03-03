<div id="main-list">
  <div class="no-items" v-if="listItems.length < 1">
    You have no to-do items!
  </div>
  <ul id="main-list" v-if="listItems.length > 0">
    <li v-for="(item,index) in listItems" :key="item.id">
      <div v-if="currentlyEditing !== item.id">
        <div class="checkbox" :class="{checked: item.checked}"></div>
        <div class="title">{{item.title}}</div>

        <div class="controls">
          <button @click.prevent="editClick(item.id)"> Edit</button>
          <button @click.prevent="deleteClick(item.id)">Delete</button>
        </div>

      </div>
      <item-edit-form
      v-if="currentlyEditing === item.id"
      :id="item.id"
      :initialTitle="item.title"

      />


    </li>


  </ul>

</div>
