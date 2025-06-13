<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

import Button from '@/components/ui/button/Button.vue';
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
    if (event.data === 1) {
        router.post(route('settings.training.markWatched', training.id), {}, {
            preserveScroll: true,
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

                <div v-if="trainingCategories && trainingCategories.length > 0">
                    <div v-for="category in trainingCategories" :key="category.id" class="bg-primary rounded-lg p-8 mb-6">
                        <Heading :title="category.name"/>
                        <div v-if="category.trainings && category.trainings.length > 0">
                            <Progress v-model="category.progress_percentage" class="w-2/5 -mt-4 bg-white"/>
                            <div v-for="training in category.trainings" :key="training.id" class="bg-background my-4 flex flex-col rounded-lg justify-between">
                                <div class="p-4">
                                    <div class="flex flex-col justify-between md:flex-row">
                                        <Heading :title="training.title" :description="training.description" />
                                    </div>
                                    <div class="invisible md:visible">
                                        <YouTube
                                            class="hidden md:inline"
                                            :key="`youtube-${training.id}`"
                                            :height="216"
                                            :width="384"
                                            :src="training.link"
                                            :vars="{ autoplay: 0 }"
                                            @state-change="handleVideoPlayStateChange(training, $event)"
                                        ></YouTube>
                                    </div>
                                    <a class="visible hover:underline md:invisible" :href="training.link">
                                        <Button variant="outline"
                                        >Bekijk training video
                                            <svg
                                                viewBox="0 0 256 180"
                                                width="256"
                                                height="180"
                                                xmlns="http://www.w3.org/2000/svg"
                                                preserveAspectRatio="xMidYMid"
                                            >
                                                <path
                                                    d="M250.346 28.075A32.18 32.18 0 0 0 227.69 5.418C207.824 0 127.87 0 127.87 0S47.912.164 28.046 5.582A32.18 32.18 0 0 0 5.39 28.24c-6.009 35.298-8.34 89.084.165 122.97a32.18 32.18 0 0 0 22.656 22.657c19.866 5.418 99.822 5.418 99.822 5.418s79.955 0 99.82-5.418a32.18 32.18 0 0 0 22.657-22.657c6.338-35.348 8.291-89.1-.164-123.134Z"
                                                    fill="red"
                                                />
                                                <path fill="#FFF" d="m102.421 128.06 66.328-38.418-66.328-38.418z" />
                                            </svg>
                                        </Button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p>Video's worden zo snel mogelijk toegevoegd aan dit trainings pakket.</p>
                        </div>
                    </div>
                </div>
                <div v-else class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-yellow-800">Geen training aangeschaft</h3>
                            <p class="text-yellow-700 mt-1">
                                Om trainingen te bekijken moet u deze eerst aanschaffen.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
