<template>
	<div class="max-w-sm sm:max-w-md lg:max-w-xs mx-auto">
		<h1 class="text-2xl font-bold mb-4 flex justify-center">{{ props.title }} Category</h1>
		
    <div v-if="authStore.isError" role="alert" class="alert my-4">
			<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					class="stroke-info h-6 w-6 shrink-0">
					<path
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
			<span>{{ authStore.errorMsg }}</span>
		</div>

    <form @submit.prevent="handleSubmit" class="max-w-md mx-auto p-4">
      <label class="input input-bordered flex items-center gap-2 mb-2">
        <input type="text" class="grow" placeholder="Category Name" v-model="name" />
      </label>
      <button type="submit" class="btn btn-primary w-full mt-4">Submit</button>
    </form>
	</div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import customApi from '@/api.js'; 
import { useAuthStore } from '@/stores/AuthStore';
import { useRouter, useRoute } from 'vue-router';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  isUpdate: {
    type: Boolean,
    default: false,
  }
})

const route = useRoute()

const name = ref("")

const categoryById = async () => {
  const { data } = await customApi(`/categories/${route.params.id}`)
  name.value = data.data.name
}

const authStore = useAuthStore()
const router = useRouter()


const handleSubmit = async () => {
  if (!props.isUpdate) {
    try {
      await customApi.post('/categories', { 
        name: name.value
      }, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      });
    } catch (error) {
      console.error(error);
    }
  
    alert("Category berhasil dibuat")
    router.push({ name: 'category' })
  } else {
    try {
      await customApi.post(`/categories/${route.params.id}?_method=PUT`, { 
        name: name.value
      }, {
        headers: {
          Authorization: `Bearer ${authStore.token}`
        }
      });
    } catch (error) {
      console.error(error);
    }
  
    alert("Category berhasil diupdate")
    router.push({ name: 'category' })
  }
}

onMounted(() => {
  if (props.isUpdate) {
    categoryById()
  }
})
</script>