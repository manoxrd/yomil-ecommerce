<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import {
  NumberField,
  NumberFieldContent,
  NumberFieldDecrement,
  NumberFieldIncrement,
  NumberFieldInput,
} from '@/components/ui/number-field';
import Separator from '@/components/ui/separator/Separator.vue';
import Switch from '@/components/ui/switch/Switch.vue';
import type { Product } from '@/types';

const props = defineProps<{
  product: Product;
}>();

const form = useForm({
  name: props.product.name,
  description: props.product.description,
  price: props.product.price / 100,
  stock: props.product.stock,
  thumbnail: props.product.thumbnail_url,
  is_active: props.product.is_active,
});
</script>

<template>

  <Head :title="product.name" />

  <div class="mx-auto max-w-6xl px-6 py-8">

    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold tracking-tight text-foreground">Edit Product</h1>
        <p class="mt-1 text-sm text-muted-foreground">Update product details and settings.</p>
      </div>
      <div class="flex items-center gap-x-3">
        <Button type="button" variant="outline">Discard</Button>
        <Button type="submit">Save Changes</Button>
      </div>
    </div>

    <Separator class="mb-8" />

    <!--
      All 4 cards are direct children of the outer grid so CSS grid
      can align their heights per row automatically.
      Row 1: Product Info (col-span-2) | Thumbnail (col 3)
      Row 2: Pricing & Inventory (col-span-2) | Status (col 3)
    -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

      <!-- Product Info — row 1, left -->
      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-span-2 lg:row-start-1">
        <h2 class="mb-5 text-sm font-medium text-foreground">Product Information</h2>

        <div class="flex flex-1 flex-col gap-y-5">
          <div class="flex flex-col gap-y-1.5">
            <Label for="product-name">Name</Label>
            <Input id="product-name" name="name" placeholder="e.g. Wireless Headphones" v-model="form.name" />
          </div>

          <div class="flex flex-1 flex-col gap-y-1.5">
            <Label for="product-description">Description</Label>
            <textarea id="product-description" name="description" placeholder="Describe the product..."
              v-model="form.description"
              class="placeholder:text-muted-foreground border-input dark:bg-input/30 w-full flex-1 resize-none rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs outline-none transition-[color,box-shadow] focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50" />
          </div>
        </div>
      </div>

      <!-- Thumbnail — row 1, right -->
      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-start-3 lg:row-start-1">
        <h2 class="mb-4 text-sm font-medium text-foreground">Thumbnail</h2>

        <div class="flex flex-1 flex-col gap-y-3">
          <div class="relative flex-1 overflow-hidden rounded-xl bg-muted/60 dark:bg-muted/30"
            style="min-height: 12rem;">
            <img :src="product.thumbnail_url ?? 'https://placehold.co/600x400?text=No+Image'" :alt="product.name"
              class="h-full w-full object-cover" />
          </div>
          <Button type="button" variant="outline" class="w-full cursor-pointer">
            Upload Image
          </Button>
        </div>
      </div>

      <!-- Pricing & Inventory — row 2, left -->
      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-span-2 lg:row-start-2">
        <h2 class="mb-5 text-sm font-medium text-foreground">Pricing & Inventory</h2>

        <div class="grid grid-cols-2 gap-x-4 gap-y-5">
          <div class="flex flex-col gap-y-1.5">
            <NumberField
              id="product-price"
              v-model="form.price"
              :step="0.01"
              :min="0"
              :format-options="{
                style: 'currency',
                currency: 'USD',
                currencyDisplay: 'code',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              }"
            >
              <Label for="product-price">Price</Label>
              <NumberFieldContent>
                <NumberFieldDecrement />
                <NumberFieldInput />
                <NumberFieldIncrement />
              </NumberFieldContent>
            </NumberField>
            <!-- <div class="relative">
              <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-muted-foreground">$</span>
              <Input
                id="product-price"
                name="price"
                type="number"
                placeholder="0.00"
                class="pl-7"
                v-model="form.price"
              />
            </div> -->
          </div>

          <div class="flex flex-col gap-y-1.5">
            <Label for="product-stock">Stock</Label>
            <Input id="product-stock" name="stock" type="number" placeholder="0" v-model="form.stock" />
          </div>
        </div>
      </div>

      <!-- Status — row 2, right -->
      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-start-3 lg:row-start-2">
        <h2 class="mb-4 text-sm font-medium text-foreground">Status</h2>

        <div class="flex items-center justify-between rounded-lg bg-muted/40 px-4 py-3">
          <div>
            <p class="text-sm font-medium text-foreground">Active</p>
            <p class="text-xs text-muted-foreground">Visible to customers</p>
          </div>
          <Switch v-model="form.is_active" />
        </div>
      </div>

    </div>
  </div>
</template>
