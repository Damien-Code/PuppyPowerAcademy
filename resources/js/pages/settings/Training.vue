<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

import { Progress } from '@/components/ui/progress'
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Training, TrainingCategory, type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import YouTube from 'vue3-youtube';
import Heading from '@/components/Heading.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Training',
        href: '/settings/training',
    },
];

interface PlayerStateChangeEvent {
  data: number;
  target: any;
}

const handleVideoPlayStateChange = (training: Training, event: PlayerStateChangeEvent) => {
    // YT.PlayerState.PLAYING is 1
    // YT.PlayerState.ENDED is 0
    // etc.
    if (event.data === 1) {
        console.log('Video PLAYING for training:', training.id);
        router.post(route('trainings.markWatched', training.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                console.log(`Training ${training.id} marked as watched successfully.`);
            },
            onError: (errors) => {
                console.error('Failed to mark training as watched:', errors);
            },
        });
    }
};

interface Props {
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
                <div v-for="category in trainingCategories" :key="category.id">
                    <div v-if="category.trainings && category.trainings.length > 0" class="bg-primary rounded-lg p-8">
                        <Heading :title="category.name"/>
                        <Progress v-model="category.progress_percentage" class="w-2/5 bg-white"/>
                        
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
                                        :vars="{ autoplay: 0, modestbranding: 1, rel: 0 }"
                                        @state-change="handleVideoPlayStateChange(training, $event)"
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
