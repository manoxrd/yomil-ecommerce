<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';
import { ChevronLeft } from '@lucide/vue';
import { ChevronRight } from '@lucide/vue';
import { Ellipsis } from '@lucide/vue';
import { ref } from 'vue';
import FilteringSidebar from '@/components/products/FilteringSidebar.vue';
import ProductCard from '@/components/products/ProductCard.vue';
import SidebarProvider from '@/components/ui/sidebar/SidebarProvider.vue';
import SidebarTrigger from '@/components/ui/sidebar/SidebarTrigger.vue';
import type { Category, Product } from '@/types';

defineProps<{
  products: { data: Product[]; next_page_url: string; prev_page_url: string; current_page: number; total: number; last_page: number; first_page_url: string; last_page_url: string; links: [] };
  categories: Category[];
}>();

const query = new URLSearchParams(window.location.search);

const currentCategory = ref(query.get('category') || '');

const currentRating = query.get('rating') ?? 'any';

const maxPrice = query.get('max_price') || 100;

const minPrice = query.get('min_price') || 25;

const onCategorySelect = (category: any) => {
  router.reload({ data: { category: category.name, page: '1' }, only: ['products'] });
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

  <div class="flex min-h-screen bg-background justify-start">
    <SidebarProvider class="justify-center">
      <FilteringSidebar :categories="categories" :selected-rating="currentRating" :max-price="maxPrice"
        :min-price="minPrice" v-model="currentCategory" @select-category="onCategorySelect"
        @filter-by-review="onReviewSelect" @select-price-range="onPriceRangeSelect" @clear-all-filters="clear" />

      <div class="flex-1 p-6">
        <div class="flex items-center gap-3 mb-6">
          <SidebarTrigger class="md:hidden" />
          <p class="text-sm text-muted-foreground whitespace-nowrap">{{ products.total }} Products</p>
          <div class="flex-1 border-t border-border"></div>
          <p class="text-sm text-muted-foreground whitespace-nowrap">Page {{ products.current_page }} of {{
            products.last_page }}</p>
        </div>
        <div v-if="products.data.length" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          <ProductCard :products="products.data" />
        </div>
        <div v-else class="w-full h-screen text-center pt-25 text-xl font-inter">No Products Match these Filters</div>
        <div class="flex items-center justify-center py-10 gap-x-4">
          <Link :href="products.prev_page_url ?? ''" :class="{
            'text-muted-foreground opacity-50 pointer-events-none': !products.prev_page_url
          }
            ">
            <ChevronLeft />
          </Link>

          <Link v-if="products.current_page > 1" :href="products.first_page_url"
            class="flex items-center justify-center">
            1</Link>

          <p v-if="products.current_page > 2" class="text-muted-foreground">
            <Ellipsis :size="18" />
          </p>

          <Link v-if="products.current_page > 2" :href="products.links[products.current_page - 1]['url']">{{
            products.current_page - 1 }}</Link>

          <div class="flex bg-accent size-8 rounded-full items-center justify-center">{{ products.current_page }}</div>


          <Link v-if="products.current_page < products.last_page"
            :href="products.links[products.current_page + 1]['url']">{{
              products.current_page + 1 }}</Link>

          <p v-if="products.current_page < products.last_page - 1" class="text-muted-foreground">
            <Ellipsis :size="18" />
          </p>

          <Link v-if="products.current_page < products.last_page - 1" :href="products.last_page_url"
            class="flex items-center justify-center">
            {{ products.last_page }}</Link>

          <Link :href="products.next_page_url ?? ''" :class="{
            'text-muted-foreground opacity-50 pointer-events-none': !products.next_page_url
          }
            ">
            <ChevronRight />
          </Link>
        </div>
      </div>
    </SidebarProvider>
  </div>
</template>