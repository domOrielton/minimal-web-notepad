function linkify(inputText) {
  // from https://stackoverflow.com/questions/37684/how-to-replace-plain-urls-with-links
  var replacedText, replacePattern1, replacePattern2, replacePattern3;

  //URLs starting with http://, https://, or ftp://
  replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
  replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');

  //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
  replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
  replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');

  //Change email addresses to mailto:: links.
  replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
  replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1">$1</a>');

  return replacedText;
}

function CreateViewable(noBorder) {
  var newNode = document.createElement("div"); // Create the new node to insert
  newNode.id = "contentWithLinks"; // give it an id attribute called 'newSpan'
  var referenceNode = document.getElementById("content"); // Get the reference node
  referenceNode.parentNode.insertBefore(newNode, referenceNode); // Insert the new node before the reference node
  document.getElementById("contentWithLinks").innerHTML = linkify(document.getElementById("printable").innerHTML).replace(/\r\n|\r|\n/g, "<br />");

  //added for IE9 compatibility
  //https://www.w3schools.com/howto/howto_js_add_class.asp
  var element, name, arr;
  element = document.getElementById("contentWithLinks");
  name = "content wordwrap";
  arr = element.className.split(" ");
  if (arr.indexOf(name) == -1) {
    element.className += " " + name;
  }
  if (noBorder) element.style.border='none';
}

function toggleView(lnk_obj) {
  var x = document.getElementById("content");
  lnk_obj.innerHTML = (lnk_obj.innerHTML == 'view') ? 'edit' : 'view';
  if (x.style.display === "none") {
    x.style.display = "block";
    var element = document.getElementById("contentWithLinks");
    element.parentNode.removeChild(element);
  } else {
    x.style.display = "none";
    CreateViewable();
  }
}

function viewOnly() {
  //no textarea available with the view option so show the links enabled view
  var x = document.getElementById("content");
  x.style.display = "none";
  CreateViewable(true);
}

// Go back to Edit (from View with links) by pressing the Esc key
document.onkeydown = function(evt) {
  evt = evt || window.event;
  if (evt.keyCode == 27) {
    if (document.getElementById("password_modal").className == 'modal_password show-modal') {
      toggleModal_Password();
      return;
    }
    if (document.getElementById("content").style.display == "none") {
      toggleView(document.getElementById("a_view"));
    }
  }
};
