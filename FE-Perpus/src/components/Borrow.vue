<template>
  <div>
    <div class="flex justify-end border-b border-slate-400 pb-2 mb-4">
      <h1 class="lg:text-3xl font-bold text-2xl">Data Peminjaman</h1>
      <RouterLink :to="{ name: 'createBorrow' }" class="btn btn-primary ml-auto">Tambah</RouterLink>
    </div>
    <div class="overflow-x-auto">
      <table class="table">
        <thead class="bg-info-content">
          <tr>
            <th></th>
            <th>Load Date</th>
            <th>Borrow Date</th>
            <th>Nama Buku</th>
            <th>Nama User</th>
          </tr>
        </thead>
        <tbody class="bg-base-300">
          <tr v-for="(borrow, index) in borrows" :key="index">
            <th>{{ index + 1 }}</th>
            <td>{{ borrow.load_date }}</td>
            <td>{{ borrow.borrow_date }}</td>
            <td>{{ borrow.book.title }}</td>
            <td>{{ borrow.user.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router';
import customApi from '../api';
import { useAuthStore } from '@/stores/AuthStore';

const borrows = ref([]);
const authStore = useAuthStore()

console.log(borrows)

const fetchBook = async() => {
  try {
    const response = await customApi.get('/borrow', {
      headers: {
        'Authorization': `Bearer ${authStore.token}`
      }
    })
    borrows.value = response.data.borrows
    
  } catch (error) {
    console.error('Error fetching borrows:', error)
  }
}

onMounted(async () => {
  fetchBook()
})

</script>