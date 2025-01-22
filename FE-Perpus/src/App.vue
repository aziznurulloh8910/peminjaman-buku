<template>
  <Header v-if="!authStore.token" />
  <Navbar />
  
  <main class="mx-auto max-w-6xl px-8 py-10">
    <RouterView v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" />
      </transition>
    </RouterView>
  </main>
</template>

<script setup>
import { RouterView } from 'vue-router';
import Header from './components/Layouts/Header.vue'
import Navbar from './components/Layouts/Navbar.vue'
import { useAuthStore } from './stores/AuthStore';

const authStore = useAuthStore()
</script>
<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
.fade-enter-to, .fade-leave {
  opacity: 1;
}
</style>