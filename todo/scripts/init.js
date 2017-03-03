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
        handler: function(newVal,oldVal) {


          //this.ajaxUpdate();
        },
        deep: true
      },

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
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url:App.ajaxURL ,
              data: {
                  'action': 'updatevalues', //calls wp_ajax_nopriv_ajaxlogin
                  'listItems': this.listItems,
                  'pageid': App.pageid
                },

              success: function(data){
                console.log(data);
                if(!data.updated) {
                  console.log('no update');
                  return false;
                } else {
                  console.log('updated!');
                  //this.listItems = data.listItems;
                  return false;
                }


              }.bind(this),
              error:function(data) {
                console.log('error');
                console.log(data);
              },
              complete: function() {
                console.log('done');
              }
          });

      },
      // This is the number of milliseconds we wait for the
      // user to stop typing.
      500
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
        var newArray = this.listItems.slice();
        var key = this.findKey(id);
        var newItem = this.listItems[key];
        newItem.title = title;
        newArray[key] = newItem;
        this.listItems = newArray;

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
        var newArray = this.listItems.slice();
        newArray.unshift({
          id: new Date().getTime(),
          title: title,

          addedBy:this.userInfo,
          checkedBy: false
        })
        this.listItems = newArray;
      }
    },
    template: (`
      <div>
      <button @click.prevent="ajaxUpdate">Save</button>
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
