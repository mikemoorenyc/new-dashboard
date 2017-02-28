$(document).ready(function(){
  App.bus = new Vue({
    el: "#entry",
    data: {
      userInfo: App.userInfo,
      listItems: App.listItems,
      lastEdited: App.lastEdited
    },
    template: (`
      <div>
        <main-form v-if="userInfo === false"/>
      </div>
    `)
  });
});
