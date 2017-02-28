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
    submit: function(){
      this.modal = {
        status: 'loading',
        text:'loading'
      }
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: $('#login-form').attr('action'),
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': this.email,
                'password': this.password,
                'security': $('#login-form #security').val() ,
                'pageid': App.pageid
              },

            success: function(data){
                console.log(data)
            }
        });
    }
  }
})
