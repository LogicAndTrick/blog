<template>
  <header class="nav-bar">
    <div class="nav-wrapper">
      <a class="nav-bar-title" :href="$site.base" >
        <img v-if="$themeConfig.logo" class="logo" :src="$withBase($themeConfig.logo)" alt="{{ $site.title }}" />
        <span v-else>{{ $site.title }}</span>
      </a>

      <div class="flex-grow" />

      <div class="nav">
        <span>© Logic &amp; Trick 2021</span>
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
import { defineEmit } from 'vue'

defineEmit(['toggle'])
</script>

<style scoped>
.nav-bar {
  z-index: var(--z-index-navbar);
  padding: .7rem 1.5rem;
  height: var(--header-height);
  margin-bottom: 1rem;
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
  flex-flow: column nowrap;
  line-height: 0.8rem;
  font-size: 0.8rem;
}

.nav .splitter {
  visibility: hidden;
  height: 0.25rem;
}

@media (min-width: 820px) {
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
