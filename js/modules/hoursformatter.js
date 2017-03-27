function hoursFormatter(date) {
  var minutes = date.getMinutes();
  if(minutes<10) {
   minutes = '0'+minutes;
  }
  var ampm = 'am';
  var hours = date.getHours();
  if(hours >11) {
    ampm = 'pm';
  }
  if(hours === 0) {
    hours = 12;
  }

  if(hours > 12) {
    hours -= 12;
  }
  return {
   minutes: minutes,
   hours: hours,
   ampm: ampm
  }
}
