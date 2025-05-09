<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';
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
    order_products: any;
}

const props = defineProps<Props>();
const orders = props.order_products;
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Bestelgeschiedenis" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Bestelgeschiedenis" description="Update your account's appearance settings" />
                <div v-for="order in order_products" :key="order">
                    <p>Product name: {{ order.product.name }}</p>
<!--                    <p>{{ order.product.description }}</p>-->
<!--                    <p>{{ order.product.price }}</p>-->
<!--                    <p> {{ order.amount }} </p>-->
                    <p>Order id: {{order.order_id}}</p>
                    <p>Order by: {{ order.order.user_id}}</p>
                    <p>Total Price: {{ order.amount * order.product.price}}</p>
                    <p>{{ orders}}</p>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
