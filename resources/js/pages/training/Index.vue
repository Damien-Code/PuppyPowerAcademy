<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { TrainingCategory, type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import Footer from '@/components/Footer.vue';
import { Head, useForm } from '@inertiajs/vue3';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Training.vue',
        href: '/training',
    },
];

interface Props {
    trainingCategories: TrainingCategory[]
}

defineProps<Props>();

const form = useForm({
    category_id: 0,
});

const submitTraining = (categoryId:number) => {
    form.category_id = categoryId;
    form.post(route('training.store'))
}

</script>

<template>
    <Head title="Training" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Trainingen</h2>
                    <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">Kies je training die het best past bij uw hond.</p>
                </div>
                <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                    <!-- Pricing Card -->
                    <div v-for="category in trainingCategories" :key="category.id" class="flex flex-col w-full p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow xl:p-8">
                        <form @submit.prevent="submitTraining(category.id)">
                            <h3 class="mb-4 text-2xl font-semibold">{{ category.name }}</h3>
                            <p class="font-light text-gray-500 sm:text-lg"> {{ category.name }} training ...</p>
                            <div class="flex justify-center items-baseline my-8">
                                <span class="mr-2 text-5xl font-extrabold">&euro; {{ category.price }}</span>
                            </div>
                            <!-- List -->
                            <ul role="list" class="mb-8 space-y-4 text-left">
                                <li v-for="descriptor in JSON.parse(category.descriptors)" :key="descriptor.id" class="flex items-center space-x-3">
                                    <!-- Icon -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span>{{ descriptor }}</span>
                                </li>
                            </ul>
                            <Button type="submit" class="cursor-pointer">Toevoegen aan winkelwagen</Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <Footer/>
    </AppLayout>
</template>
