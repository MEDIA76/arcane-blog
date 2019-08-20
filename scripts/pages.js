(function() {
  var language = document.getElementById('language');

  language.addEventListener('change', function() {
    window.location.href = this.value;
  });
})();