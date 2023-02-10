<template>
  <div>
      <header>
          <h1 class="text-center py-4 font-mono font-extrabold text-2xl bg-black text-white">COMPANY NAME</h1>
          <nav class="flex flex-row gap-12 justify-center border border-black font-mono py-2">
              <RouterLink to="/" class="hover:-translate-y-0.5 hover:scale-100 transition ease-in-out delay-90">HOME</RouterLink>
              <RouterLink to="/products" class="hover:-translate-y-0.5 hover:scale-102 transition ease-in-out delay-90">CATALOG</RouterLink>
              <RouterLink to="/#" class="hover:-translate-y-0.5 hover:scale-102 transition ease-in-out delay-90">BESTSELLERS</RouterLink>
              <RouterLink to="/#" class="hover:-translate-y-0.5 hover:scale-102 transition ease-in-out delay-90">BLOG</RouterLink>
              <RouterLink to="/#" class="hover:-translate-y-0.5 hover:scale-120 transition ease-in-out delay-90">CONTACT</RouterLink>
          </nav>
      </header>
      <RouterView />
  </div>
</template>

<script setup lang="ts">
</script>
