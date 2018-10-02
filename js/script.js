function uploadContent(force) {

  force = force || false; //force needed to add password even though the text is not changed
  // If textarea value changes.
  if (content !== textarea.value || force) {
    var temp = textarea.value;
    var request = new XMLHttpRequest();
    var saved = false;
    request.open('POST', window.location.href, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onreadystatechange = function() {
      //if (this.readyState !== 4 || this.status !== 200) {
      //  saved = "error";
      //} // for lastUpdated status
      // the password page won't show correctly if the textarea is there and the session has timed out but
      //   we can still search for text displayed in the form as it is in the responseText
      if (this.responseText.search("Invalid password") !== -1) {
        location.reload();
      }
      //if (this.responseText.search("saved") > 0) {
      //  saved = true;
      //}
      //} // will give a true here is password is set on blank note as note gets deleted
      //if (this.responseText.search("deleted") !== -1) {
      //  saved = true;
      //} // will give a true here is password is set on blank note as note gets deleted
      if (typeof lastUpdated === "function" ) {
        lastUpdated(this.responseText);
      } // check if the lastupdated functions are loaded
    };

    request.onload = function() {
      if (request.readyState === 4) {

        // Request has ended, check again after 1 second.
        content = temp;
        setTimeout(uploadContent, 1500); //increased time from 1 to 1.5 seconds to offset header check
      }
    }

    request.onerror = function() {
      //saved = "error"; // for lastUpdated status
      // Try again after 1 second
      setTimeout(uploadContent, 1000);
    }

    // Send the request.
    var requestToSend = 'text=' + encodeURIComponent(temp);
    if (typeof passwordRequest_Add === "function") {
      requestToSend = passwordRequest_Add(requestToSend);
    } //check if the password functions are loaded
    if (typeof passwordRequest_Remove === "function") {
      requestToSend = passwordRequest_Remove(requestToSend);
    } //check if the password functions are loaded
    request.send(requestToSend);

    // Make the content available to print.
    printable.removeChild(printable.firstChild);
    printable.appendChild(document.createTextNode(temp));

    if (document.getElementById("contentWithLinks")) {
      // used by the simple view
      document.getElementById("contentWithLinks").innerHTML = linkify(document.getElementById("printable").innerHTML).replace(/\r\n|\r|\n/g, "<br />");
      var objDiv = document.getElementById("contentWithLinks").scrollHeight; //scroll to bottom as text added there
    }

  } else {

    // Content has not changed, check again after 1 second.
    setTimeout(uploadContent, 1000);
    if (typeof lastSaved === "function") {
      lastSaved();
    } //check if the lastupdated functions are loaded
  }
}

var textarea = document.getElementById('content');
var printable = document.getElementById('printable');
var content = textarea.value;

// Make the content available to print.
printable.appendChild(document.createTextNode(content));

// Enable TABs to indent. Based on https://stackoverflow.com/a/14166052/1391963
textarea.onkeydown = function(e) {
  if (e.keyCode === 9 || e.which === 9) {
    e.preventDefault();
    var s = this.selectionStart;
    this.value = this.value.substring(0, this.selectionStart) + '\t' + this.value.substring(this.selectionEnd);
    this.selectionEnd = s + 1;
  }
}

textarea.focus();
uploadContent();
