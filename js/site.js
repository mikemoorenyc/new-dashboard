function AppInit() {

  $('#refresher').click(function(){
    location.reload();
    return false;
  });

  var components = ['todolist','news','weather','stocks','subway','clock','calendar'];
  $(components).each(function(i,e){
    App[e].$mount('#'+e)
  });
  makeCenter();

  $(window).resize(function(){
    makeCenter();
  });

  setTimeout(function(){
    location.reload();
  },(1000*60)*120);

  function makeCenter() {

    var bh = $(window).height() - 20,
        bw = $(window).width(),
        ih = 800,
        iw = 1280;
    var scale_h = bh / ih;
    var scale_w = bw / iw;
    var scale;
    if(scale_h<scale_w) {
      scale = scale_h
    } else {
    scale = scale_w;
    }
    $('#main-view').width(scale*iw).height(scale*ih);
    $('html').css({
      'font-size': (1*($('#main-view').width() / 1280))+'px'
    })
  }

}
