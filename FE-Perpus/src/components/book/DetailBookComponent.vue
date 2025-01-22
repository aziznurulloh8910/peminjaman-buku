<template>
  <section>
    <div class="card lg:card-side bg-secondary-content shadow-xl">
      <figure>
        <img
          :src="book.image"
          alt="Album" />
      </figure>
      <div class="card-body">
        <h2 class="card-title text-3xl font-bold border-b border-slate-400 pb-3">{{ book.title }}</h2>
        <p>Stok : {{ book.stok }} <br/> Summary : <br/> {{ book.summary }}</p>
        <div class="card-actions justify-end">
          <RouterLink :to="{ name: 'borrowBook', params: { id: book.id } }" class="btn btn-primary">Borrow</RouterLink>
          <RouterLink :to="{ name: 'book' }" class="btn btn-secondary">Back</RouterLink>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import customApi from '@/api';
import { ref, onMounted } from 'vue';
import { useRoute, RouterLink } from 'vue-router';

const route = useRoute()

const book = ref("")

const bookById = async () => {
  const { data } = await customApi(`/book/${route.params.id}`)
  book.value = data.data
  console.log(data);
}

onMounted(() => {
  bookById()
})
</script>