---
layout: default
title: Blog
---
  <div class="window">
    <div class="title-bar">
      <div class="title-bar-text">
        Blog
      </div>
  <div class="title-bar-controls">
    <button aria-label="Any Text" class="help"></button>
    <button aria-label="Any Text" class="close"></button>
  </div>
    </div>
    <div class="window-body">
	  <img class="responsive-image" src="assets/images/blog_header.jpg" alt="War Games">
      <p>Lo pseudo-blog di uno pseudo-informatico.</p>
	  
 {% for post in site.posts %}
 <hr>
    <p>{{ post.date | localize: "%-d %B %Y" }}</p>
	<div style="margin-bottom: 4px;font-size: 20px;font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;">
  		{{ post.title }}
	</div>
      <div class="field-border" style="padding: 8px; font-size: 16px;font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;">
          {{ post.content }}
      </div>
	<div class="status-field-border" style="padding: 8px">
  		Commenti?
	</div>
	<br>
 {% endfor %}
    </div>
  </div>
