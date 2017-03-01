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
      addItem: function(title) {
        this.listItems.unshift({
          id: new Date().getTime(),
          title: title,
          checked: false,
          addedBy:this.userInfo,
          checkedBy: null
        })
      }
    },
    template: (`
      <div>
        <app-header v-if="userInfo !== false " :userInfo="userInfo" :lastModified="lastModified" v-on:additem="addItem"/>
        <main-form v-if="userInfo === false" v-on:updatestatus="updateStatus"/>
        <main-list
          :listItems="listItems"
        />
      </div>
    `)
  });
});
