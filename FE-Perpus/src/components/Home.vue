<template>
  <div class="hero bg-info-content min-h-screen">
    <div class="hero-content text-center">
      <div class="max-w-md">
        <div v-if="!authStore.token">
          <h1 class="text-5xl font-bold">Hello there</h1>
          <p class="py-6">
            Untuk dapat mengakses halaman Book, Category dan Borrow. Silahkan Login atau Register terlebih dahulu
          </p>
          <button class="btn btn-primary" @click="$router.push({ name: 'login' })">Get Started</button>
        </div>
        <div v-else>
          <h1 class="text-5xl font-bold">Hello {{ authStore.user.name }}</h1>
          <p class="py-6">
            Mari kita lihat beberapa Buku, dan silahkan lakukan peminjaman buku
          </p>
          <button class="btn btn-primary" @click="$router.push({ name: 'book' })">Get Started</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/AuthStore';

const authStore = useAuthStore()
</script>