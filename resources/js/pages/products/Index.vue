<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import { router } from "@inertiajs/vue3";
import FilteringSidebar from '@/components/products/FilteringSidebar.vue';
import ProductCard from '@/components/products/ProductCard.vue';
import SidebarProvider from '@/components/ui/sidebar/SidebarProvider.vue';
import type { Category, Product } from '@/types';

defineProps<{
  products: Product[];
  categories: Category[]
}>();

const query = new URLSearchParams(window.location.search);

const currentCategory = query.get('category') || '';

const maxPrice = query.get('max_price') || 100;

const minPrice = query.get('min_price') || 25;

const onCategorySelect = (category: any) => {

  if (currentCategory !== category.name) {
    router.reload({ data: { category: category.name }, only: ['products'] });
  }
};

const onReviewSelect = (index: number) => {

  router.reload({ data: { rating: index }, only: ['products'] });
};

const onPriceRangeSelect = (priceRange: number[]) => {

  router.reload({ data: { min_price: priceRange[0], max_price: priceRange[1] }, only: ['products'] });
};

const clear = () => {
  window.location.search = '';
}

</script>

<template>

  <Head title="Products Catalog" />

  <div class="flex min-h-screen justify-start bg-background">
    <SidebarProvider class="w-fit">
      <FilteringSidebar :categories="categories" :max-price="maxPrice" :min-price="minPrice" :currentCategory="currentCategory" @select-category="onCategorySelect"
        @filter-by-review="onReviewSelect" @select-price-range="onPriceRangeSelect" @clear-all-filters="clear" />
    </SidebarProvider>

    <div class="flex-1 p-6">
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <ProductCard :products="products" />
      </div>
    </div>
  </div>
</template>