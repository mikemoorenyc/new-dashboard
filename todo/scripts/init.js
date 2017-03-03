$(document).ready(function(){
  App.bus = new Vue({
    el: "#entry",
    data: {
      userInfo: App.userInfo,
      listItems: App.listItems,
      lastModified: App.lastEdited,
      currentlyEditing: false
    },
    watch: {
      listItems: {
        handler: function(newVal) {
          this.ajaxUpdate();
        },
        deep: true
      }
    },
    created:function(){
      this.$on('update-item',function(id,title){
        this.updateItem(id,title);
      });
      this.$on('delete-item',function(id){
        this.deleteItem(id);
      });
    },
    methods: {
      ajaxUpdate: _.debounce(
      function () {
        
      },
      // This is the number of milliseconds we wait for the
      // user to stop typing.
      3000
    ),
      findKey: function(id) {
          return this.listItems.map(function(x){
            return x.id;
          }).indexOf(id);
      },
      deleteItem: function(id) {
        this.listItems = this.listItems.filter(function(e){
            return e.id !== id;
          });
      },
      updateItem: function(id,title) {
        var key = this.findKey(id);
        var newItem = this.listItems[key];
        newItem.title = title;
        this.$set(this.listItems,key, newItem);

        this.currentlyEditing = false;
      },
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
