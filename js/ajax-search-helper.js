const searchInput = document.getElementById('site-search');
const resultsContainer = document.getElementById('ajax-results');

let debounceTimer;

searchInput.addEventListener('input', function() {
  const query = this.value.trim();

  clearTimeout(debounceTimer);

  if (query.length < 2) {
    resultsContainer.innerHTML = '';
    return;
  }

  debounceTimer = setTimeout(function() {
    fetch(ROOT + 'php/search-ajax.php?q=' + encodeURIComponent(query))
      .then(function(response) {
        return response.text();
      })
      .then(function(html) {
        resultsContainer.innerHTML = html;
      })
      .catch(function(error) {
        console.error('Suche fehlgeschlagen:', error);
      });
  }, 200);
});
