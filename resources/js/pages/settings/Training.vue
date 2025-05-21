<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Training',
        href: '/settings/training',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Training" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Training" description="Bekijk hier uw bestelde trainingen" />

            </div>
        </SettingsLayout>
    </AppLayout>
</template>
