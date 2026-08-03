<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import ProductCard from '@/components/products/ProductCard.vue';
import ProductInfo from '@/components/products/ProductInfo.vue';
import StarReview from '@/components/StarReview.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import type { Product } from '@/types';

const reviews = [
  {
    id: 1,
    name: 'Sarah Jenkins',
    avatar: 'https://i.pravatar.cc/150?u=sarah',
    date: 'October 12, 2025',
    rating: 5,
    title: 'Perfect!',
    content:
      'Absolutely love this! The build quality is fantastic and it arrived much faster than expected. Worth every penny.',
  },
  {
    id: 2,
    name: 'Michael Chen',
    avatar: 'https://i.pravatar.cc/150?u=michael',
    date: 'September 28, 2025',
    rating: 4,
    title: 'Good, but minor packaging issue',
    content:
      'Great product overall. It does exactly what it says it will do. Giving it 4 stars because the packaging was a bit damaged, but the item itself is pristine.',
  },
  {
    id: 3,
    name: 'Emily Rodriguez',
    avatar: 'https://i.pravatar.cc/150?u=emily',
    date: 'September 15, 2025',
    rating: 5,
    title: 'Exceeded my expectations',
    content:
      'I was skeptical at first, but this completely exceeded my expectations. The design is sleek and modern.',
  },
  {
    id: 4,
    name: 'David Smith',
    avatar: 'https://i.pravatar.cc/150?u=david',
    date: 'August 02, 2025',
    rating: 5,
    title: 'Amazing gift!',
    content:
      'Bought this as a gift for my brother and he uses it every single day. Very happy with this purchase!',
  },
];

const relatedProducts = [
  {
  id: 1,
  user_id: 1,
  category_id: 1,
  name: 'hi there',
  slug: 'hi-there',
  description: 'wewewewe',
  price: 300,
  stock: 1,
  thumbnail_url: 'null',
  is_active: true
  },
  {
  id: 1,
  user_id: 1,
  category_id: 1,
  name: 'hi there',
  slug: 'hi-there',
  description: 'wewewewe',
  price: 300,
  stock: 1,
  thumbnail_url: 'null',
  is_active: true
  },
  {
  id: 1,
  user_id: 1,
  category_id: 1,
  name: 'hi there',
  slug: 'hi-there',
  description: 'wewewewe',
  price: 300,
  stock: 1,
  thumbnail_url: 'null',
  is_active: true
  },
  {
  id: 1,
  user_id: 1,
  category_id: 1,
  name: 'hi there',
  slug: 'hi-there',
  description: 'wewewewe',
  price: 300,
  stock: 1,
  thumbnail_url: 'null',
  is_active: true
  },
  {
  id: 1,
  user_id: 1,
  category_id: 1,
  name: 'hi there',
  slug: 'hi-there',
  description: 'wewewewe',
  price: 300,
  stock: 1,
  thumbnail_url: 'null',
  is_active: true
  },
  
];

defineProps<{
  product: Product;
}>();
</script>

<template>
  <Head :title="product.name" />

  <div
    class="mx-auto flex w-full max-w-7xl flex-col gap-y-18 px-5 py-6 sm:py-16 md:px-10 xl:px-12"
  >
    <section class="flex flex-col gap-x-8 sm:flex-row lg:gap-x-12">
      <div class="flex flex-col gap-y-4 sm:w-1/2">
        <img v-if="product.thumbnail_url" src="" alt="" />
        <div v-else class="h-110 w-full rounded-4xl bg-gray-500"></div>
      </div>

      <ProductInfo :product="product" />
    </section>

    <section>
      <Heading variant="large" class="font-inter" title="Reviews" />

      <div class="flex items-center justify-between">
        <span>Showing 1-4 of 24 results</span>

        <div>
          <Select default-value="latest">
            <SelectTrigger>
              <SelectValue />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="latest">Latest</SelectItem>
              <SelectItem value="highest-rating">Highest Rating</SelectItem>
              <SelectItem value="lowest-rating">Lowest Rating</SelectItem>
            </SelectContent>
          </Select>
        </div>
      </div>

      <div class="mt-8 flex flex-col gap-y-6">
        <div
          v-for="review in reviews"
          :key="review.id"
          class="flex flex-col gap-y-3 border-b border-gray-100 pb-6 last:border-0 dark:border-gray-800"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-x-4">
              <img
                :src="review.avatar"
                :alt="review.name"
                class="h-10 w-10 rounded-full bg-gray-200 object-cover dark:bg-gray-700"
              />
              <div class="flex flex-col">
                <span class="text-sm font-semibold">{{ review.name }}</span>
                <span class="text-xs text-gray-500">{{ review.date }}</span>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-y-2">
            <span class="text-lg font-bold">{{ review.title }}</span>
            <p
              class="mb-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400"
            >
              {{ review.content }}
            </p>

            <div class="flex gap-x-0.5">
              <StarReview variant="person" :size="20" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <Heading variant="large" class="font-inter" title="You might also like" />

      <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <ProductCard :products="relatedProducts" />
      </div>
    </section>
  </div>
</template>
