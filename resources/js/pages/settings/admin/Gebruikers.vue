<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

import { BreadcrumbItem, User } from '@/types';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Switch } from '@/components/ui/switch'

import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { useDateFormat } from '@vueuse/core';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Admin panel',
        href: '/settings/admin',
    },
];

interface Props {
    users: User[]
}

defineProps<Props>();

const submitForm = (user: User) => {
    router.post(
        route('admin.gebruikers.update', user.id),
        {
            'role_id': user.role_id === 1 ? 2 : 1, // Toggle between 1 and 2
            _method: 'PATCH',
        }
    )
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Panel"/>

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Gebruikers" description="Beheer gebruikers en hun rollen"/>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left w-1/12">Admin</TableHead>
                            <TableHead>Naam</TableHead>
                            <TableHead>E-Mail</TableHead>
                            <TableHead>Geverifieërd</TableHead>
                            <TableHead>Gecreeërd op</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="user in users" :key="user.id">
                            <TableCell class="flex">
                                <Switch
                                    class="mr-auto"
                                    :model-value="user.role_id === 1"
                                    @update:modelValue="submitForm(user)"
                                    :disabled="$page.props.auth.user.id === user.id"
                                />
                            </TableCell>
                            <TableCell>{{ user.name }}</TableCell>
                            <TableCell>{{ user.email }}</TableCell>
                            <TableCell class="flex justify-center">{{ user.email_verified_at ? "Ja" : "Nee" }}</TableCell>
                            <TableCell>{{ useDateFormat(user.created_at, 'DD-MM-YYYY') }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
