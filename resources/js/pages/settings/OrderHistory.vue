<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogDescription, DialogHeader, DialogScrollContent, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type Order, type OrderProducts, type Product } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useDateFormat } from '@vueuse/core';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Bestelgeschiedenis',
        href: '/settings/order-history',
    },
];

interface Props {
    order_products: OrderProducts[];
    orders: Order[];
    products: Product;
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
                        <TableHead>Order prijs</TableHead>
                        <TableHead>Bekijk order</TableHead>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="order in orders" :key="order.id">
                            <TableCell>{{ order.id }}</TableCell>
                            <TableCell>{{ useDateFormat(order.created_at, 'YYYY-MM-DD') }}</TableCell>
                            <!--                            <TableCell>{{ orde * order_product.product.price }}</TableCell>-->
                            <TableCell>{{ order.totalPrice }}</TableCell>
                            <TableCell>Prijs</TableCell>
                            <TableCell>
                                <Dialog>
                                    <DialogTrigger as-child>
                                        <Button> Details</Button>
                                    </DialogTrigger>
                                    <DialogScrollContent class="sm:max-w-[425px]">
                                        <DialogHeader>
                                            <DialogTitle>Bestelde product</DialogTitle>
                                            <DialogDescription> Bekijk hier uw bestelde product</DialogDescription>
                                        </DialogHeader>
                                        <div class="py-4">
                                            <div class="pb-8">
                                                <HeadingSmall title="Order ID" :description="order.id.toString()" />
                                            </div>
                                            <div class="grid items-center gap-8" v-for="product in order_products" :key="product.product.id">
                                                <div>
                                                    <HeadingSmall title="Product" :description="product.product.name" />
                                                </div>
                                                <div>
                                                    <HeadingSmall title="Beschrijving" :description="product.product.description" />
                                                </div>
                                                <div>
                                                    <HeadingSmall title="Hoeveelheid" :description="product.amount.toString()" />
                                                </div>
                                                <div>
                                                    <HeadingSmall title="Artikel prijs" :description="product.product.price.toString()" />
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    </DialogScrollContent>
                                </Dialog>
                            </TableCell>
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
