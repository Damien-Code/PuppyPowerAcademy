<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Switch } from '@/components/ui/switch'

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Message, type BreadcrumbItem } from '@/types';

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
    messages: Message[];
}

defineProps<Props>();

const submitForm = (message: Message) => {
    router.post(
        route('admin.contact.update', message.id),
        {
            'completed_at': message.completed_at ? new Date().toISOString().slice(0, 19).replace('T', ' ') : null,
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
                <HeadingSmall title="Contact" description="View your unread contact messages"/>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left w-1/12">Afgerond</TableHead>
                            <TableHead>Naam</TableHead>
                            <TableHead>E-Mail</TableHead>
                            <TableHead>Geplaatst op</TableHead>
                            <TableHead>Bericht</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="message in messages" :key="message.id">
                            <TableCell class="flex">
                                <form>
                                    <Switch
                                        class="mr-auto"
                                        id="is-read"
                                        v-model="message.completed_at"
                                        @update:modelValue="submitForm(message)"
                                    />
                                </form>
                            </TableCell>
                            <TableCell>{{ message.first_name + " " + message.last_name }}</TableCell>
                            <TableCell>{{ message.email }}</TableCell>
                            <TableCell>{{ useDateFormat(message.created_at, 'DD-MM-YYYY') }}</TableCell>
                            <TableCell class="max-w-1/2 overflow-scroll">{{ message.message }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
