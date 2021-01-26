<template>
  <header class="nav-bar">
    <div class="nav-wrapper">
      <a class="nav-bar-title" :href="$site.base" >
        <img v-if="$themeConfig.logo" class="logo" :src="$withBase($themeConfig.logo)" alt="{{ $site.title }}" />
        <span v-else>{{ $site.title }}</span>
      </a>

      <div class="flex-grow" />

      <div class="nav">
        <span>© Logic &amp; Trick {{ currentYear }}</span>
        <span class="splitter">&bull;</span>
        <a href="https://github.com/LogicAndTrick">Github</a>
        <span class="splitter">&bull;</span>
        <a href="https://creativecommons.org/licenses/by-nc-nd/3.0/">
          <img alt="Creative Commons License" src="/cc-by-nc-nd.png">
        </a>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { defineEmit, computed } from 'vue'

defineEmit(['toggle'])

const currentYear = computed(() => {
  const dt = new Date();
  return dt.getFullYear();
});
</script>

<style scoped>
.nav-bar {
  z-index: var(--z-index-navbar);
  padding: .7rem .5rem;
  height: var(--header-height);
  border-bottom: 1px solid var(--c-divider-light);
}

@media (min-width: 701px) {
  .nav-bar {
    border-bottom: 0;
    padding: .7rem 3rem;
  }
}

.nav-wrapper {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.flex-grow {
  flex-grow: 1;
}

.nav {
  display: flex;
  white-space: nowrap;
  flex-flow: column nowrap;
  line-height: 0.8rem;
  font-size: 0.8rem;
  margin-left: 0.5rem;
}

.nav .splitter {
  visibility: hidden;
  height: 0.25rem;
}

@media (min-width: 700px) {
  .nav {
    flex-flow: row nowrap;
    line-height: 1rem;
    font-size: 1rem;
  }
  .nav .splitter {
    visibility: visible;
    height: auto;
    margin: 0 0.25rem;
  }
}
</style>
