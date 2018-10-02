//make sure the querySelector code is run *after* the page content loads
// based on https://sabe.io/tutorials/how-to-create-modal-popup-box
var modal_password = document.querySelector(".modal_password");
var modal_copy = document.querySelector(".modal_copy");
var closeButton_password = document.querySelector(".close-button_password");
var closeButton_copy = document.querySelector(".close-button_copy");

function toggleModal_Password() {
  //todo: add parameter for which modal to just a single function?
  inputboxLocation.innerHTML = "<input type='password' class='input' name='notepwd' id='notepwd' autocomplete='off'>"
  modal_password.classList.toggle("show-modal");
  document.getElementById("notepwd").focus();
}

function toggleModal_Copy() {
  //todo: add parameter for which modal?
  document.getElementById("copyMessage").innerHTML = "<br> <br>";
  modal_copy.classList.toggle("show-modal");
}

function windowOnClick_Modal(event) {
  // modal window windows if clicking outside of them
  if (event.target === modal_password) {
    toggleModal_Password();
  }
  if (event.target === modal_copy) {
    toggleModal_Copy();
  }
}

if (closeButton_password) closeButton_password.addEventListener("click", toggleModal_Password);
if (closeButton_copy) closeButton_copy.addEventListener("click", toggleModal_Copy);
window.addEventListener("click", windowOnClick_Modal);

function showRemovePassword() {
  el = document.getElementById("removePassword");
  el.style.display = (el.style.display == "none") ? "inline" : "none";
}

function checkallowReadOnlyView() {
  el = document.getElementById('allowReadOnlyView');
  el.checked = true;
}

function removePassword() {
  inputboxLocation.innerHTML = "<input type='password' name='notepwd' id='notepwd' autocomplete='off'>"
  el = document.getElementById("overlay");
  el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
  document.getElementById("notepwd").focus();
}

function isValid(str) {
  return str.replace(/^\s+/g, '').length; // boolean ('true' if field is empty)
}
