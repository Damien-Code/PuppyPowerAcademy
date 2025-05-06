<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Webshop',
        href: '/webshop',
    },
];
</script>

<template>
    <Head title="Dagopvang planning" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form class="mx-auto flex w-2/6 flex-col pt-12">
                <label>Naam van de hond</label>
                <Input />
                <label>Ras</label>
                <Input />
                <label>Email</label>
                <Input />
                <label>Datum</label>

                <Button>Plan</Button>
            </form>
        </div>
        <Footer />
    </AppLayout>
</template>

<Footer />
