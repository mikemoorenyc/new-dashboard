<div id="main-list-container">
  <div class="no-items" v-if="listItems.length < 1">
    You have no to-do items!
  </div>
  <div id="main-list" v-if="listItems.length > 0">
    <draggable :list="listItems" :options="dragOptions">
    <div class="item-container" v-for="(item,index) in listItems" :key="item.id" >
      <list-item
      v-if="currentlyEditing !== item.id"
      :item='item'
      :swiped="swiped"
      v-on:swipeChange="updateSwipe"
      />
      <item-edit-form
      v-if="currentlyEditing === item.id"
      :id="item.id"
      :initialTitle="item.title"
      :currentlyEditing = 'currentlyEditing'

      />


    </div>
  </draggable>


</div>

</div>
