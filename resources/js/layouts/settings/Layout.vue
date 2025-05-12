<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: '/settings/profile',
    },
    {
        title: 'Password',
        href: '/settings/password',
    },
    {
        title: 'Appearance',
        href: '/settings/appearance',
    },
    {
        title: 'Bestelgeschiedenis',
        href: '/settings/order-history',
    },
    {
        title: 'Admin',
        href: '/settings/admin/webshop',
    },
    {
        title: 'Webshop',
        href: '/settings/admin/webshop',
    },
    {
        title: 'Training',
        href: '/settings/admin/training',
    },
    {
        title: 'Dagopvang',
        href: '/settings/admin/dagopvang',
    },
    {
        title: 'Contact',
        href: '/settings/admin/contact',
    },
];

const page = usePage();

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="px-4 py-6">
        <Heading title="Settings" description="Manage your profile and account settings" />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-x-12 lg:space-y-0">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-x-0 space-y-1">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': currentPath === item.href }]"
                        as-child
                    >
                        <Link :href="item.href">
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 md:hidden" />

            <div class="flex-1 md:max-w-xl">
                <section :class="['max-w-xl space-y-12', { 'lg:min-w-4xl': currentPath === '/settings/order-history' || currentPath === '/settings/admin/webshop' || currentPath === '/settings/admin/training' || currentPath === '/settings/admin/dagopvang' || currentPath === '/settings/admin/contact' }]">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
