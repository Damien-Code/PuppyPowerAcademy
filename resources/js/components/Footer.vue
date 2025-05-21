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
            <a :href="item.href" rel="noopener noreferrer" class="hover:underline decoration-green-300">{{ item.title }}</a>
        </div>
    </div>
</template>
