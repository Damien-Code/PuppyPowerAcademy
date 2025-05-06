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
            <a :href="item.href" target="_blank" rel="noopener noreferrer">{{ item.title }}</a>
        </div>
    </div>
</template>
