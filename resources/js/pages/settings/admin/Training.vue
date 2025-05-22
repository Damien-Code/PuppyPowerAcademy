<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Training, TrainingCategory, type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { formatDate } from '@vueuse/core';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import YouTube from 'vue3-youtube';

const youtubeRef = ref<InstanceType<typeof YouTube> | null>(null);

const form = useForm({
    // title, description, link
    title: '',
    description: '',
    training_category_id: 0,
    link: '',
});

const formCat = useForm({
    name: '',
    price: '',
});

const submit = () => {
    form.post(route('admin.training.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Training toegevoegd!');
        },
        onError: (error: any) => {
            console.log(error);
            toast.error('Er is iets mis gegaan.');
        },
    });
};

const submitCategory = () => {
    formCat.post(route('admin.training-categories.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Training toegevoegd!');
        },
        onError: () => {
            toast.error('Er is iets mis gegaan.');
        },
    });
};

const update = (trainingId: any, formData: any) => {
    router.post(
        route('admin.training.update', trainingId),
        {
            ...formData,
            _method: 'PATCH',
        },
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Training gewijzigd!');
            },
            onError: () => {
                toast.error('Er is iets mis gegaan.');
            }
        },
    );
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];

const selectedItem = ref<Training>(null!);
const modalOpen = ref(false);

const openModal = (training: Training) => {
    selectedItem.value = training;
    modalOpen.value = true;
};

interface Props {
    trainings: Training[];
    trainingCategories: TrainingCategory[];
}

defineProps<Props>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Training" />
        <SettingsLayout>
            <div class="space-y-6">
                <div class="flex flex-row">
                    <HeadingSmall title="Training" description="Edit the available training programs" />

                    <Dialog>
                        <DialogTrigger as-child class="mt-auto ml-auto">
                            <Button class="cursor-pointer"> Training categorie toevoegen</Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle> Training categorie toevoegen</DialogTitle>
                                <DialogDescription> Voeg trainingen toe</DialogDescription>
                            </DialogHeader>

                            <form @submit.prevent="submitCategory">
                                <div class="grid gap-4 py-4">
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="title" class="text-right"> Naam van de categorie </Label>
                                        <Input id="title" class="col-span-3" v-model="formCat.name" />
                                        <InputError :message="formCat.errors.name" />
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="price" class="text-right"> Naam van de categorie </Label>
                                        <Input id="price" class="col-span-3" v-model="formCat.price" />
                                        <InputError :message="formCat.errors.price" />
                                    </div>
                                </div>

                                <DialogFooter>
                                    <DialogTrigger>
                                        <Button type="submit" class="cursor-pointer"> Toevoegen</Button>
                                    </DialogTrigger>
                                </DialogFooter>
                            </form>
                        </DialogContent>
                    </Dialog>

                    <Dialog>
                        <DialogTrigger as-child class="mt-auto ml-auto">
                            <Button class="cursor-pointer"> Training toevoegen</Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle> Training toevoegen</DialogTitle>
                                <DialogDescription> Voeg trainingen toe</DialogDescription>
                            </DialogHeader>

                            <form @submit.prevent="submit">
                                <div class="grid gap-4 py-4">
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="title" class="text-right"> Title </Label>
                                        <Input id="title" class="col-span-3" v-model="form.title" />
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="description" class="text-right"> Description </Label>
                                        <Input id="description" class="col-span-3" v-model="form.description" />
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label>Category</Label>
                                        <Select v-model="form.training_category_id">
                                            <SelectTrigger>
                                                <SelectValue placeholder="Kies een categorie" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Categorie</SelectLabel>
                                                    <SelectItem v-for="category in trainingCategories" :key="category.id" :value="category.id">
                                                        {{ category.name }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="link" class="text-right"> YouTube Link </Label>
                                        <Input id="link" class="col-span-3" v-model="form.link" />
                                    </div>
                                </div>

                                <DialogFooter>
                                    <DialogTrigger>
                                        <Button type="submit" class="cursor-pointer"> Toevoegen</Button>
                                    </DialogTrigger>
                                </DialogFooter>
                            </form>
                        </DialogContent>
                    </Dialog>
                </div>
                <div v-for="category in trainingCategories" :key="category.id" class="bg-primary p-8 rounded-lg">
                    <Heading :title="category.name" :description=" '&euro;' + category.price.toString()"/>
                    <div class="flex flex-col" v-if="category.trainings.length != 0">
                        <div v-for="training in category.trainings" :key="training.id" class="my-4 flex rounded-lg bg-white">
                            <div class="relative flex w-1/2 flex-col p-4">
                                <Heading :title="training.title" :description="training.description" />
                                <p class="mt-auto text-black">Gecreeërd op: {{ formatDate(new Date(training.created_at), 'DD-MM-YYYY HH:mm:ss') }}</p>
                                <p class="text-black" v-if="training.created_at != training.updated_at">
                                    Laatst geüpdate op:
                                    {{ formatDate(new Date(training.updated_at), 'DD-MM-YYYY HH:mm:ss') }}
                                </p>
                                <Button class="absolute right-4 bottom-4 w-fit" @click="openModal(training)">Bewerk </Button>
                            </div>
                            <div class="flex w-1/2 flex-col">
                                <div class="mx-auto my-4 h-fit w-fit">
                                    <YouTube
                                        :height="216"
                                        :width="384"
                                        ref="youtubeRef"
                                        :src="training.link"
                                        :vars="{ autoplay: 0 }"
                                        @ready="onReady"
                                    ></YouTube>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <p >Geen training toegevoegd</p>
                    </div>
                </div>
            </div>
            <Dialog v-model:open="modalOpen">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle> Bewerken</DialogTitle>
                        <DialogDescription> Bewerk de training informatie</DialogDescription>
                    </DialogHeader>

                    <form @submit.prevent="update(selectedItem.id, selectedItem)" :id="selectedItem.id">
                        <div class="flex flex-col justify-between gap-4">
                            <Label for="title"> Title </Label>
                            <Input id="title" v-model="selectedItem.title" />
                            <Label for="price"> Price </Label>
                            <Input id="price" v-model="selectedItem.price" />
                            <Label for="description"> Description </Label>
                            <Input id="description" v-model="selectedItem.description" />
                            <Label>Category</Label>
                            <Select v-model="selectedItem.training_category">
                                <SelectTrigger>
                                    <SelectValue placeholder="Kies een categorie" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Categorie</SelectLabel>
                                        <SelectItem v-for="category in trainingCategories" :key="category.id" :value="selectedItem.training_category">
                                            {{ category.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <Label for="link"> YouTube Link </Label>
                            <Input id="link" v-model="selectedItem.link" />
                        </div>
                        <DialogFooter>
                            <DialogTrigger>
                                <Button type="submit" class="cursor-pointer"> Toevoegen</Button>
                            </DialogTrigger>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
            <Toaster />
        </SettingsLayout>
    </AppLayout>
</template>
