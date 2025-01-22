<template>
  <div class="max-w-sm sm:max-w-md lg:max-w-xs mx-auto">
    <h1 class="text-2xl font-bold mb-4 flex justify-center">Update Profile</h1>

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

    <form @submit.prevent="updateProfileHandler">
      <label class="input input-bordered flex items-center gap-2 mb-2">
        <input type="number" class="grow" placeholder="Age" v-model="form.age" />
      </label>
      <label class="flex items-center gap-2 mb-2">
        <textarea class="textarea textarea-bordered grow w-full h-48 resize-none" placeholder="Biodata" v-model="form.bio"></textarea>
      </label>
      <button type="submit" class="btn btn-primary w-full mt-4">Update</button>
    </form>
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
import { useAuthStore } from '@/stores/AuthStore'

const authStore = useAuthStore()

const form = reactive({
  age: '',
  bio: ''
})

onMounted(() => {
  if (authStore.user && authStore.user.profile) {
    form.age = authStore.user.profile.age;
    form.bio = authStore.user.profile.bio;
  }
})

const updateProfileHandler = async () => {
  try {
    await authStore.updateProfile(form)
  } catch (error) {
    alert(error)
  }
}
</script>