<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Footer from '@/components/Footer.vue';
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/home',
    },
];
</script>

<template>
    <Head title="Home" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
<!--            <div class="relative h-32 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min p-4">-->
<!--                <h2 class="text-4xl font-semibold tracking-tight">Puppy Power Academy</h2>-->
<!--                <p class="text-muted-foreground">-->
<!--                    Tekst-->
<!--                </p>-->
<!--            </div>-->
<!--            <div class=" relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">-->
<!--                <img src="../../../public/images/DogHome.png" alt="Homepage" />-->
<!--            </div>-->
            <section class="bg-white dark:bg-gray-900 rounded-2xl">
                <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-16 lg:px-6">
                    <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Puppy Power Academy</h2>
                        <p class="mb-4">We are strategists, designers and developers. Innovators and problem solvers. Small enough to be simple and quick, but big enough to deliver the scope you want at the pace you need. Small enough to be simple and quick, but big enough to deliver the scope you want at the pace you need.</p>
                        <p>We are strategists, designers and developers. Innovators and problem solvers. Small enough to be simple and quick.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <img class="w-full rounded-lg " src="../../../public/images/DogHome.png" alt="dog">
                        <img class="mt-4 w-full lg:mt-10 rounded-lg" src="../../../public/images/DogHome2.png" alt="dog">
                    </div>
                </div>
            </section>

        </div>
        <Footer/>
    </AppLayout>
</template>
