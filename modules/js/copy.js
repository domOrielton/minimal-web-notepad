function copyToClipboard(elementId) {
  //https://jsfiddle.net/alvaroAV/a2pt16yq/

  // Create an auxiliary hidden input
  var aux = document.createElement("textarea");

  // Get the text from the element passed into the input
  if (elementId == 'copyURL') {
    aux.value = window.location.href; //get the url not the content
  }
  else if (elementId == 'copyURLViewOnly') {
    aux.value = window.location.href + '?view'; //get the view only url not the content
  }
  else {
    aux.value = document.getElementById(elementId).innerHTML;
  }

  // Append the aux input to the body
  document.body.appendChild(aux);

  // Highlight the content
  aux.select();

  // Execute the copy command
  document.execCommand("copy");

  // Remove the input from the body
  document.body.removeChild(aux);

  document.getElementById("copyMessage").innerHTML = "<br>Copied";
}
