<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Footer from '@/components/Footer.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'About',
        href: '/about',
    },
];
</script>

<template>
    <Head title="About" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative max-h-56 flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min p-8">
                <PlaceholderPattern/>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min p-8">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut beatae dignissimos eaque et minus numquam obcaecati odit, placeat quaerat ratione saepe voluptas voluptate. Ab corporis incidunt iusto nesciunt pariatur, tenetur.</p>
            </div>
        </div>
        <Footer/>
    </AppLayout>
</template>
