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
                        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dog-icon lucide-dog"><path d="M11.25 16.25h1.5L12 17z"/><path d="M16 14v.5"/><path d="M4.42 11.247A13.152 13.152 0 0 0 4 14.556C4 18.728 7.582 21 12 21s8-2.272 8-6.444a11.702 11.702 0 0 0-.493-3.309"/><path d="M8 14v.5"/><path d="M8.5 8.5c-.384 1.05-1.083 2.028-2.344 2.5-1.931.722-3.576-.297-3.656-1-.113-.994 1.177-6.53 4-7 1.923-.321 3.651.845 3.651 2.235A7.497 7.497 0 0 1 14 5.277c0-1.39 1.844-2.598 3.767-2.277 2.823.47 4.113 6.006 4 7-.08.703-1.725 1.722-3.656 1-1.261-.472-1.855-1.45-2.239-2.5"/></svg>

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
                        <!-- <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8"> -->

                           <Button class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8 cursor-pointer"
                           >
                           <input type="hidden" name="product_id" value="{{product.id }}" v-model="form.product_id">
                                <!-- <Input/> -->
                                <a
                                class="mt-4 sm:mt-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center"
                               role="button"
                               >
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
                        </a>
                    </Button>
                        </form>
                        <!-- </div> -->

                        <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

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
