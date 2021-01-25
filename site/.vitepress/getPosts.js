const fs = require('fs')
const path = require('path')
const matter = require('gray-matter')
const process = require('process');

// Modified from the Vue blog source - https://github.com/vuejs/blog/blob/master/.vitepress/getPosts.js

exports.getPosts = function getPosts() {
  const env = process.env;
  const postDir = path.resolve(__dirname, '../page')
  return fs
    .readdirSync(postDir)
    .filter(x => x.endsWith('.md')) // only process markdown files
    .map((file) => {
      const src = fs.readFileSync(path.join(postDir, file), 'utf-8')
      const { data } = matter(src)
      if (!data.date) data.date = new Date('2000-01-01');
      return {
        title: data.title,
        category: data.category,
        tags: data.tags || [],
        href: `/page/${file.replace(/\.md$/, '.html')}`,
        date: formatDate(data.date),
        unpublished: !!data.unpublished
      }
    })
    .filter(x => {
      return env.NODE_ENV !== 'production' || !x.unpublished; // Only show unpublished posts in dev mode
    })
    .sort((a, b) => b.date.time - a.date.time) // Sort by publish time, though we re-sort them later anyway...
}

function formatDate(date) {
  if (!date instanceof Date) {
    date = new Date(date)
  }
  date.setUTCHours(12)
  return {
    time: +date,
    string: date.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  }
}
