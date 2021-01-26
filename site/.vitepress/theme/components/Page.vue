<template>
  <main class="page">
    <div class="container">
      <div class="content">
        <h1 class="page-title">{{ $page.title }}</h1>
        <div class="page-info">First posted on {{ dateString }} in {{ $page.frontmatter.category }}</div>
        <Content />
        <div class="page-log" v-if="$page.frontmatter.log && $page.frontmatter.log.length">
          <strong>Article changelog</strong>
          <ul>
            <li v-for="l in log">{{l}}</li>
          </ul>
        </div>
      </div>
      <slot name="bottom" />
    </div>
  </main>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { usePageData } from 'vitepress';

const page = usePageData();

const dateString = computed(() => {
  if (!page.value.frontmatter.date) return 'Unknown date';
  const date = new Date(page.value.frontmatter.date);
  return date.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
});

const log = computed(() => {
  const arr = page.value.frontmatter.log;
  const date = page.value.frontmatter.date;
  if (!arr || !arr.length || !date) return [];
  
  const d = new Date(date);
  let year = d.getFullYear(),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate();
  if (month.length < 2) month = '0' + month;
  if (day.length < 2) day = '0' + day;
  
  const ret = [].concat(arr);
  ret.unshift(`${year}-${month}-${day} - Initial post`);
  return ret;
});
</script>

<style scoped>
.page-title {
    padding-bottom: 0.25rem;
    border-bottom: 2px solid var(--c-divider-light);
    margin: 0 0 0.25rem;
}
.page-info {
  font-size: 1rem;
  font-weight: bold;
}
.page-log {
    border-top: 2px solid var(--c-divider-light);
    padding-top: 1rem;
}

@media (min-width: 960px) {
  .page {
    margin-left: 17rem;
  }
}

.content {
  padding-bottom: 0.5rem;
}
</style>
