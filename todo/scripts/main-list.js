Vue.component('main-list', {
  template: '#main-list-template',
  props: ["listItems","currentlyEditing", 'AjajxInProgress'],
  data: function() {
    return {
      dragOptions: {
        handle:'.drag-handle'
      },
      swiped: false
    }
  },
  mounted: function(){
    $('body,html').scrollTop(0);
  //  this.backgroundUpdate();
    setInterval(function(){

      //this.backgroundUpdate();
    }.bind(this),(15*1000))
  },
  methods: {
    backgroundUpdate:function() {

      if(this.AjajxInProgress > 0) {
        return false;
      }

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url:App.ajaxURL ,
            data: {
                'action': 'backgroundupdate',
                'pageid': App.pageid
              },

            success: function(data){

              if(this.AjajxInProgress > 0 || this.currentlyEditing !== false) {
                return false;
              }

              App.bus.$emit('background-update',data.listItems);



            }.bind(this)

        });
    },
    updateSwipe:function(id) {
      this.swiped = id;
    }
  }

});
