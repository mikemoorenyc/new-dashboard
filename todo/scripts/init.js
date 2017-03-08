$(document).ready(function(){
  App.bus = new Vue({
    el: "#entry",
    data: {
      userInfo: App.userInfo,
      listItems: dataConverter(App.listItems),
      listCheck: [],
      lastModified: App.lastEdited,
      currentlyEditing: false,
      saving: false
    },
    watch: {
      listItems: {
        handler: function(newVal,oldVal) {
          $("#data-return").html('');
          $("#data-return").append(JSON.stringify(newVal)+'<br/><br/>');
          $("#data-return").append(this.listCheck+'<br/><br/>');
          if(this.listCheck !== JSON.stringify(newVal)) {
            this.ajaxUpdate(newVal)
          }
          this.listCheck =JSON.stringify(newVal);
          //this.ajaxUpdate(newVal)

          //this.ajaxUpdate();
        },
        deep: true
      },

    },
    created:function(){
      this.listCheck = JSON.stringify(this.listItems);
      this.$on('update-item',function(id,title){
        this.updateItem(id,title);
      });
      this.$on('delete-item',function(id){
        this.deleteItem(id);
      });
      this.$on('update-checked',function(id,state){
        this.updateChecked(id,state);
      });
      this.$on('update-editing',function(id){
        this.currentlyEditing = id;
      });
      this.$on('background-update',function(listItems){
        this.listItems = dataConverter( listItems);
      });
    },
    methods: {

      ajaxUpdate: _.debounce(
      function (tester) {
        this.saving = {
          text:'Saving'
        }

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url:App.ajaxURL ,
              data: {
                  'action': 'updatevalues', //calls wp_ajax_nopriv_ajaxlogin
                  'listItems': tester,
                  'pageid': App.pageid
                },

              success: function(data){


                if(!data.updated) {
                  console.log('no update');
                  return false;
                } else {
                  console.log('updated!');

                  this.listItems = dataConverter(data.listItems)
                  return false;
                }


              }.bind(this),
              error:function(data) {

              },
              complete: function(data) {

                this.saving = false;
              }.bind(this)
          });

      },
      // This is the number of milliseconds we wait for the
      // user to stop typing.
      2000
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
      updateChecked(id,state) {
        var newArray = this.listItems.slice();
        var key = this.findKey(id);
        var newItem = this.listItems[key];
        if(state) {
          newItem.checkedBy = this.userInfo;
        } else {
          newItem.checkedBy = false;
        }
        newArray[key] = newItem;
        this.listItems = newArray.slice();
        this.currentlyEditing = false;
      },
      updateStatus: function(userInfo,listItems,lastModified) {
        this.userInfo = userInfo;
        this.listItems = dataConverter(listItems);
        this.lastModified = lastModified;
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
        $('body,html').scrollTop(0);
      }
    },
    template: (`
      <div id="outer-container" :class="{login: userInfo === false}">
      <button style="display:none;" @click.prevent="ajaxUpdate(listItems)">Save</button>
      <div style="display:none;" class="save-status"v-if="saving!==false">{{saving.text}}</div>
        <app-header v-if="userInfo !== false " :saving="saving" :userInfo="userInfo" :lastModified="lastModified" v-on:additem="addItem"/>
        <main-form v-if="userInfo === false" v-on:updatestatus="updateStatus"/>
        <main-list
          v-if="userInfo !== false"
          :listItems="listItems"
          :currentlyEditing="currentlyEditing"
          :saving="saving"
        />

      </div>
    `)
  });
});
