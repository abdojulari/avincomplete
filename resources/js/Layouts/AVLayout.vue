<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const page = usePage();
const isHomePage = computed(() => page.url === '/');
</script>

<template>
  <div
    :class="['min-h-screen flex flex-col p-6 sm:pt-0 bg-cover bg-center dark:bg-gray-900 xl:bg-cover']"
    :style="{
      backgroundImage: isHomePage ? `url('https://www.archpaper.com/wp-content/uploads/2021/02/03_Milner-Library_Andrew-Latreille-scaled.jpg')` : 'none'
    }"
  >
    <div>
        <Link href="/">
            <ApplicationLogo class="m-6" />
        </Link>
    </div>

    <div v-if="isHomePage"
         class="sm:max-w-md mt-6 px-6 py-4 bg-white/75 backdrop-blur-sm">
      <slot />
    </div>
    <div v-else
         class="w-full mt-6 px-6 py-4 ">
      <slot />
    </div>
  </div>
</template>
