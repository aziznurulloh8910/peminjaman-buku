<template>
  <section v-if="category">
    <div class="border-b border-slate-400 pb-3">
      <h1 class="text-3xl font-bold">{{ category.name }}</h1>
    </div>
    <div class="mt-4">
      <div v-if="category.books.length">
        <div class="p-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="card bg-base-100 shadow-xl" v-for="book in category.books">
              <figure><img :src="book.image" :alt="book.title" /></figure>
              <div class="card-body">
                <h2 class="card-title">{{ book.title }}</h2>
                <p>{{ book.summary }}</p>
                <div class="card-actions justify-between">
                  <button class="btn btn-sm btn-primary">BORROW</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <h1>Belum ada Buku di Category {{ category.name }}</h1>
      </div>
    </div>
  </section>
</template>

<script setup>
import customApi from '@/api';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const route =  useRoute()

const category = ref("")

const categoryById = async () => {
  const { data } = await customApi(`/categories/${route.params.id}`)
  category.value = data.data

  console.log(data.data);
  
}

onMounted(() => {
  categoryById()
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