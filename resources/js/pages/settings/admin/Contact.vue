<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Label } from '@/components/ui/label'
import { Switch } from '@/components/ui/switch'

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';
import { reactive } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Admin panel',
        href: '/settings/admin',
    },
];

interface Props {
    messages: Message[];
}

const messages = reactive<Message[]>([
    {
        first_name: 'Floris',
        last_name: 'Hafkenscheid',
        email: 'floris@hafkenscheid.com',
        message: 'ewpgohkwsdjkfjwhi4geyfkhjsk wouhfwekfdjewoufyei fhw ifgejwg w',
        is_completed: true,
        created_at: '12-03-2025T12:00:23'
    }
])
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Panel"/>

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Contact" description="View your unread contact messages"/>
                <Table class="">
                    <TableHeader>
                        <TableRow>
                            <TableHead>Geplaatst op</TableHead>
                            <TableHead>Naam</TableHead>
                            <TableHead>E-Mail</TableHead>
                            <TableHead class="max-w-1/2">Bericht</TableHead>
                            <TableHead class="text-right w-1/12">Afgerond</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="message in messages" :key="message.id" class="">
                            <TableCell>{{ message.created_at }}</TableCell>
                            <TableCell>{{ message.first_name + " " + message.last_name }}</TableCell>
                            <TableCell>{{ message.email }}</TableCell>
                            <TableCell class="max-w-1/2 overflow-scroll">{{ message.message }}</TableCell>
                            <TableCell class="flex">
                                <Switch class="ml-auto" id="is-read" v-model="message.is_completed" />
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
