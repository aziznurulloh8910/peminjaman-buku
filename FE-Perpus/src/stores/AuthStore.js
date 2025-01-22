import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useRouter } from 'vue-router'
import customApi from '@/api'

export const useAuthStore = defineStore('auth', () => {
  const router = useRouter()
  const token = ref(localStorage.getItem('token') ? JSON.parse(localStorage.getItem('token')) : null)
  const user = ref(localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null)

  const isError = ref(false)
  const errorMsg = ref("")

  const loginUser = async (inputData) => {
    try {
      isError.value = false
      errorMsg.value = ""

      const { email, password } = inputData
      const res = await customApi.post('/auth/login', {
        'email' : email,
        'password' : password
      })
      
      const { data } = res

      token.value = data.token
      user.value = data.data
      
      localStorage.setItem('token', JSON.stringify(data.token))
      localStorage.setItem('user', JSON.stringify(data.data))
      
      router.push({ name: 'book' })
    } catch (error) {
      isError.value = true
      errorMsg.value = error.response?.data?.message || "Terjadi Kesalahan"
      console.log(error);
    }
  }

  const registerUser = async (inputData) => {
    try {
      isError.value = false
      errorMsg.value = ""

      const { name, email, password, password_confirmation } = inputData
      const res = await customApi.post('/auth/register', {
        'name' : name,
        'email' : email,
        'password' : password,
        'password_confirmation' : password_confirmation
      })

      const { data } = res

      token.value = data.token
      user.value = data.data
      
      localStorage.setItem('token', JSON.stringify(data.token))
      localStorage.setItem('user', JSON.stringify(data.data))
      
      router.push({ name: 'book' })

    } catch (error) {
      isError.value = true
      errorMsg = error.response?.data?.message || "Terjadi Kesalahan"
      console.log(error);
    }
  }

  const getUserData = async () => {
    try {
      if (!token.value) {
        throw new Error("Token tidak ditemukan");
      }
  
      const res = await customApi.get('/me', {
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      })

      const { data } = res
      user.value = data.data
  
    } catch (error) {
      isError.value = true
      errorMsg.value = error.response?.data?.message || "An error occurred while fetching user data"
      console.log(error)
    }
  }

  const updateProfile = async (data) => {
    try {
      isError.value = false
      errorMsg.value = ""
  
      const formData = new FormData()
      formData.append('age', data.age)
      formData.append('bio', data.bio)
  
      const res = await customApi.post('/profile', formData, {
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      })
      router.push({ name: 'ProfileUser' });
    } catch (error) {
      isError.value = true
      errorMsg.value = error.response?.data?.message || "Terjadi kesalahan saat memperbarui profil"
      console.log(error)
    }
  }

  const logoutUser = async () => {
    const res = await customApi.post('/auth/logout', {}, {
      headers: {
        Authorization: `Bearer ${token.value}` 
      }
    })

    token.value = ""
    user.value = ""

    localStorage.removeItem('token')
    localStorage.removeItem('user')

    const { data } = res
    console.log(data)

    router.push({ name: 'home' })
  }

  return { token, user, loginUser, registerUser, getUserData, updateProfile, logoutUser, isError, errorMsg }
})
