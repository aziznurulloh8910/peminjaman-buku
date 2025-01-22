<template>
  <div>
    <div class="flex justify-end border-b border-slate-400 pb-2 mb-4">
      <h1 class="lg:text-3xl font-bold text-2xl">Data Kategori</h1>
      <RouterLink :to="{ name: 'createCategory' }" class="btn btn-primary ml-auto" v-if="authStore.user && authStore.user.role && authStore.user.role.name === 'owner'">Tambah</RouterLink>
    </div>
    <div class="overflow-x-auto">
      <table class="table">
        <thead class="bg-info-content">
          <tr>
            <th></th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="bg-base-300">
          <tr v-for="(category, index) in categories" :key="index">
            <th>{{ index + 1 }}</th>
            <td>{{ category.name }}</td>
            <td>
              <RouterLink :to="{ name: 'detailCategory', params: { id: category.id } }" class="btn btn-sm btn-base-300 text-secondary mr-2">Detail</RouterLink>
              <RouterLink :to="{ name: 'updateCategory', params: { id: category.id } }" class="btn btn-sm btn-base-300 text-warning mr-2" v-if="authStore.user && authStore.user.role && authStore.user.role.name === 'owner'">Edit</RouterLink>
              <button @click="deleteCategory(category.id)" class="btn btn-sm btn-base-300 text-error" v-if="authStore.user && authStore.user.role && authStore.user.role.name === 'owner'">Delete</button>
            </td>
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

const categories = ref([]);
const authStore = useAuthStore()

const fetchCategory = async() => {
  try {
    const response = await customApi.get('/categories');
    categories.value = response.data.data; 
  } catch (error) {
    console.error('Error fetching categories:', error);
  }
}

const deleteCategory = async(id) => {
  try {
      await customApi.post(`/categories/${id}?_method=DELETE`, null, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      });
    } catch (error) {
      console.error(error);
    }
  
    alert("Category berhasil dihapus")
    fetchCategory()
}

onMounted(async () => {
  fetchCategory()
});
</script>