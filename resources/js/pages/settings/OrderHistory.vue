<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogDescription, DialogHeader, DialogScrollContent, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type Order } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useDateFormat } from '@vueuse/core';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Bestelgeschiedenis',
        href: '/settings/order-history',
    },
];

// Define props for the component
// Created an Order interface instead of using any
// Better typing for the props
interface Props {
    orders: Order[];
}

defineProps<Props>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Bestelgeschiedenis" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Bestelgeschiedenis" description="Bekijk hier uw gemaakte bestelling" />
                <Table class="min-w-full" v-if="orders.length != 0">
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
                            <TableCell
                                >{{
                                    (order.totalPrice * 1.18 + 4.95).toLocaleString('nl-NL', {
                                        currency: 'EUR',
                                        style: 'currency',
                                    })
                                }}
                            </TableCell>
                            <TableCell>
                                <!--                                Modal to open on a specific order-->
                                <Dialog>
                                    <DialogTrigger as-child>
                                        <Button> Details</Button>
                                    </DialogTrigger>
                                    <DialogScrollContent class="sm:max-w-[425px]">
                                        <DialogHeader>
                                            <DialogTitle>Bestelde product</DialogTitle>
                                            <DialogDescription> Bekijk hier uw bestelde product</DialogDescription>
                                        </DialogHeader>
                                        <div>
                                            <div>
                                                <HeadingSmall title="Order ID" :description="order.id.toString()" />
                                            </div>
                                            <!--                                            Display if there are orders-->
                                            <div v-if="order.order_products.length != 0 || order.category_order.length != 0">
                                                <div v-for="orderProducts in order.order_products" :key="orderProducts.product.id" class="pt-8">
                                                    <div class="pb-2">
                                                        <HeadingSmall title="Product" :description="orderProducts.product.name" />
                                                    </div>
                                                    <div class="pb-2">
                                                        <HeadingSmall title="Beschrijving" :description="orderProducts.product.description" />
                                                    </div>
                                                    <div class="pb-2">
                                                        <HeadingSmall title="Hoeveelheid" :description="orderProducts.amount.toString()" />
                                                    </div>
                                                    <div class="pb-8">
                                                        <HeadingSmall
                                                            title="Artikel prijs"
                                                            :description="
                                                                orderProducts.product.price.toLocaleString('nl-NL', {
                                                                    currency: 'EUR',
                                                                    style: 'currency',
                                                                })
                                                            "
                                                        />
                                                    </div>
                                                    <hr />
                                                </div>
                                                <hr />
                                                <div v-for="orderCategory in order.category_order" :key="orderCategory.id" class="pt-8">
                                                    <div class="pb-2">
                                                        <HeadingSmall title="Training" :description="orderCategory.trainingcategory.name" />
                                                    </div>
                                                    <div class="pb-2">
                                                        <HeadingSmall title="Hoeveelheid" :description="orderCategory.trainingcategory.price.toLocaleString('nl-NL', {
                                                                    currency: 'EUR',
                                                                    style: 'currency',
                                                                })" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--                                            Display if there are orders without any products-->
                                            <div v-else>
                                                <HeadingSmall title="Geen artikelen gevonden" description="Deze order heeft geen artikelen" />
                                            </div>
                                        </div>
                                    </DialogScrollContent>
                                </Dialog>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <!--                Display if there aren't any orders made-->
                <div v-else>
                    <HeadingSmall title="Geen aankopen om te weergeven" />
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
