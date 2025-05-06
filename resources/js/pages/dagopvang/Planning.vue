<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Webshop',
        href: '/webshop',
    },
];
// Use this if time is added to planning for daycare

// import { ref } from 'vue';
// import VueDatePicker from '@vuepic/vue-datepicker';
// import '@vuepic/vue-datepicker/dist/main.css'
//
// const date = ref();

// import { cn } from '@/utils'

import { Calendar } from '@/components/ui/calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
} from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'
import { ref } from 'vue'

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
})

const value = ref<DateValue>()
</script>

<template>
    <Head title="Dagopvang planning" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form class="mx-auto flex w-2/6 flex-col pt-12">
                <label>Naam van de hond</label>
                <Input />
                <label>Ras</label>
                <Input />
                <label>Email</label>
                <Input />
                <label>Datum</label>
                <Popover>
                    <PopoverTrigger as-child>
                        <Button
                            variant="outline"
                        >
                            <CalendarIcon class="mr-2 h-4 w-4" />
                            {{ value ? df.format(value.toDate(getLocalTimeZone())) : "Pick a date" }}
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                        <Calendar v-model="value" initial-focus />
                    </PopoverContent>
                </Popover>
<!--                <VueDatePicker/>-->
                <Button class="mt-12">Plan</Button>
            </form>
        </div>
        <Footer />
    </AppLayout>
</template>

<Footer />
