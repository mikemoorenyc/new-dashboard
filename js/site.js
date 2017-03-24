function AppInit() {

  var components = ['todolist','news','weather','stocks','subway','clock','calendar'];
  $(components).each(function(i,e){
    App[e].$mount('#'+e)
  });
  markCenter();

function makeCenter() {
  var ww = $(window).width();
  var wh = $(window).height();
  var iw = 16;
  var ih = 9;
}

}
