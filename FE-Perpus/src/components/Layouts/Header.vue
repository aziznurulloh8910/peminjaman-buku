<template>
  <header class="bg-secondary-content">
    <div class="mx-auto max-w-6xl px-8 -py-20">
      <div class="flex justify-end item-center">
        <ul class="flex flex-wrap">
          <li><RouterLink to="/login" class="mr-5 hover:text-primary">Login</RouterLink></li>
          <li><RouterLink to="/register" class="mr-5 hover:text-primary">Register</RouterLink></li>
        </ul>
      </div>
    </div>
  </header>
</template>

<script setup>
  import { RouterLink } from "vue-router";
</script>