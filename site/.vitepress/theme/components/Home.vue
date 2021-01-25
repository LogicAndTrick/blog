<template>
  <main class="home">
    <div class="container">
      <div class="content">
        <Content />
      </div>
      <div class="posts">
        <div v-for="cat in categoryGroups" class="category">
          <h2>{{cat.category}}</h2>
          <ul>
            <li v-for="p in cat.posts">
              <a :href="p.href">{{p.title}}</a>
              <span v-if="p.unpublished" class="tag unpublished">unpublished</span>
              <span v-for="t in p.tags" class="tag">{{t}}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useSiteData } from 'vitepress';
import type { DefaultTheme } from 'vitepress/dist/client/theme-default/config';

const siteData = useSiteData<DefaultTheme.Config>();

const categoryGroups = computed(() => {
  const groups = {};
  for (const page of siteData.value.customData.posts) {
    if (!groups[page.category]) groups[page.category] = [];
    groups[page.category].push(page);
  }
  const arr = [];
  for (const key in groups) {
    groups[key].sort((a, b) => a.title.localeCompare(b.title));
    arr.push({ category: key, posts: groups[key] });
  }
  arr.sort((a, b) => a.category.localeCompare(b.category));
  return arr;
})
</script>

<style scoped>
.home {
  padding: 0 2rem 2rem;
}
.container {
  margin: 0 auto;
  padding: 1.5rem;
  max-width: 75rem;
  
  border: 2px solid var(--c-divider-dark);
  border-radius: 0.25rem;
  background-color: white;
}
.content :first-child :first-child {
  margin-top: 0;
}
.content :last-child :last-child {
  margin-bottom: 0;
}
.content {
  padding-bottom: 1rem;
  margin-bottom: 1rem;
  border-bottom: 1px solid var(--c-divider-dark);
}

.posts {
  display: flex;
  flex-flow: row wrap;
}

.posts h2 {
  margin: 0;
  border-bottom-style: dashed;
}

.category {
  flex: 1 1 50%;
}

.posts ul {
  list-style: none;
  padding: 0 1rem;
  margin: 0.5rem 0;
}

.tag {
  border-radius: 0.25rem;
  color: #fff;
  background-color: #54ACFF;
  padding: 0.125rem 0.25rem;
  display: inline;
  margin: 0 0.2rem;
  font-size: 70%;
  font-weight: bold;
}

.tag.unpublished {
  background-color: #ff5e00;
  color: black;
}

</style>
