$(document).ready(function(){
  App.bus = new Vue({
    el: "#entry",
    data: {
      userInfo: App.userInfo,
      listItems: App.listItems,
      listCheck: [],
      lastModified: App.lastEdited,
      currentlyEditing: false,
      saving: false,
      AjaxInProgress: 0
    },
    watch: {


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
        this.listItems = listItems;
      });
      this.$on('order-change',function(){
        this.ajaxUpdate('shifttodos',null,null,null,null);
      });
    },
    methods: {

      ajaxUpdate: function (action,id,title,checked) {

        this.saving = {
          text:'Saving'
        }
        this.AjaxInProgress++;
        var listItems = this.listItems;
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url:App.ajaxURL ,
              data: {
                  'action': action, //calls wp_ajax_nopriv_ajaxlogin
                  'id': id,
                  'title': title,
                  'checked': checked,
                  'listItems': listItems
                },

              success: function(data){
                console.log(data);

                if((this.AjaxInProgress - 1) === 0 && data.status === 'success') {

                  this.listItems = data.listItems;
                }


              }.bind(this),
              error:function(data) {

              },
              complete: function(data) {
                this.AjaxInProgress--;

                //this.saving = false;
              }.bind(this)
          });

      },
      findKey: function(id) {
          return this.listItems.map(function(x){
            return x.id;
          }).indexOf(id);
      },
      deleteItem: function(id) {
        this.listItems = this.listItems.filter(function(e){
            return e.id !== id;
          });
        this.ajaxUpdate('deletetodo',id);
      },
      updateItem: function(id,title) {
        var newArray = this.listItems.slice();
        var key = this.findKey(id);
        var newItem = this.listItems[key];
        newItem.title = title;
        newArray[key] = newItem;
        this.listItems = newArray;
        this.ajaxUpdate('updatetodo',id,title)
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
        if(state) {
          this.ajaxUpdate('updatechecked',id,'', this.userInfo.id)
        } else {
          this.ajaxUpdate('updatechecked',id,'', 'uncheck')
        }
        this.currentlyEditing = false;
      },
      updateStatus: function(userInfo,listItems) {
        this.userInfo = userInfo;
        this.listItems = listItems;

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
        this.ajaxUpdate('addtodo','',title,'')
        $('body,html').scrollTop(0);
      }
    },
    template: (`
      <div id="outer-container" :class="{login: userInfo === false}">
      <button style="display:none;" @click.prevent="ajaxUpdate(listItems)">Save</button>
      <div style="display:none;" class="save-status"v-if="saving!==false">{{saving.text}}</div>
        <app-header v-if="userInfo !== false " :AjaxInProgress="AjaxInProgress" :saving="saving" :userInfo="userInfo" :lastModified="lastModified" v-on:additem="addItem"/>
        <main-form v-if="userInfo === false" v-on:updatestatus="updateStatus"/>
        <main-list
          v-if="userInfo !== false"
          :listItems="listItems"
          :currentlyEditing="currentlyEditing"
          :AjajxInProgress="AjaxInProgress"
        />

      </div>
    `)
  });
});
