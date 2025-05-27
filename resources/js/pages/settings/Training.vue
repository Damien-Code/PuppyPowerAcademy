<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Training, TrainingCategory, type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { ref } from 'vue';
import YouTube from 'vue3-youtube';
import Heading from '@/components/Heading.vue';

const youtubeRef = ref<InstanceType<typeof YouTube> | null>(null);

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Training',
        href: '/settings/training',
    },
];

const handleVideoPlay = (training: Training) => {
    router.post(route('trainings.markWatched', training.id), {}, {
        preserveScroll: true,
    })
}

interface Props {
    trainings: Training[];
    trainingCategories: TrainingCategory[];
}

defineProps<Props>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Training" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Training" description="Bekijk hier uw bestelde trainingen" />
                <div v-for="category in trainingCategories" :key="category.id" class="bg-primary rounded-lg p-8">
                    <Heading :title="category.name"/>
                    <div v-if="category.trainings.length != 0">
                        <div v-for="training in category.trainings" :key="training.id" class="flex my-4 bg-white rounded-lg">
                            <div class="w-1/2 flex flex-col p-4">
                                <Heading :title="training.title" :description="training.description"/>
                            </div>
                            <div class="w-1/2 flex flex-col">
                                <div class="my-4 mx-auto h-fit w-fit">
                                    <YouTube 
                                        :height="216" 
                                        :width="384"  
                                        :src="training.link" 
                                        :vars="{ autoplay: 0 }"
                                        @play="handleVideoPlay(training)"  
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
