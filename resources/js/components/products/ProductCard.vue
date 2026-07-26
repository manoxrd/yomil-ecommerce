<script setup lang="ts">
// import products from '@/routes/products/index.js';
import { Link } from '@inertiajs/vue3';
import { show } from '@/routes/products';
import type { Product } from '@/types/product.js';
import StarReview from '../StarReview.vue';
import AddToCart from './AddToCart.vue';

defineProps<{
  products: Product[];
}>();



</script>

<template>
  <div v-for="item in products" :key="item.id"
  class="group flex flex-col overflow-hidden rounded-2xl border border-border/80 bg-card text-card-foreground shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-border hover:shadow-xl dark:border-border/60">
  <!-- Image -->
<!-- {{ item.reviews }} -->
  <div class="relative h-56 overflow-hidden bg-muted/60 dark:bg-muted/30">
      <img src="source" :alt="item.name"
        class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />
      <div v-if="false"
        class="absolute top-3 left-3 rounded-full border border-border/50 bg-background/80 px-3 py-1.5 text-xs font-semibold tracking-wide text-foreground shadow-xs backdrop-blur-md dark:bg-background/80 dark:text-foreground">
        <!-- item's discount time -->
      </div>
    </div>

    <!-- Content -->
    <div class="flex grow flex-col p-5">
      <span class="mb-1.5 text-xs font-bold tracking-widest text-muted-foreground uppercase">{{ item.category?.name
        }}</span>
      <h3
        class="mb-2 line-clamp-1 text-lg leading-tight font-bold text-card-foreground transition-colors duration-200 group-hover:text-primary">

        <Link :href="show(item.slug)">
          {{ item.name }}
        </Link>
      </h3>

      <p class="mb-5 line-clamp-2 grow text-sm leading-relaxed text-muted-foreground">
        {{ item.description }}
      </p>

      <div class="mb-5 flex items-center justify-between">
        <span class="text-xl font-black tracking-tight text-foreground">{{
          item.formatted_price
          }}</span>
        <StarReview variant="mini" :size="14" :avg_rating="item.rating" :reviews_count="item.reviews_count" />
      </div>

      <AddToCart
        class="w-full rounded-xl bg-primary text-primary-foreground hover:bg-primary/90 transition-colors shadow-xs" />
    </div>
  </div>
</template>
