<script setup lang="ts" xmlns="http://www.w3.org/1999/html">
import { Head, router, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem, type Product } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { toast, Toaster } from 'vue-sonner';
import InputError from '@/components/InputError.vue';
import {
    Dialog, DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Admin webshop',
        href: '/admin/webshop'
    }
];



interface Props {
    products: Product[];
}

const props = defineProps<Props>();
const productForms = reactive({});
props.products.forEach(product => {
    productForms[product.id] = {
        name: product.name,
        description: product.description,
        price: product.price,
        stock: product.stock,
    }
})
// const editProduct = props.products.forEach(product => {
//     name: product.name,
// });

const form = useForm({
    name: '',
    description: '',
    price: '',
    stock: ''
});

const submit = () => {
    form.post(route('admin.webshop.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Product toegevoegd');
        },
        onError: () => {
            toast.error('Er is iets misgegaan');
        }
    });
};

const update = (productId: any, formData: any) => {
    router.post(route('admin.webshop.update', productId),{
        ...formData,
        _method: 'PATCH',
    },{
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Product gewijzigd');
        },
        onError: () => {
            toast.error('Er is iets misgegaan');
        }
    })
}


</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Webshop" />

        <SettingsLayout>
            <Toaster/>
            <div class="space-y-6">
                <HeadingSmall title="Admin Webshop" description="Update uw webshop of webshop items" />
                <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                    <div class=" px-4 2xl:px-0">
                        <div class="mb-4 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                                <form class="space-y-3" @submit.prevent="submit">
                                    <Label>Productnaam</Label>
                                    <Input type="text" placeholder="Productnaam" v-model="form.name"/>
                                    <InputError :message="form.errors.name"/>
                                    <Label>Product beschrijving</Label>
                                    <Input type="text" placeholder="Product beschrijving" v-model="form.description"/>
                                    <InputError :message="form.errors.description"/>
                                    <Label>Prijs</Label>
                                    <Input type="number" placeholder="&euro;1" v-model="form.price" />
                                    <InputError :message="form.errors.price"/>
<!--                                    <Label>Afbeelding</Label>-->
<!--                                    <Input type="file" />-->
                                    <Label>Voorraad</Label>
                                    <Input type="number" v-model="form.stock"/>
                                    <InputError :message="form.errors.stock"/>
                                    <Button class="mt-4" type="submit">Toevoegen</Button>
                                </form>
                            </div>
                            <div v-for="product in products" :key="product.id" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800" >
                                <div class="h-56 w-full">
                                        <img class="mx-auto h-full dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/iphone-light.svg" alt="" />
                                        <img class="mx-auto hidden h-full dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/iphone-dark.svg" alt="" />
                                </div>

                                <div class="pt-6">

                                    <p class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">{{ product.name}}</p>

                                    <ul class="mt-2 flex items-center gap-4">
                                        <li class="flex items-center gap-2">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Voorraad: {{product.stock}}</p>
                                        </li>

                                        <li class="flex items-center gap-2">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Product ID: {{product.id}}</p>
                                        </li>
                                    </ul>

                                    <div class="mt-4 flex items-center justify-between gap-4">
                                        <p class="text-2xl font-extrabold leading-tight text-gray-900 dark:text-white">&euro;{{product.price}}</p>
                                        <Dialog>
                                            <DialogTrigger as-child>
                                                <Button>
                                                    Bewerk
                                                </Button>
                                            </DialogTrigger>
                                            <DialogContent class="sm:max-w-[425px]">
                                                <DialogHeader>
                                                    <DialogTitle>Bewerk product</DialogTitle>
                                                    <DialogDescription>
                                                        Bewerk hier het gekozen product. Druk op opslaan wanneer je klaar bent.
                                                    </DialogDescription>
                                                </DialogHeader>
                                                <form @submit.prevent="update(product.id, productForms[product.id])">
                                                <div class="grid gap-4 py-4">
                                                    <div class="grid grid-cols-4 items-center gap-4">
                                                        <Label for="name" class="text-right">
                                                            Naam
                                                        </Label>
                                                        <Input class="col-span-3" v-model="productForms[product.id].name" />
                                                    </div>
                                                    <div class="grid grid-cols-4 items-center gap-4">
                                                        <Label for="username" class="text-right">
                                                            Beschrijving
                                                        </Label>
                                                        <textarea class="col-span-3" v-model="productForms[product.id].description"/>
                                                    </div>
                                                    <div class="grid grid-cols-4 items-center gap-4">
                                                        <Label for="name" class="text-right">
                                                            Prijs
                                                        </Label>
                                                        <Input class="col-span-3" v-model="productForms[product.id].price" type="number" />
                                                    </div>
                                                    <div class="grid grid-cols-4 items-center gap-4">
                                                        <Label for="name" class="text-right">
                                                            Voorraad
                                                        </Label>
                                                        <Input class="col-span-3" v-model="productForms[product.id].stock" type="number" />
                                                    </div>
                                                </div>
                                                <DialogFooter>
                                                    <DialogClose>
                                                    <Button type="submit">
                                                        Save changes
                                                    </Button>
                                                    </DialogClose>
                                                </DialogFooter>
                                                </form>
                                            </DialogContent>
                                        </Dialog>
                                    </div>
                                </div>
                            </div>
                           </div>
                    </div>

                </div>

            </div>
        </SettingsLayout>
    </AppLayout>
</template>
