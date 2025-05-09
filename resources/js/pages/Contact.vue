<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Footer from '@/components/Footer.vue';
import Heading from '@/components/Heading.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contact',
        href: '/contact',
    },
];

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    message: '',
    is_completed: false,
})

const submit = () => {
    form.post(route('contact.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
        }
    )
}
</script>

<template>
    <Head title="Contact" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="min-h-[15vh] rounded-xl border border-sidebar-border/70 dark:border-sidebar-border flex justify-center flex-col items-center">
                <Heading title="Contact"/>
                <heading-small title="Mocht u vragen hebben, stel ze gerust via dit contactformulier"/>
            </div>
            <div class="relative min-h-[75vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min mx-auto">
                <form class="flex justify-between flex-col p-4 gap-4 md:w-96" @submit.prevent="submit">
                    <Label for="first_name">Voornaam</Label>
                    <Input v-model="form.first_name" placeholder="Voornaam"/>
                    <Label for="last_name">Achternaam</Label>
                    <Input v-model="form.last_name" placeholder="Achternaam"/>
                    <Label for="last_name">Email</Label>
                    <Input v-model="form.email" placeholder="Email"/>
                    <Label for="last_name">Bericht</Label>
                    <textarea v-model="form.message"></textarea>
                    <input type="hidden" v-model="form.is_completed"/>
                    <Button type="submit">Versturen</Button>
                </form>
            </div>
        </div>
        <Footer/>
    </AppLayout>
</template>
