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

import { Calendar } from '@/components/ui/calendar'
import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
} from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'

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
// const form = useForm({
//     name: ''
//     date: null,
// });
const props = defineProps<Props>();
const selectedItem = ref<DaycareRequest>(null!);
const modalOpen = ref(false);
const df = new DateFormatter('nl-NL', {
    dateStyle: 'long',
})

const openModal = (request: DaycareRequest) => {
    selectedItem.value = request;
    modalOpen.value = true
}
console.log(props.daycareRequests);

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Admin Dagopvang" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Dagopvang" description="Bekijk uw afspraken" />
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left w-1/12">Naam eigenaar</TableHead>
                            <!-- <TableHead class="text-left w-1/12">Email eigenaar</TableHead> -->
                            <TableHead>Naam hond</TableHead>
                            <!-- <TableHead>Ras hond</TableHead>
                            <TableHead>Geslacht</TableHead>
                            <TableHead>Geboortedatum</TableHead>
                            <TableHead>Foto hond</TableHead> -->
                            <TableHead>ingeplande datum</TableHead>
                            <TableHead>Meer info</TableHead>
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
                            <TableCell>{{ request.owner }}</TableCell>
                            <!-- <TableCell>{{ request.email }}</TableCell> -->
                            <TableCell>{{ request.name }}</TableCell>
                            <!-- <TableCell>{{ request.race }}</TableCell> -->
                            <!-- <TableCell>geslacht to be added</TableCell> -->
                            <!-- <TableCell>Geboortedatum to be added</TableCell> -->
                            <!-- <TableCell>foto hond</TableCell> -->
                            <TableCell>{{ useDateFormat(request.daycare_date, 'DD-MM-YYYY') }}</TableCell>
                            <TableCell>
                                <Button @click="openModal(request)">Bewerk</Button>


                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <Dialog v-model:open="modalOpen">
                <DialogTrigger as-child class="ml-auto mt-auto">
                    <Button class="cursor-pointer">
                        Meer info
                    </Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>
                            Afspraak info
                        </DialogTitle>
                        <DialogDescription>
                            Hier is meer informatie over de hond van de afspraak
                        </DialogDescription>
                    </DialogHeader>

                    <!-- <form @submit.prevent="submit"> -->
                    <div class="grid gap-4 py-4">
                        <div class="grid grid-cols-4 items-center gap-4">
                            <Label for="email" class="text-right">
                                Email
                            </Label>
                            <Input id="email" class="col-span-3 color: inherit" disabled v-model="selectedItem.email" />
                            <Label for="name" class="text-right">
                                Naam
                            </Label>
                            <Input id="name" class="col-span-3 color: inherit" disabled v-model="selectedItem.name" />
                        </div>
                        <div class="grid grid-cols-4 items-center gap-4">
                            <Label for="race" class="text-right">
                                Ras
                            </Label>
                            <Input id="race" class="col-span-3 color: inherit" disabled v-model="selectedItem.race" />
                            <Label for="gender" class="text-right">
                                Geslacht
                            </Label>
                            <Input id="gender" class="col-span-3 text-black" disabled placeholder="gender TBA" />
                            <Label for="birthdate" class="text-right">
                                Geboortedatum
                            </Label>
                            <Input id="birthdate" class="col-span-3 text-black" disabled placeholder="birthdate TBA" />
                            <Label for="photo" class="text-right">
                                Foto
                            </Label>
                            <Input id="photo" class="col-span-3" disabled placeholder="photo TBA" />

                            <Label for="date" class="text-right">
                                Datum
                            </Label>
                            <Popover>
                                <PopoverTrigger as-child>
                                    <Button variant="outline">
                                        <CalendarIcon class="mr-2 h-4 w-4" />
                                        <!-- {{ form.date ? df.format(form.date.toDate(getLocalTimeZone())) : "Pick a date" }} -->
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent class="w-auto p-0">
                                    <Calendar initial-focus />
                                </PopoverContent>
                            </Popover>
                            <!-- <Input id="date" class="col-span-3" v-model="selectedItem.daycare_date"/> -->
                        </div>
                    </div>

                    <DialogFooter>
                        <!-- <DialogTrigger>
                                                    <Button type="submit" class="cursor-pointer">
                                                        Toevoegen
                                                    </Button>
                                                </DialogTrigger> -->
                    </DialogFooter>
                    <!-- </form> -->
                </DialogContent>
            </Dialog>
        </SettingsLayout>
    </AppLayout>
</template>
