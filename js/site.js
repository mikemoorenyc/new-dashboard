function AppInit() {

  var components = ['todolist','news'];
  $(components).each(function(i,e){
    App[e].$mount('#'+e)
  });


}
