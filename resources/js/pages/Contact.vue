<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Footer from '@/components/Footer.vue';
import Heading from '@/components/Heading.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { toast } from 'vue-sonner';
import { Toaster} from '@/components/ui/sonner';
import InputError from '@/components/InputError.vue';
import { computed } from 'vue';

const page = usePage();

const getFirstName = computed(() => {
    const user = page.props.auth.user;
    return user?.name ? user.name.split(' ')[0] : '';
});

const getLastName = computed(() => {
    const user = page.props.auth.user;
    return user?.name ? user.name.split(' ')[1] : '';
});

const getEmail = computed(() => {
    const user = page.props.auth.user;
    return user?.email || '';
});
import { computed } from 'vue';

const page = usePage();

const getFirstName = computed(() => {
    const user = page.props.auth.user;
    return user?.name ? user.name.split(' ')[0] : '';
});

const getLastName = computed(() => {
    const user = page.props.auth.user;
    return user?.name ? user.name.split(' ')[1] : '';
});

const getEmail = computed(() => {
    const user = page.props.auth.user;
    return user?.email || '';
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contact',
        href: '/contact',
    },
];

const form = useForm({
    first_name: getFirstName.value,
    last_name: getLastName.value,
    email: getEmail.value,
    first_name: getFirstName.value,
    last_name: getLastName.value,
    email: getEmail.value,
    message: '',
    completed_at: '',
});

const submit = () => {
    form.post(route('contact.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Uw bericht is verstuurd');
        },
        onError: () => {
            toast.error('Er is iets misgegaan');
        },
    });
};
</script>

<template>
    <Head title="Contact" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster/>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="border-sidebar-border/70 dark:border-sidebar-border relative mx-auto rounded-xl border md:min-h-min bg-white p-8">
                <Heading title="Contact" description="Mocht u vragen hebben, stel ze gerust via dit contactformulier"/>
                <form class="flex flex-col justify-between gap-4 p-4 md:w-96 min-h-full" @submit.prevent="submit">
                    <Label for="first_name">Voornaam</Label>
                    <Input 
                        v-model="form.first_name" 
                        :placeholder="getFirstName ? '' : 'Voornaam'"
                    />
                    <Input 
                        v-model="form.first_name" 
                        :placeholder="getFirstName ? '' : 'Voornaam'"
                    />
                    <InputError :message="form.errors.first_name"/>
                    <Label for="last_name">Achternaam</Label>
                    <Input 
                        v-model="form.last_name" 
                        :placeholder="getLastName ? '' : 'Achternaam'"
                    />
                    <Input 
                        v-model="form.last_name" 
                        :placeholder="getLastName ? '' : 'Achternaam'"
                    />
                    <InputError :message="form.errors.last_name"/>
                    <Label for="last_name">Email</Label>
                    <Input 
                        v-model="form.email" 
                        :placeholder="getEmail ? '' : 'Email'"
                    />
                    <Input 
                        v-model="form.email" 
                        :placeholder="getEmail ? '' : 'Email'"
                    />
                    <InputError :message="form.errors.email"/>
                    <Label for="last_name">Bericht</Label>
                    <textarea v-model="form.message" class="border-1 border-primary rounded-md h-24"></textarea>
                    <InputError :message="form.errors.message"/>
                    <input type="hidden" v-model="form.completed_at" />
                    <Button type="submit" :disabled="form.processing">Versturen</Button>
                </form>
            </div>
        </div>
        <Footer />
    </AppLayout>
</template>
