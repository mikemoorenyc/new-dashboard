Vue.component('main-form', {
  template: '#login-template',
  data: function() {
    return {
      modal: false,
      password: '',
      email: ''
    }
  },
  methods: {
    reset: function() {
      this.email = '';
      this.password = '';
      this.modal = false;

    },
    submit: function(){
      $("form#login-form input.text-field").each(function(){
        $(this).blur();
      });
      this.modal = {
        status: 'loading',
        text:'loading'
      }


      $.ajax({
        type: 'POST',
        dataType: 'json',
        url:App.ajaxURL ,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': this.email,
                'password': this.password,
                'security':  $('form#login-form #security').val()  ,
                'pageid': App.pageid
              },

            success: function(data){

                if(data.loggedin){
                  this.modal = {
                    status: 'success',
                    text: 'You&rsquo;re logged in, '+data.userInfo.firstname,
                    color: data.userInfo.color
                  }
                  setTimeout(function(){
                    this.$emit('updatestatus', data.userInfo, data.listData.listItems,data.listData.lastModified)
                  }.bind(this),2000)
                } else {

                 this.modal = {
                   status: 'error'
                 }
                 setTimeout(function(){
                   if(this.modal.status == 'error');
                   this.reset();
                 }.bind(this),2000)

                }
            }.bind(this)
        });
    }
  }
})
