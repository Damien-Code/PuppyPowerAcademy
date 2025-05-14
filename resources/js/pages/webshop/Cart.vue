<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Product, Training, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import Footer from '@/components/Footer.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cart',
        href: '/webshop/cart',
    },
];
interface Props {
    products: Product[]
    trainings: Training[]

}
const props = defineProps<Props>();
console.log(props.products);

</script>

<template>
    <Head title="Cart" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <p>Cart</p>
                    <div v-for="product in props.products" :key="product.id">
                        {{ product.name }}
                        <br>
                    </div>
                    <div v-for="training in props.trainings" :key="training.id">
                        <b>
                            {{ training.title }}
                        </b>
                        <br>

                    </div>
                </div>  
            </div>
        </div>
        <Footer/>
    </AppLayout>
</template>
