<template>
	<div class="max-w-sm sm:max-w-md lg:max-w-xs mx-auto">
		<h1 class="text-2xl font-bold mb-4 flex justify-center">{{ props.title }} Book</h1>
		
		<div v-if="authStore.isError" role="alert" class="alert my-4">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info h-6 w-6 shrink-0">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
			</svg>
			<span>{{ authStore.errorMsg }}</span>
		</div>

		<form @submit.prevent="handleSubmit" class="max-w-md mx-auto p-4">
			<label class="input input-bordered flex items-center gap-2 mb-2">
				<input type="text" class="grow" placeholder="Title" v-model="title" />
			</label>
			<label class="flex items-center gap-2 mb-2">
				<textarea class="textarea textarea-bordered w-full h-48 resize-none" placeholder="Summary" v-model="summary"></textarea>
			</label>
			<label class="input input-bordered flex items-center gap-2 mb-2">
				<input type="number" class="grow" placeholder="Stok" v-model="stok" />
			</label>
			<label class="flex items-center gap-2 mb-2">
				<select v-model="categoryId" class="select select-bordered input">
					<option disabled value="">Select Category</option>
					<option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
				</select>
			</label>
			<label class="input input-bordered flex items-start gap-2 mb-2">
				<input type="file" class="file-input file-input-ghost" @change="onFileChange" />
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

const title = ref("");
const summary = ref("");
const stok = ref("");
const categoryId = ref("");
const image = ref(null);
const categories = ref([]); 

const fetchCategories = async () => {
  const { data } = await customApi('/categories'); 
  categories.value = data.data; 
}

const bookById = async () => {
  const { data } = await customApi(`/book/${route.params.id}`);
  title.value = data.data.title;
  summary.value = data.data.summary;
  stok.value = data.data.stok;
  categoryId.value = data.data.category_id;
}

const authStore = useAuthStore();
const router = useRouter();

const onFileChange = (event) => {
  image.value = event.target.files[0];
}

const handleSubmit = async () => {
  const formData = new FormData();
  formData.append('title', title.value);
  formData.append('summary', summary.value);
  formData.append('stok', stok.value);
  formData.append('category_id', categoryId.value);
  if (image.value) {
    formData.append('image', image.value);
  }

  try {
    if (!props.isUpdate) {
      await customApi.post('/book', formData, {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
          'Content-Type': 'multipart/form-data'
        }
      });
      alert("Book berhasil dibuat");
    } else {
      await customApi.post(`/book/${route.params.id}?_method=PUT`, formData, {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
          'Content-Type': 'multipart/form-data'
        }
      });
      alert("Book berhasil diupdate");
    }
    router.push({ name: 'book' });
  } catch (error) {
    console.error(error);
  }
}

onMounted(() => {
	fetchCategories();
	if (props.isUpdate) {
		bookById();
	}
});
</script>