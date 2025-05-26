<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Training, type BreadcrumbItem } from '@/types';

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

interface Props {
    trainings: Training[]
}

defineProps<Props>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Training" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Training" description="Bekijk hier uw bestelde trainingen" />
                <div v-for="training in trainings" :key="training.id" class="flex my-4 bg-white rounded-lg">
                    <div class="w-1/2 flex flex-col p-4">
                        <Heading :title="training.title" :description="training.description"/>
                    </div>
                    <div class="w-1/2 flex flex-col">
                        <div class="my-4 mx-auto h-fit w-fit">
                            <YouTube :height="216" :width="384" ref="youtubeRef" :src="training.link" :vars="{ autoplay: 0 }" @ready="onReady"></YouTube>
                        </div>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
