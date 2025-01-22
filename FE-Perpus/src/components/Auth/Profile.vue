<template>
  <section>
    <div class="flex border-b border-slate-400 pb-3 mb-8">
      <h1 class="text-3xl font-bold">Profile User</h1>
    </div>
    <div v-if="authStore.user" class="flex justify-start mb-2">
      <h1>Nama : {{ authStore.user.name }}</h1>
    </div>
    <div v-if="authStore.user" class="flex justify-start mb-2">
      <h1>Email : {{ authStore.user.email }}</h1>
    </div>
    <div v-if="authStore.user && authStore.user.profile" class="flex justify-start mb-2">
      <h1>Age : {{ authStore.user.profile.age }}</h1>
    </div>
    <div v-if="authStore.user && authStore.user.profile" class="flex justify-start mb-2">
      <h1>Biodata : {{ authStore.user.profile.bio }}</h1>
    </div>

    <div class="flex justify-start mb-4 gap-2">
      <router-link :to="{name: 'UpdateProfile'}">
        <button class="border border-slate-400 text-slate-400 px-4 py-2 rounded hover:bg-primary hover:text-white hover:border-base-300">Update Profile</button>
      </router-link>
    </div>
  </section>
</template>

<script setup>
import { useAuthStore } from '@/stores/AuthStore';
import { onMounted } from 'vue';

const authStore = useAuthStore();

onMounted(() => {
  authStore.getUserData();
  console.log(authStore.getUserData());
});
</script>
