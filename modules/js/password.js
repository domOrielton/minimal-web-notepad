function passwordRequest_Add(requestToSend) {
  var notepwd = (document.getElementById("notepwd")) ? document.getElementById("notepwd").value : '';
  if (!isEmpty(notepwd)) {
    requestToSend = requestToSend + '&notepwd=' + encodeURIComponent(notepwd);
  }
  if ( document.getElementById("allowReadOnlyView").checked ) {
    requestToSend = requestToSend + '&allowReadOnlyView=1';
  }
  return requestToSend;
}

function passwordRequest_Remove(requestToSend) {
  var removePassword = (document.getElementById("hdnRemovePassword")) ? document.getElementById("hdnRemovePassword").value : '';
  if (!isEmpty(removePassword)) {
    requestToSend = requestToSend + '&removePassword=' + encodeURIComponent(removePassword);
  }
  return requestToSend;
}

function metadataGet(requestToSend) {
  if (!isEmpty(notepwd)) {
    requestToSend = requestToSend + '&metadataGet=1';
  }
  return requestToSend;
}

function isEmpty(value) {
  return (value == null || value.length === 0);
}

function passwordRemove() {
  document.getElementById("hdnRemovePassword").value = "1";
  uploadContent(true);
  toggleModal_Password();
  document.getElementById("hdnRemovePassword").value = "";
  showRemovePassword();
}

function submitPassword() {
  if (isValid(notepwd.value)) {
    uploadContent(true);
    pwdMessage.innerHTML = "";
    showRemovePassword();
    toggleModal_Password();
  } else {
    pwdMessage.innerHTML = "Please enter a password<br>";
  }
}

// https://www.w3schools.com/howto/howto_js_trigger_button_enter.asp
var passwordInput = document.getElementById("notepwd");
// Execute a function when the user releases a key on the keyboard
if (passwordInput) {
passwordInput.addEventListener("keyup", function(event) {
  event.preventDefault(); // Cancel the default action, if needed
  if (event.keyCode === 13) {  // Number 13 is the "Enter" key on the keyboard
    document.getElementById("submitpwd").click(); // Trigger the button element with a click
  }
}); }
