<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="mx-auto max-w-screen-xl px-4 py-8 text-center lg:px-12 lg:py-16">
                <h1 class="mb-4 text-4xl leading-none font-extrabold tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Dagopvang
                </h1>
                <p class="mb-8 text-lg font-normal text-gray-500 sm:px-16 lg:text-xl xl:px-48 dark:text-gray-400">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad culpa est fugit libero modi, quibusdam veniam vitae voluptates.
                    Asperiores consequuntur deleniti eaque est ex hic ipsa neque, quae quia vel.
                </p>
                <div class="mb-8 flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4 lg:mb-16">
                    <Button>Plan afspraak</Button>
                </div>
            </div>
        </div>
        <Footer />
    </AppLayout>
</template>
