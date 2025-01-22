import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import BookView from '@/views/BookView.vue'
import BorrowView from '@/views/BorrowView.vue'
import CategoryView from '@/views/CategoryView.vue'
import DetailCategoryComponent from '@/components/category/DetailCategoryComponent.vue'
import UpdateCategoryComponent from '@/components/category/UpdateCategoryComponent.vue'
import CreateCategoryComponent from '@/components/category/CreateCategoryComponent.vue'
import DetailBookComponent from '@/components/book/DetailBookComponent.vue'
import UpdateBookComponent from '@/components/book/UpdateBookComponent.vue'
import CreateBookComponent from '@/components/book/CreateBookComponent.vue'

import { useAuthStore } from '../stores/AuthStore'
import FormBorrowComponent from '@/components/borrow/FormBorrowComponent.vue'
import ProfileUserView from '@/views/ProfileUserView.vue'
import UpdateProfile from '@/components/Auth/UpdateProfile.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/profile/user',
      name: 'ProfileUser',
      component: ProfileUserView,
      meta: { isAuth: true }
    },
    {
      path: '/update/profile',
      name: 'UpdateProfile',
      component: UpdateProfile,
      meta: { isAuth: true }
    },
    
    // book
    {
      path: '/book',
      name: 'book',
      component: BookView,
      meta: { isAuth: true }
    },
    {
      path: '/book/:id/detail',
      name: 'detailBook',
      component: DetailBookComponent,
      meta: { isAuth: true }
    },
    {
      path: '/book/:id/edit',
      name: 'updateBook',
      component: UpdateBookComponent,
      meta: { isAuth: true }
    },
    {
      path: '/create/book',
      name: 'createBook',
      component: CreateBookComponent,
      meta: { isAuth: true }
    },
    
    // category
    {
      path: '/category',
      name: 'category',
      component: CategoryView,
      meta: { isAuth: true }
    },
    {
      path: '/category/:id',
      name: 'detailCategory',
      component: DetailCategoryComponent,
      meta: { isAuth: true }
    },
    {
      path: '/category/:id/edit',
      name: 'updateCategory',
      component: UpdateCategoryComponent,
      meta: { isAuth: true }
    },
    {
      path: '/create/category',
      name: 'createCategory',
      component: CreateCategoryComponent,
      meta: { isAuth: true }
    },

    // borrow
    {
      path: '/borrow',
      name: 'borrow',
      component: BorrowView,
      meta: { isAuth: true, isOwner: true }
    },
    {
      path: '/borrow',
      name: 'createBorrow',
      component: FormBorrowComponent,
      meta: { isAuth: true}
    },
    {
      path: '/borrow/book/:id',
      name: 'borrowBook',
      component: FormBorrowComponent,
      meta: { isAuth: true }
    },
  ]
})

router.beforeEach(async (to, from) => {
  const authStore = await useAuthStore()
  if (to.meta.isAuth && !authStore.token) {
    alert("Anda Harus Login dulu")
    return {
      path: '/login'
    }
  }
  if (to.meta.isOwner && authStore.user.role.name !== 'owner') {
    alert("Hanya Owner yang dapat melihat data Peminjaman")
    return {
      path: '/book'
    }
  }
  if ((to.name === 'login' || to.name === 'register') && authStore.token) {
    alert("Anda sudah login, silakan logout untuk mengakses halaman ini")
    return {
      path: '/book'
    }
  }
})

export default router