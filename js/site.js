function AppInit() {

  var components = ['todolist','news','weather'];
  $(components).each(function(i,e){
    App[e].$mount('#'+e)
  });


}
