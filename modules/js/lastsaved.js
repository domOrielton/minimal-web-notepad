function lastUpdated(responseText) {
  // called when a note is saved
  var now = new Date();
  var saved = '';
  saved += ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2) + ':' + ('0' + now.getSeconds()).slice(-2);
  var selector = document.getElementById('savedStatus');
  selector.setAttribute('datetime', now.getTime());
  //update the status so the user can see it has been saved
  document.getElementById("savedStatus").innerHTML = lastText() + saved;
  if (responseText.search("error") !== -1  && responseText.search("saved") > 0) {
      selector.setAttribute('datetime', '');
      document.getElementById("savedStatus").innerHTML = responseText;
  }
}

function lastSaved() {
  // Update how long ago it was saved (comment out next 2 lines if do not want a status that is dynamic (showing how long ago it was last saved)
  // this will fire if there is no change to the file - basically just a clock
  var lastSave = document.getElementById('savedStatus').getAttribute("datetime");
  if (lastSave) {
    var result = lastSave;
    if (isNaN(lastSave)) {
      var myDate = new Date(lastSave);
      result = myDate.getTime();
    }
    var savedStatus = lastText() + ago(result) + ' ago';
    //update the saved status if it has changed
    if (savedStatus != document.getElementById("savedStatus").innerHTML) document.getElementById("savedStatus").innerHTML = savedStatus;
  }
}

function lastText() {
  var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
  var lastSavedText = "Last saved: ";
  if (w < 600) {
    lastSavedText = "Saved: ";
  }
  return lastSavedText;
}
