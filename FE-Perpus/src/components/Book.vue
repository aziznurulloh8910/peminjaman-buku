<template>
  <section>
    <div class="flex border-b border-slate-400 pb-2 mb-8">
      <h1 class="lg:text-3xl text-2xl font-bold">Buku</h1>
      <RouterLink :to="{ name: 'createBook' }" class="btn btn-primary flex justify-end ml-auto" v-if="authStore.user && authStore.user.role && authStore.user.role.name === 'owner'">Tambah</RouterLink>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div class="card bg-info-content shadow-xl mb-4" v-for="book in books" :key="book.id">
        <figure><img :src="book.image" :alt="book.title" /></figure>
        <div class="card-body">
          <h2 class="card-title">{{ book.title }}</h2>
          <p>Stok: {{ book.stok }}<br/>Kategori: {{ book.category.name }}</p>
          <p>{{ shortSummary(book.summary) }}</p>
          <div class="card-actions justify-center">
            <RouterLink :to="{ name: 'detailBook', params: { id: book.id } }" class="btn btn-sm btn-base-300 text-secondary">DETAIL</RouterLink>
            <RouterLink :to="{ name: 'updateBook', params: { id: book.id } }" class="btn btn-sm btn-base-300 text-warning" v-if="authStore.user && authStore.user.role && authStore.user.role.name === 'owner'">UPDATE</RouterLink>
            <RouterLink :to="{ name: 'borrowBook', params: { id: book.id } }" class="btn btn-sm btn-base-300 text-info">BORROW</RouterLink>
            <button @click="deleteBook(book.id)" class="btn btn-sm btn-base-300 text-error" v-if="authStore.user && authStore.user.role && authStore.user.role.name === 'owner'">DELETE</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import customApi from '@/api';
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router';
import { useAuthStore } from '@/stores/AuthStore';

const books = ref("")
const authStore = useAuthStore()

const fetchBook = async () => {
  try {
    const response = await customApi('/book')
    books.value = response.data.data    
  } catch (error) {
    console.error('Error fetching book:', error);
  }
}

const shortSummary = (summary) => {
  return summary.split(' ').slice(0, 7).join(' ') + (summary.split(' ').length > 5 ? ' ...' : '');
}

const deleteBook = async (id) => {
  try {
      await customApi.post(`/book/${id}?_method=DELETE`, null, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      });
    } catch (error) {
      console.error(error);
    }
  
    alert("Book berhasil dihapus")
    fetchBook()
}

onMounted(() => {
  fetchBook()
})
</script>

<style scoped>
.card {
  transition: transform 0.2s;
}
.card:hover {
  transform: scale(1.05);
}
</style>