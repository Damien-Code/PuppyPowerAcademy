<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem, type OrderProducts, type Order, type Product } from '@/types';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Bestelgeschiedenis',
        href: '/settings/order-history',
    },
];

interface Props {
    order_products: OrderProducts[];
    orders: Order
    products: Product
}


defineProps<Props>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Bestelgeschiedenis" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Bestelgeschiedenis" description="Update your account's appearance settings" />
                <div v-for="order_product in order_products" :key="order_product.order.id">
                    <p>Order by: {{ order_product.order.user_id}}</p>
                    <p>Order id: {{ order_product.order.id }}</p>
                    <p>Product name: {{ order_product.product.name }}</p>
                    <p>Product description: {{ order_product.product.description }}</p>
                    <p>Total Price: {{ order_product.amount * order_product.product.price}}</p>
                    <p>Amount: {{ order_product.amount}}</p>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
