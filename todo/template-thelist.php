<div id="main-list-container">
  <div class="no-items" v-if="listItems.length < 1">
    You have no to-do items!
  </div>
  <div id="main-list" v-if="listItems.length > 0">
    <draggable :list="listItems">
    <div class="listItem" v-for="(item,index) in listItems" :key="item.id" :style="{borderColor: item.addedBy.color}">
      <div v-if="currentlyEditing !== item.id">
        <div v-if="item.checkedBy==false" @click.prevent="updateChecked(item.id,true)"  class="icon-button checkbox" :class="{checked: item.checked}"></div>
        <div v-if="item.checkedBy!== false" @click.prevent="updateChecked(item.id,false)"  class="icon-button checkbox" :class="{checked: item.checked}"></div>
        <div class="text">
          <div class="title">{{item.title}}</div>
          <div class="byline">
            <span v-if="item.checkedBy == false">Added by </span>
            <span v-if="item.checkedBy !== false">Checked off by </span>
            <span v-if="item.checkedBy == false">{{item.addedBy.firstname}}</span>
            <span v-if="item.checkedBy !== false">{{item.checkedBy.firstname}}</span>
          </div>
        </div>

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


    </div>
  </draggable>


</div>

</div>
