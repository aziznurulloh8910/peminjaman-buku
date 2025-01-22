<template>
  <div class="max-w-sm sm:max-w-md lg:max-w-xs mx-auto">
    <h1 class="text-2xl font-bold mb-4 flex justify-center">Form Borrow</h1>
    
    <div v-if="authStore.isError" role="alert" class="alert my-4">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info h-6 w-6 shrink-0">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <span>{{ authStore.errorMsg }}</span>
    </div>

    <form @submit.prevent="handleSubmit" class="max-w-md mx-auto p-4">
      <label class="block mb-2">
        <span class="flex justify-center">Load Date</span>
        <input type="datetime-local" class="input input-bordered w-full mt-1" v-model="loadDate" />
      </label>
      <label class="block mb-2">
        <span class="flex justify-center">Borrow Date</span>
        <input type="datetime-local" class="input input-bordered w-full mt-1" v-model="borrowDate" />
      </label>
      <label class="block mb-2">
        <span class="flex justify-center">Select Book</span>
        <select v-model="bookId" class="select select-bordered w-full mt-1">
          <option disabled value="">Select Book</option>
          <option v-for="book in books" :key="book.id" :value="book.id">{{ book.title }}</option>
        </select>
      </label>
      <button type="submit" class="btn btn-primary mt-4 w-full flex justify-center">Submit</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import customApi from '@/api.js'; 
import { useAuthStore } from '@/stores/AuthStore';
import { useRouter, useRoute } from 'vue-router';

const route = useRoute();
const router = useRouter();

const getCurrentDateTime = () => {
  const now = new Date();
  return now.toISOString().slice(0, 16); 
}

const loadDate = ref(getCurrentDateTime()); 
const borrowDate = ref("");
const bookId = ref(route.params.id || ""); 
const books = ref([]); 

const fetchBooks = async () => {
  const { data } = await customApi('/book'); 
  books.value = data.data; 
}

const authStore = useAuthStore();

const handleSubmit = async () => {
  const formData = new FormData();
  formData.append('load_date', loadDate.value);
  formData.append('borrow_date', borrowDate.value);
  formData.append('book_id', bookId.value);

  try {
    await customApi.post(`/borrow`, formData, {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        'Content-Type': 'multipart/form-data'
      }
    });
    alert("Borrow berhasil ditambah/diupdate");

    if (authStore.user.role.name === 'owner') {
      router.push({ name: 'borrow' });
    } else {
      router.push({ name: 'book' });
    }
  } catch (error) {
    console.error(error);
  }
}

onMounted(() => {
  fetchBooks();
});
</script>