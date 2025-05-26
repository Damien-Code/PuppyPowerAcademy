<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { type BreadcrumbItem } from '@/types';
import { useDateFormat } from '@vueuse/core';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { DaycareRequest } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance daycare',
        href: '/settings/daycare',
    },
];
interface Props {
    daycareRequests: DaycareRequest[];
}

const props = defineProps<Props>();

console.log(props.daycareRequests);

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Dagopvang" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Dagopvang" description="Bekijk uw afspraken"/>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left w-1/12">Naam eigenaar</TableHead>
                            <TableHead class="text-left w-1/12">Email eigenaar</TableHead>
                            <TableHead>Naam hond</TableHead>
                            <TableHead>Ras hond</TableHead>
                            <TableHead>Geslacht</TableHead>
                            <TableHead>Geboortedatum</TableHead>
                            <TableHead>Foto hond</TableHead>
                            <TableHead>ingeplande datum</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                    
                        <TableRow v-for="request in props.daycareRequests" :key="request.id" class="">
                            <!-- <TableCell class="flex">
                                <form>
                                    <Switch
                                        class="mr-auto"
                                        id="is-read"
                                        v-model="request.is_completed"
                                        @update:modelValue="submitForm(request)"
                                    />
                                </form>
                            </TableCell> -->
                            <TableCell>{{ request.owner}}</TableCell>
                            <TableCell>{{ request.email }}</TableCell>
                            <TableCell>{{ request.name }}</TableCell>
                            <TableCell>{{ request.race }}</TableCell>
                            <TableCell>geslacht to be added</TableCell>
                            <TableCell>Geboortedatum to be added</TableCell>
                            <TableCell>foto hond</TableCell>
                            <TableCell class="max-w-1/2 overflow-scroll">{{ useDateFormat(request.daycare_date, 'DD-MM-YYYY') }}</TableCell>
                            </TableRow>
                    </TableBody>
                </Table>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
