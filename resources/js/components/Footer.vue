<script setup lang="ts">
import { type FooterItem } from '@/types';

const items: FooterItem[] = [
    {
        title: 'Over ons',
        href: '/about',
    },
    {
        title: 'Contact',
        href: '/contact',
    },
];
</script>
<template>
    <div class="flex justify-evenly">
        <div v-for="item in items" :key="item.title" class="p-4">
            <a :href="item.href" rel="noopener noreferrer" class="hover:bg-accent flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium">{{ item.title }}</a>
        </div>
    </div>
</template>
