<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { type BreadcrumbItem } from '@/types';
import { useDateFormat } from '@vueuse/core';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import moment from 'moment';
import { Calendar } from '@/components/ui/calendar'
import {
    DateFormatter,
    getLocalTimeZone,
    today
} from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'
import { toast, Toaster } from 'vue-sonner';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { DaycareRequest } from '@/types';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import Input from '@/components/ui/input/Input.vue'
import { Label } from '@/components/ui/label'
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance daycare',
        href: '/settings/daycare',
    },
];
interface Props {
    daycareRequests: DaycareRequest[];
}
const form = useForm({
    id: '',
    name: '',
    race: '',
    age: '',
    been_to_daycare: false,
    date: null,
    oldDate: ''
});
const props = defineProps<Props>();
const selectedItem = ref<DaycareRequest>(null!);
const modalOpen = ref(false);
const df = new DateFormatter('nl-NL', {
    dateStyle: 'long',
})
const minDate = today(getLocalTimeZone())

const openModal = (request: DaycareRequest) => {
    selectedItem.value = request;
    modalOpen.value = true
}
const submit = (formData: any) => {
    form.id = formData.id;
    form.oldDate = formData.daycare_date;

        form.transform((data) => ({
            ...data,

            date: data.date ? (moment(data.date.toDate()).format("YYYY-MM-DD HH:mm:ss")) : null
        })

        ).post(route('admin.dagopvang.store'), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                modalOpen.value = false;
                toast.success('Succesvol gewijzigd!');
            },
            onError: () => {
                toast.error('Er is iets misgegaan');
            },
        });
}

</script>

<template>

    <Head title="Admin Dagopvang" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Toaster />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Dagopvang" description="Bekijk uw afspraken" />
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left w-1/12">Naam eigenaar</TableHead>
                            <TableHead>Naam hond</TableHead>
                            <TableHead>ingeplande datum</TableHead>
                            <TableHead>Meer info</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>

                        <TableRow v-for="request in props.daycareRequests" :key="request.id" class="">

                            <TableCell>{{ request.owner }}</TableCell>
                            <TableCell>{{ request.name }}</TableCell>
                            <TableCell>{{ useDateFormat(request.daycare_date, 'DD-MM-YYYY') }}</TableCell>
                            <TableCell>
                                <Button @click="openModal(request)">Bewerk</Button>


                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <Dialog v-model:open="modalOpen">


                <DialogContent>
                    <form @submit.prevent="submit(selectedItem)" class=" flex flex-col">
                        <DialogHeader>
                            <DialogTitle>
                                Afspraak info
                            </DialogTitle>
                            <DialogDescription>
                                Hier is meer informatie over de hond van de afspraak
                            </DialogDescription>
                        </DialogHeader>

                        <div class="grid gap-4 py-4">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="email" class="text-right">
                                    Email
                                </Label>
                                <Input id="email" class="col-span-3 color: inherit" disabled
                                    v-model="selectedItem.email" />
                                <Label for="name" class="text-right">
                                    Naam
                                </Label>
                                <Input id="name" class="col-span-3 color: inherit" disabled
                                    v-model="selectedItem.name" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="race" class="text-right">
                                    Ras
                                </Label>
                                <Input id="race" class="col-span-3 color: inherit" disabled
                                    v-model="selectedItem.race" />
                                <input v-model="form.id" hidden>
                                <input v-model="form.oldDate" hidden>
                                <Label for="date" class="text-right">
                                    Datum
                                </Label>
                                <Popover>
                                    <PopoverTrigger as-child>
                                        <Button variant="outline" class="w-fit">
                                            <CalendarIcon class="mr-2 h-4 w-4" />
                                            {{ form.date ? df.format(form.date.toDate(getLocalTimeZone())) :
                                                useDateFormat(selectedItem.daycare_date, 'DD-MM-YYYY') }}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent class="w-auto p-0">
                                        <Calendar v-model="form.date" :min-value="minDate" initial-focus />
                                    </PopoverContent>
                                </Popover>
                            </div>
                        </div>
                        <Button class="mt-12">Wijzig</Button>
                        <DialogFooter>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </SettingsLayout>
    </AppLayout>
</template>
