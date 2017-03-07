<div class="listItem" :class="{swiped: swiped == item.id}">
  <div v-if="item.checkedBy==false" @click.prevent="updateChecked(item.id,true)"  class="icon-button checkbox unchecked" :class="{checked: item.checked}">
    <?php include 'icon-checkbox-outline.php';?>
  </div>
  <div v-if="item.checkedBy!== false" @click.prevent="updateChecked(item.id,false)" class="icon-button checkbox checked" :class="{checked: item.checked}">
    <svg :fill="item.checkedBy.color" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 0h24v24H0z" fill="none"/>
        <path d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.11 0 2-.9 2-2V5c0-1.1-.89-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
    </svg>
  </div>
  <div class="text">
    <div class="title">{{item.title}}</div>
    <div class="byline">
      <span v-if="item.checkedBy == false">Added by </span>
      <span v-if="item.checkedBy !== false">Checked off by </span>
      <span v-if="item.checkedBy == false">{{item.addedBy.firstname}}</span>
      <span v-if="item.checkedBy !== false">{{item.checkedBy.firstname}}</span>
    </div>
  </div>
  <div v-show="!swiped" class="icon-button drag-handle">
    <?php include 'icon-drag-handle.php'; ?>
  </div>
  <div class="controls">
    <button class="icon-button edit" >
      <?php include 'icon-edit.php';?>
    </button>
    <button class="icon-button delete" >
      <?php include 'icon-delete.php';?>
    </button>
  </div>

</div>
