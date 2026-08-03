<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { update } from '@/actions/App/Http/Controllers/Admin/ProductController';
import InputError from '@/components/InputError.vue';
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
// import Progress from '@/components/ui/progress/Progress.vue';
import Separator from '@/components/ui/separator/Separator.vue';
// import Sonner from '@/components/ui/sonner/Sonner.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import Switch from '@/components/ui/switch/Switch.vue';
import type { Product } from '@/types';

const props = defineProps<{
  product: Product;
}>();

const form = useForm({
  _method: 'patch',
  name: props.product.name,
  description: props.product.description,
  price: props.product.price,
  stock: props.product.stock,
  thumbnail: null,
  is_active: props.product.is_active,
});

const submit = () => {
  form.post(update.url(props.product.id), {
    onSuccess: () => {
      toast.success('Your Product has been updated')
    },
  })
}
</script>

<template>

  <Head :title="product.name" />

  <form @submit.prevent="submit" class="max-w-6xl px-6 py-8" enctype="multipart/form-data">

    <div class="mb-8 flex flex-col sm:flex-row gap-y-4 justify-between">
      <div>
        <h1 class="text-2xl font-semibold tracking-tight text-foreground">Edit Product</h1>
        <p class="mt-1 text-sm text-muted-foreground">Update product details and settings.</p>
      </div>
      <div class="flex items-center gap-x-3">
        <Button type="button" variant="outline">Discard</Button>
        <Button type="submit" :disabled="form.processing">
          <Spinner v-if="form.processing" />
          Save Changes
        </Button>
      </div>
    </div>

    <div>
      <progress v-if="form.progress" class="w-full h-3 rounded-full appearance-none block overflow-hidden bg-slate-100
         [&::-webkit-progress-bar]:bg-slate-100 [&::-webkit-progress-bar]:rounded-xl
         [&::-webkit-progress-value]:bg-indigo-600 
         [&::-moz-progress-bar]:bg-indigo-600" max="100" :value="form.progress?.percentage">
        {{ form.progress?.percentage }}% 12312
      </progress>
      <Separator class="mb-8" />
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-span-2 lg:row-start-1">
        <h2 class="mb-5 text-sm font-medium text-foreground">Product Information</h2>

        <div class="flex flex-1 flex-col gap-y-5">
          <div class="flex flex-col gap-y-1.5">
            <Label for="product-name">Name</Label>
            <Input id="product-name" name="name" placeholder="e.g. Wireless Headphones" v-model="form.name" />
            <InputError v-if="form.errors.name" :message="form.errors.name" />
          </div>

          <div class="flex flex-1 flex-col gap-y-1.5">
            <Label for="product-description">Description</Label>
            <textarea id="product-description" name="description" placeholder="Describe the product..."
              v-model="form.description"
              class="placeholder:text-muted-foreground border-input dark:bg-input/30 w-full flex-1 resize-none rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs outline-none transition-[color,box-shadow] focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50" />
            <InputError v-if="form.errors.description" :message="form.errors.description" />
          </div>
        </div>
      </div>

      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-start-3 lg:row-start-1">
        <h2 class="mb-4 text-sm font-medium text-foreground">Thumbnail</h2>
        <div class="flex flex-1 flex-col justify-center gap-y-3">
          <div v-if="product.thumbnail_url" class="relative flex-1 overflow-hidden rounded-xl bg-muted/60 dark:bg-muted/30"
            style="min-height: 12rem;">
            <img :src="product.thumbnail_url ?? 'dd'" :alt="product.name"
              class="h-full w-full object-cover" />
            </div>
            <p v-else>No image Uploaded</p>

          <Label for="product-thumbnail" class="w-full text-primary-foreground bg-primary py-3 text-center font-bold rounded-md flex justify-center cursor-pointer hover:bg-primary/90 transition-colors duration-200">
            Upload Image
          </Label>
          <Input type="file" id="product-thumbnail" hidden @input="form.thumbnail = $event.target.files[0]" />
          <InputError v-if="form.errors.thumbnail" :message="form.errors.thumbnail" />
        </div>
      </div>

      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-span-2 lg:row-start-2">
        <h2 class="mb-5 text-sm font-medium text-foreground">Pricing & Inventory</h2>

        <div class="grid grid-cols-2 gap-x-4 gap-y-5">
          <div class="flex flex-col gap-y-1.5">
            <NumberField id="product-price" v-model="form.price" :step="0.01" :min="0" :format-options="{
              style: 'currency',
              currency: 'USD',
              currencyDisplay: 'code',
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            }">
              <Label for="product-price">Price</Label>
              <NumberFieldContent>
                <NumberFieldDecrement />
                <NumberFieldInput />
                <NumberFieldIncrement />
              </NumberFieldContent>
              <InputError v-if="form.errors.price" :message="form.errors.price" />
            </NumberField>
          </div>

          <div class="flex flex-col gap-y-1.5">
            <NumberField id="product-stock" v-model="form.stock" :min="0">
              <Label for="product-stock">Stock</Label>
              <NumberFieldContent>
                <NumberFieldDecrement />
                <NumberFieldInput />
                <NumberFieldIncrement />
              </NumberFieldContent>
              <InputError v-if="form.errors.stock" :message="form.errors.stock" />
            </NumberField>
          </div>
        </div>
      </div>

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
  </form>
</template>
