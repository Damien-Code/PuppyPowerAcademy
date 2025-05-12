<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem, type OrderProducts, type Order, type Product } from '@/types';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useDateFormat } from '@vueuse/core';

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
                <HeadingSmall title="Bestelgeschiedenis" description="Bekijk hier uw gemaakte bestelling" />

                <Table class="min-w-full">
                    <TableHeader>
                        <TableHead>Order id</TableHead>
                        <TableHead>Order datum</TableHead>
                        <TableHead>Product</TableHead>
                        <TableHead>Beschrijving</TableHead>
                        <TableHead>Hoeveelheid</TableHead>
                        <TableHead>Totale prijs</TableHead>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="order_product in order_products" :key="order_product.order.id">
                            <TableCell>{{ order_product.order.user_id }}</TableCell>
                            <TableCell>{{ useDateFormat(order_product.order.created_at, 'YYYY-MM-DD') }}</TableCell>
                            <TableCell>{{ order_product.product.name }}</TableCell>
                            <TableCell class="max-w-sm overflow-scroll">{{ order_product.product.description }}</TableCell>
                            <TableCell>{{ order_product.amount }}</TableCell>
                            <TableCell>{{ order_product.amount * order_product.product.price}}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <div v-if="order_products.length == 0">
                    <HeadingSmall title="Geen aankopen om te weergeven" />
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
