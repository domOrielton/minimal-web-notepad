// based on https://www.w3schools.com/howto/howto_js_bottom_nav_responsive.asp
function navbarResponsive() {
  var x = document.getElementById("navbar");
  if (x.className === "navbar") {
    x.className += " responsive";
  } else {
    x.className = "navbar";
  }
}

var menuButton = document.getElementById("menuButton");

function windowOnClick_navbar(event) {
  // hide responsive menu if displayed by clicking outside of it
  if (event.target.id !== "menuButton") {
    var el = document.getElementById('navbar');
    if (el.className.indexOf('responsive') > -1) {
      el.className = 'navbar';
    }
  }
}

window.addEventListener("click", windowOnClick_navbar);

function downloadFile() {
  var link = document.createElement("a");
  var content = document.getElementById('content').value;
  link.href = "data:application/txt," + encodeURIComponent(content)
  link.download = "note_" + document.title + ".txt";
  link.dispatchEvent(new MouseEvent('click', {
    bubbles: true,
    cancelable: true,
    view: window
  }));
  // a [save as] dialog will be shown
  //window.open("data:application/txt," + encodeURIComponent(content), "_self");
}

function toggleMonospace(lnk_obj) {
  var x = document.getElementById("content");
  lnk_obj.innerHTML = (lnk_obj.innerHTML == 'mono') ? 'sans' : 'mono';
  if (x.style.fontFamily == "monospace") {
    x.style.fontFamily = "sans-serif";
  } else {
    x.style.fontFamily = "monospace";
  }
}

function deleteFile() {
  var r = confirm("Are you sure you want to delete this note?");
  if (r == true) {
    document.getElementById('content').value = '';
    uploadContent();
    alert('Note deleted');
    // Note has been deleted so open a new note (going back to the same note, not a new note, looks confusing)
    var url = window.location.href;
    window.location.href = url.substring(0, url.lastIndexOf('/'));
  }
}
