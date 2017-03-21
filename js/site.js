function AppInit() {

  var components = ['todolist','news','weather','stocks'];
  $(components).each(function(i,e){
    App[e].$mount('#'+e)
  });


}
