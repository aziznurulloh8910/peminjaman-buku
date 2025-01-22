<template>
  <div class="navbar bg-primary-content">
    <div class="navbar-start">
      <div class="dropdown">
        <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h8m-8 6h16" />
          </svg>
        </div>
        <ul
          tabindex="0"
          class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
          <li v-for="nav in listNav" :key="nav.id">
            <RouterLink :to="nav.url">{{ nav.name }}</RouterLink>
          </li>
        </ul>
      </div>
      <a class="btn btn-ghost text-xl"><RouterLink to="/">Perpus SanberCode</RouterLink></a>
    </div>
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal px-1">
        <li v-for="nav in listNav" :key="nav.id">
          <RouterLink :to="nav.url">{{ nav.name }}</RouterLink>
        </li>
      </ul>
    </div>
    <div class="navbar-end">
      <ul class="menu menu-horizontal px-1" v-if="authStore.token">
        <li>
          <details>
            <summary>Hi! {{ authStore.user.name }}</summary>
            <ul class="bg-secondary-content rounded-t-none p-2">
              <li>
                <a><RouterLink :to="{ name: 'ProfileUser' }">Profile</RouterLink></a>
              </li>
              <li>
                <a><RouterLink to="/" @click="handleLogout">Logout</RouterLink></a>
              </li>
            </ul>
          </details>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/AuthStore'
import { computed } from 'vue'

const authStore = useAuthStore()

const handleLogout = () => {
  authStore.logoutUser()
}

const listNav = computed(() => [
  {
    id: 1,
    name: "Buku",
    url: "/book"
  },
  {
    id: 2,
    name: "Kategori",
    url: "/category"
  },
  {
    id: 3,
    name: "Peminjaman",
    url: "/borrow"
  },
])
</script>