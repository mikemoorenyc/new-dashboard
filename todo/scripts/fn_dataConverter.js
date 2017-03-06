function dataConverter(data) {

  var converted = [];
  if(!data) {
    return converted;
  }
  function cPerson(object,section) {
    return {
      id: +object[section].id,
      firstname:object[section].firstname,
      color:object[section].color
    }
  }
  data.forEach(function(e,i){
    var newItem = {
      id: +e.id,
      title: e.title,
      addedBy: cPerson(e,'addedBy')
    }
    if(e.checkedBy !== 'false') {
      newItem.checkedBy = cPerson(e,'checkedBy');
    } else {
      newItem.checkedBy = false;
    }
    converted.push(newItem);
  })
  return converted;
}
