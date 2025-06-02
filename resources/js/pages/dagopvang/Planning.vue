<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import {
    DateFormatter,
    getLocalTimeZone,
    today
} from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'
import { toast, Toaster } from 'vue-sonner';
import InputError from '@/components/InputError.vue';
import Heading from '@/components/Heading.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Webshop',
        href: '/webshop',
    },
];
const df = new DateFormatter('nl-NL', {
    dateStyle: 'long',
})

const form = useForm({
    name: '',
    race: '',
    age: '',
    date: null,
});
/**
 * @author Damien-Code
 * Function that submits the form for daycare
 */
const submit = () => {
    form.transform((data) => ({
        ...data,
        date: data.date ? data.date.toDate().toLocaleString('nl-NL') : null,
    })).post(route('dagopvang.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Succesvol aangevraagd!');
        },
        onError: () => {
            toast.error('Er is iets misgegaan');
        },
    });
}
// minDate so user cannot register for daycare when date has passed
const minDate = today(getLocalTimeZone())
</script>

<template>
    <Head title="Dagopvang planning" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster/>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="mx-auto md:w-1/2 lg:w-2/6 p-8 bg-white rounded-2xl">
                <Heading title="Dagopvang" description="Plan hier uw afspraak in" />
            <form @submit.prevent="submit" class=" flex flex-col">
                <label>Naam van de hond</label>
                <Input v-model="form.name"/>
                <InputError :message="form.errors.name"/>
                <label>Ras</label>
                <Input v-model="form.race" />
                <InputError :message="form.errors.race"/>
                <label>Leeftijd</label>
                <Input v-model="form.age" type="number"/>
                <InputError :message="form.errors.age"/>
                <label>Datum</label>
                <Popover>
                    <PopoverTrigger as-child>
                        <Button
                            variant="outline"
                        >
                            <CalendarIcon class="mr-2 h-4 w-4" />
                            {{ form.date ? df.format(form.date.toDate(getLocalTimeZone())) : "Kies een datum" }}
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                        <Calendar v-model="form.date" initial-focus :min-value="minDate"/>
                    </PopoverContent>
                </Popover>
                <InputError :message="form.errors.date"/>
                <input v-model="form.been_to_daycare" hidden>
                <Button class="mt-12">Plan</Button>
            </form>
            </div>
        </div>
        <Footer />
    </AppLayout>
</template>

<Footer />
