<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import YouTube from 'vue3-youtube';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const youtubeRef = ref<InstanceType<typeof YouTube> | null>(null);

const onReady = () => {
    youtubeRef.value?.playVideo();
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Training" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Training" description="Update your account's appearance settings" />
                
                <YouTube ref="youtubeRef" src="https://www.youtube.com/watch?v=n16MfPu3U28" @ready="onReady"></YouTube>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
