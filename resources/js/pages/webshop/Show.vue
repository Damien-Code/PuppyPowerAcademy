<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Product} from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import {
  NumberField,
  NumberFieldContent,
  NumberFieldDecrement,
  NumberFieldIncrement,
  NumberFieldInput,
} from '@/components/ui/number-field/index';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Webshop',
        href: '/webshop',
    },
];

interface Props {
    product: Product
}

const props = defineProps<Props>();
const product = props.product;

const form = useForm({
    product_id: 0,
    amount:1,
});

const submit = () => {
    form.product_id = product.id;
    form.amount = form.amount;
    form.post(route('webshop.store'), {
        onSuccess: () => {
            form.reset();
            toast.success('Succesvol toegevoegd!');
        },
        onError: () => {
            toast.error('Er is iets misgegaan');
        },
    })
}

</script>

<template>
    <Head :title=" product.name " />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
                    <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                        <div v-if="product.mediaFile" class="mb-4 h-72 w-full mt-12 p-6 bg-white rounded-lg">
                            <a :href="product.mediaFile.original_url" target="_blank">
                                <img :src="product.mediaFile.original_url" class="mx-auto h-full"  alt=""/>
                            </a>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 lg:mt-0">
                        <h1
                            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
                        >
                            {{ product.name }}
                        </h1>
                        <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                            <p
                                class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white"
                            >
                                €{{ product.price }}
                            </p>

                        </div>

                        <form @submit.prevent="submit" >

                        <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                            <p
                                class="text-l font-extrabold text-gray-900 sm:text-l dark:text-white"
                            >
                                <NumberField id="Aantal" :default-value="1" :min="1" :max="product.stock" v-model="form.amount">
                                  <Label for="Aantal">Aantal</Label>
                                  <NumberFieldContent>
                                    <NumberFieldDecrement />
                                    <NumberFieldInput />
                                    <NumberFieldIncrement />
                                  </NumberFieldContent>
                                </NumberField>
                            </p>

                       </div>

                           <Button class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8 cursor-pointer"
                           >
                           <input type="hidden" name="product_id" value="{{product.id }}" v-model="form.product_id">
                                <!-- <Input/> -->
                               <svg
                               class="w-5 h-5 -ms-2 me-2"
                               aria-hidden="true"
                               xmlns="http://www.w3.org/2000/svg"
                               width="24"
                               height="24"
                               fill="none"
                               viewBox="0 0 24 24"
                               >
                               <path
                               stroke="currentColor"
                               stroke-linecap="round"
                               stroke-linejoin="round"
                               stroke-width="2"
                               d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6"
                               />
                            </svg>

                            Add to cart
                    </Button>
                        </form>
                        <!-- </div> -->

                        <hr class="my-6 md:my-8 border-input" />

                        <p class="mb-6 text-gray-500 dark:text-gray-400">
                         {{ product.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </AppLayout>
</template>

<Footer />
