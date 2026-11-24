(() => {
  'use strict';
  const endpoint = document.currentScript.dataset.api;
  const counters = document.querySelectorAll('[data-comments-post]');
  if (!endpoint || !counters.length) return;

  async function loadCounts() {
    const url = new URL(endpoint, window.location.href);
    url.searchParams.set('view', 'counts');
    const response = await fetch(url, { credentials: 'omit' });
    if (!response.ok) return;
    const { counts } = await response.json();

    for (const counter of counters) {
      const { pathname } = new URL(counter.dataset.commentsPost, window.location.href);
      const count = Number(counts[pathname] ?? 0);
      counter.textContent = count === 1 ? '1 commento' : `${count} commenti`;
      counter.hidden = false;
    }
  }

  loadCounts().catch(() => {
    // Se l'API non risponde, lascia i conteggi nascosti.
  });
})();
