(() => {
  'use strict';
  const root = document.getElementById('blog-comments');
  if (!root) return;
  const status = root.querySelector('.comments-status');
  const list = root.querySelector('.comments-list');
  const form = root.querySelector('form');
  const button = form.querySelector('button');
  const post = window.location.pathname;
  let api;
  try {
    if (!root.dataset.api) throw new Error();
    api = new URL(root.dataset.api, window.location.href);
  } catch {
    status.textContent = 'Configura comments_api per abilitare i commenti.';
    button.disabled = true;
    return;
  }
  async function request(url, options) {
    const response = await fetch(url, { credentials: 'omit', ...options });
    const data = await response.json();
    if (!response.ok) throw new Error(data.error || 'Errore del servizio commenti.');
    return data;
  }
  async function load() {
    const url = new URL(api);
    url.searchParams.set('post', post);
    const data = await request(url);
    list.replaceChildren();
    for (const comment of data.comments) {
      const article = document.createElement('article');
      const author = document.createElement('strong');
      author.textContent = comment.author;
      const body = document.createElement('p');
      body.style.whiteSpace = 'pre-wrap';
      body.textContent = comment.body;
      article.append(author, body);
      list.append(article);
    }
    if (!data.comments.length) list.textContent = 'Nessun commento: scrivi il primo!';
  }
  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    button.disabled = true;
    status.textContent = 'Invio in corso…';
    try {
      const fields = new FormData(form);
      const data = await request(api, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ post, author: fields.get('author'), body: fields.get('body'), website: fields.get('website') }),
      });
      form.reset();
      status.textContent = data.message;
      await load();
    } catch (error) {
      status.textContent = error.message;
    } finally {
      button.disabled = false;
    }
  });
  load().catch(() => { status.textContent = 'Impossibile caricare i commenti. Riprova più tardi.'; });
})();
