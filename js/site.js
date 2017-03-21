function AppInit() {

  var components = ['todolist','news','weather','stocks','subway'];
  $(components).each(function(i,e){
    App[e].$mount('#'+e)
  });


}
