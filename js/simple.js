var textareaAdd = document.getElementById('contentAdd'); // used by the simple view

textareaAdd.onkeydown = function(e) {
  if (e.keyCode === 9 || e.which === 9) {
    e.preventDefault();
    var s = this.selectionStart;
    this.value = this.value.substring(0, this.selectionStart) + '\t' + this.value.substring(this.selectionEnd);
    this.selectionEnd = s + 1;
  }
  if (e.keyCode === 13 || e.which === 13) {
    e.preventDefault();
    document.getElementById("content").value += '\n' + textareaAdd.value;
    this.value = '';
  }
}

textareaAdd.focus();
