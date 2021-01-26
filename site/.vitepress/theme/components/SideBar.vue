<template>
  <aside class="sidebar" :class="{ open }">
    <slot name="sidebar-top" />
    <p class="sidebar-header">{{ $page.title }}</p>
    <SideBarLinks />
    <slot name="sidebar-bottom" />
  </aside>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'
import SideBarLinks from 'vitepress/dist/client/theme-default/components/SideBarLinks.vue'

defineProps({
  open: { type: Boolean, required: true }
})
</script>

<style scoped>
.sidebar {
  display: none;
}

.sidebar-header {
  font-style: italic;
  padding: .35rem 0.75rem;
  margin: 0;
  border-bottom: 2px solid var(--c-divider-dark);
}

@media (min-width: 960px) {
  .sidebar {
    display: block;
    position: fixed;
    top: var(--header-height);
    bottom: 0;
    left: 0;
    margin: 0 1rem 1rem;
    z-index: var(--z-index-sidebar);
    width: 16rem;
    overflow-y: auto;
    transform: translateX(0);
  }
}

.sidebar.open {
  transform: translateX(0);
}

.nav {
  display: block;
}

@media (min-width: 820px) {
  .nav {
    display: none;
  }
}
</style>
