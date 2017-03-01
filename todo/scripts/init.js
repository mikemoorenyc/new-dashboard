$(document).ready(function(){
  App.bus = new Vue({
    el: "#entry",
    data: {
      userInfo: App.userInfo,
      listItems: App.listItems,
      lastModified: App.lastEdited,
      currentlyEditing: false
    },

    methods: {
      updateStatus: function(userInfo,listItems,lastModified) {
        this.userInfo = userInfo;
        this.listItems = listItems;
        this.lastModified = lastModified;
      },
      setEditing: function(id) {

        this.currentlyEditing = id;
      },
      addItem: function(title) {
        this.listItems.unshift({
          id: new Date().getTime(),
          title: title,

          addedBy:this.userInfo,
          checkedBy: false
        })
      }
    },
    template: (`
      <div>
        <app-header v-if="userInfo !== false " :userInfo="userInfo" :lastModified="lastModified" v-on:additem="addItem"/>
        <main-form v-if="userInfo === false" v-on:updatestatus="updateStatus"/>
        <main-list
          :listItems="listItems"
          :currentlyEditing="currentlyEditing"
          v-on:editing="setEditing"
        />
      </div>
    `)
  });
});
