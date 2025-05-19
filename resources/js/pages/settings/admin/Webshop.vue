<script setup lang="ts" xmlns="http://www.w3.org/1999/html">
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
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
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Admin webshop',
        href: '/admin/webshop',
    },
];

interface Props {
    products: Product[];
}

defineProps<Props>();

// modal value references
// Selected row is data
// modalOpen is the visibility of the modal
const selectedRow = ref<Product>(null!);
const modalOpen = ref(false);

//Closes the dialog/modal
const openModal = (product: Product) => {
    selectedRow.value = product;
    modalOpen.value = true;
}

const form = useForm({
    name: '',
    description: '',
    price: '',
    stock: '',
    media: '',
});

/**
 * @author Damien-Code
 * Gets the file from the input type file from form
 * Gets the first file that is selected by user from the files list
 * return if there is no file selected
 * Store file in form.media
 */
const fileSelected = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (!file) {
        return;
    }
    form.media = file;
};

/**
 * @author Damien-Code
 * submit function to the route of store
 */
const submit = () => {
    form.post(route('admin.webshop.store'), {
        // Forces the data to submit, so that files are saved correctly
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Product toegevoegd');
        },
        onError: () => {
            toast.error('Er is iets misgegaan');
        },
    });
};

/**
 * @author Damien-Code
 * Post the individual product to update route
 * Needed to add media after formData because it could not be added to formData
 */
const update = (productId: any, formData: any) => {
    router.post(
        route('admin.webshop.update', productId),
        {
            ...formData,
            media: form.data().media,
            _method: 'PATCH',
        },
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                modalOpen.value = false;
                toast.success('Product gewijzigd');
            },
            onError: () => {
                toast.error('Er is iets misgegaan');
            },
        },
    );
};

/**
 * @author Damien-Code
 * Delete function with route to destroy
 */
const deleteProduct = (id: number) => {
    router.delete(route('admin.webshop.destroy', { id }), {
        onSuccess: () => {
            toast.success('Product verwijderd');
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Webshop" />

        <SettingsLayout>
            <Toaster />
            <div class="space-y-6">
                <HeadingSmall title="Admin Webshop" description="Update uw webshop of webshop items" />
                <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                    <div class="px-4 2xl:px-0">
                        <div class="mb-4 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                                <form class="space-y-3" @submit.prevent="submit">
                                    <Label>Productnaam</Label>
                                    <Input type="text" placeholder="Productnaam" v-model="form.name" />
                                    <InputError :message="form.errors.name" />
                                    <Label>Product beschrijving</Label>
                                    <Input type="text" placeholder="Product beschrijving" v-model="form.description" />
                                    <InputError :message="form.errors.description" />
                                    <Label>Prijs</Label>
                                    <Input type="number" placeholder="&euro;1" v-model="form.price" />
                                    <InputError :message="form.errors.price" />
                                    <Label>Afbeelding</Label>
                                    <Input type="file" v-on:change="fileSelected($event)" />
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">{form.progress.percentage}%</progress>
                                    <InputError :message="form.errors.media" />
                                    <Label>Voorraad</Label>
                                    <Input type="number" v-model="form.stock" />
                                    <InputError :message="form.errors.stock" />
                                    <Button class="mt-4" type="submit">Toevoegen</Button>
                                </form>
                            </div>
                            <div
                                v-for="product in products"
                                :key="product.id"
                                class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800"
                            >
                                <div class="h-56 w-full">
                                    <a v-if="product.mediaFile" :href="product.mediaFile.original_url" target="_blank">
                                        <img :src="product.mediaFile.original_url" class="mx-auto max-h-full" />
                                    </a>
                                </div>

                                <div class="pt-6">
                                    <p class="text-lg leading-tight font-semibold text-gray-900 hover:underline dark:text-white">
                                        {{ product.name }}
                                    </p>

                                    <ul class="mt-2 flex items-center gap-4">
                                        <li class="flex items-center gap-2">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Voorraad: {{ product.stock }}</p>
                                        </li>

                                        <li class="flex items-center gap-2">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Product ID: {{ product.id }}</p>
                                        </li>
                                    </ul>

                                    <div class="mt-4 flex items-center justify-between gap-4">
                                        <p class="text-2xl leading-tight font-extrabold text-gray-900 dark:text-white">&euro;{{ product.price }}</p>
                                        <div>
                                            <Button @click="openModal(product)">Bewerk</Button>
                                        </div>
                                        <div>
                                            <Button :variant="'destructive'" @click="deleteProduct(product.id)">Delete </Button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <Dialog v-model:open="modalOpen">
                                <DialogContent class="sm:max-w-[425px]">
                                    <DialogHeader>
                                        <DialogTitle>Bewerk product</DialogTitle>
                                        <DialogDescription>
                                            Bewerk hier het gekozen product. Druk op opslaan wanneer je klaar bent.
                                        </DialogDescription>
                                    </DialogHeader>
                                    <form @submit.prevent="update(selectedRow.id, selectedRow)" :id="selectedRow.id">
                                        <div class="grid gap-4 py-4">
                                            <div class="grid grid-cols-4 items-center gap-4">
                                                <Label for="name" class="text-right"> Naam </Label>
                                                <Input class="col-span-3" v-model="selectedRow.name" />
                                            </div>
                                            <div class="grid grid-cols-4 items-center gap-4">
                                                <Label for="username" class="text-right"> Beschrijving </Label>
                                                <textarea class="col-span-3" v-model="selectedRow.description" />
                                            </div>
                                            <div class="grid grid-cols-4 items-center gap-4">
                                                <Label for="name" class="text-right"> Prijs </Label>
                                                <Input class="col-span-3" v-model="selectedRow.price" type="number" />
                                            </div>
                                            <div class="grid grid-cols-4 items-center gap-4">
                                                <Label for="media" class="text-right"> Afbeelding </Label>
                                                <Input type="file" v-on:change="fileSelected($event)" class="col-span-3" />
                                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                                    {form.progress.percentage}%
                                                </progress>
                                            </div>
                                            <div class="grid grid-cols-4 items-center gap-4">
                                                <Label for="name" class="text-right"> Voorraad </Label>
                                                <Input class="col-span-3" v-model="selectedRow.stock" type="number" />
                                            </div>
                                        </div>
                                        <DialogFooter>
                                                <Button type="submit"> Save changes </Button>
                                        </DialogFooter>
                                    </form>
                                </DialogContent>
                            </Dialog>
                        </div>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
