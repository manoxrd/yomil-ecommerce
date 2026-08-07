<script setup lang='ts'>
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import CardHeading from '@/components/admin/CardHeading.vue';
import PageHeading from '@/components/admin/PageHeading.vue';
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
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import Separator from '@/components/ui/separator/Separator.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import { store } from '@/routes/admin/products';
import type { Category } from '@/types';

defineProps<{
  categories: Category[]
}>();

const form = useForm({
  name: undefined,
  description: null,
  price: 1,
  stock: 1,
  thumbnail: null,
  category_id: null,
})

const submit = () => {
  form.post(store.url(), {
    onSuccess: () => {
      toast.success('Your Product has been created');
    }
  });
}

</script>

<template>

  <Head title="Create Product" />

  <form @submit.prevent="submit" class="max-w-6xl px-6 py-8" enctype="multipart/form-data">

    <PageHeading title="Create Product">
      <div class="flex items-center gap-x-3">
        <Button type="button" variant="outline">Discard</Button>
        <Button type="submit" :disabled="form.processing">
          <Spinner v-if="form.processing" />
          Create
        </Button>
      </div>
    </PageHeading>


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
        <CardHeading>Product Information</CardHeading>

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
        <CardHeading>Product Thumbnail</CardHeading>
        <div class="flex flex-1 flex-col justify-center">
          <div class="relative flex-1 overflow-hidden rounded-xl bg-muted/60 dark:bg-muted/30"
            style="min-height: 12rem;">
          </div>
          <Label for="product-thumbnail"
            class="w-full text-primary-foreground bg-primary py-3 text-center font-bold rounded-md flex justify-center cursor-pointer hover:bg-primary/90 transition-colors duration-200 mt-4">
            Upload
          </Label>
          <Input type="file" id="product-thumbnail" hidden @input="form.thumbnail = $event.target.files[0]" />
          <InputError v-if="form.errors.thumbnail" :message="form.errors.thumbnail" />
        </div>
      </div>

      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-start-3 lg:row-start-2">
        <CardHeading>Category</CardHeading>

        <Select v-model="form.category_id">
          <SelectTrigger class="w-full">
            <SelectValue placeholder="Select Category" />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
                      <InputError v-if="form.errors.category_id" :message="form.errors.category_id" />
      </div>

      <div class="flex flex-col rounded-xl border border-border bg-card p-6 shadow-xs lg:col-span-2 lg:row-start-2">
        <CardHeading>Pricing & Inventory</CardHeading>

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

    </div>
  </form>

</template>