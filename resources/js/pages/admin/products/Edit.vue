<script setup lang='ts'>
import { Head } from '@inertiajs/vue3';
import type { Product } from '@/types';


defineProps<{
  product: Product
}>();

</script>

<template>
    <Head :title="product.name"></Head>

  <div>
    <h3>{{ product.name }}</h3>
  </div>
</template>