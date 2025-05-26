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
    title: '',
    description: '',
    training_category_id: 0,
    link: '',
});

// This makes it able to submit the training category form.
const formCat = useForm({
    name: '',
    price: '',
});

// This makes it able to submit the training.
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
/**
 * @author Damien-Code
 * The function to submit the training category.
 */
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

// This makes it able to update an individual training.
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
            },
        },
    );
};

/**
 * @author Damien-Code
 * This makes it able to update an individual training category.
 * @param categoryId
 * @param formData
 */
const updateCategory = (categoryId: any, formData: any) => {
    router.post(
        route('admin.training-categories.update', categoryId),
        {
            ...formData,
            _method: 'PATCH',
        },
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Training categorie gewijzigd!');
            },
            onError: () => {
                toast.error('Er is iets mis gegaan.');
            },
        },
    );
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];

// This makes it able to use data from an individual training.
const selectedItem = ref<Training>(null!);
const modalOpen = ref(false);

// This makes it able to use date from an individual training category.
const selectedCat = ref<TrainingCategory>(null!);
const modalOpenCat = ref(false);

// Opens the dialog/modal for training.
const openModal = (training: Training) => {
    selectedItem.value = training;
    modalOpen.value = true;
};

// Opens the dialog/modal for training category.
const openModalCat = (trainingCategory: TrainingCategory) => {
    selectedCat.value = trainingCategory;
    modalOpenCat.value = true;
};

/**
 * @author Damien-Code
 * Function that deletes the training category
 * @param id
 */
const deleteCategory = (id: number) => {
    if (confirm("Weet je zeker dat je deze categorie wilt verwijderen, alle video's worden dan ook verwijderd.")) {
        router.delete(route('admin.training-categories.destroy', { id }), {
            onSuccess: () => {
                toast.success('Training categorie verwijderd');
            },
            onError: () => {
                toast.error('Er is iets mis gegaan');
            },
        });
    }
};

/**
 * @author Damien-Code
 * Function that deletes a single training from a category
 * @param id
 */
const deleteTraining = (id: number) => {
    router.delete(route('admin.training.destroy', { id }), {
        onSuccess: () => {
            toast.success('Training verwijderd');
        },
        onError: () => {
            toast.error('Er is iets mis gegaan');
        },
    });
};

// Define the props for the training and training category
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
                <HeadingSmall title="Training" description="Edit the available training programs" />
                <!--Modal for training category-->
                <div class="md:justify-between lg:flex">
                    <Dialog>
                        <DialogTrigger as-child>
                            <Button class="mr-4 mb-4 cursor-pointer lg:mb-0"> Training categorie toevoegen</Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle> Training categorie toevoegen</DialogTitle>
                                <DialogDescription> Voeg trainingen toe</DialogDescription>
                            </DialogHeader>

                            <form @submit.prevent="submitCategory">
                                <div class="grid gap-4 py-4">
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="title"> Naam van de categorie </Label>
                                        <Input id="title" class="col-span-3" v-model="formCat.name" />
                                        <InputError :message="formCat.errors.name" class="col-span-3" />
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="price"> Prijs </Label>
                                        <Input id="price" class="col-span-3" v-model="formCat.price" />
                                        <InputError :message="formCat.errors.price" class="col-span-3" />
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
                    <!--Modal for training-->
                    <Dialog>
                        <DialogTrigger as-child>
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
                                        <Label for="title" class="text-right"> Titel </Label>
                                        <Input id="title" class="col-span-3" v-model="form.title" />
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="description" class="text-right"> Beschrijving </Label>
                                        <Input id="description" class="col-span-3" v-model="form.description" />
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label>Categorie</Label>
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
                <div class="flex flex-col">
                    <div v-for="training in trainings" :key="training.id" class="flex my-4 bg-white rounded-lg">
                        <div class="w-1/2 flex flex-col p-4 relative">
                            <Heading :title="training.title + ' (€' + training.price + ')'" :description="training.description"/>
                            <p class="text-black mt-auto">Gecreeërd op: {{ formatDate(new Date(training.created_at), "DD-MM-YYYY HH:mm:ss") }}</p>
                            <p class="text-black" v-if="training.created_at != training.updated_at">Laatst geüpdate op: {{ formatDate(new Date(training.updated_at), "DD-MM-YYYY HH:mm:ss") }}</p>
                            <Button class="w-fit absolute right-4 bottom-4" @click="openModal(training)">Bewerk</Button>
                        </div>
                        <div class="w-1/2 flex flex-col">
                            <div class="my-4 mx-auto h-fit w-fit">
                                <YouTube :height="216" :width="384" ref="youtubeRef" :src="training.link" :vars="{ autoplay: 0 }" @ready="onReady"></YouTube>
                            </div>
                        </div>
                    </div>
                    <div v-else class="mt-4">
                        <HeadingSmall title="Geen trainingen toegevoegd" />
                    </div>
                </div>
            </div>
            <!--            Modal for update of training-->
            <!--            Chose to have the modal outside of the foreach because of faster load-->
            <!--            Having it defined in the foreach makes it load an modal for every training-->
            <Dialog v-model:open="modalOpen">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle> Bewerken</DialogTitle>
                        <DialogDescription> Bewerk de training informatie</DialogDescription>
                    </DialogHeader>

                    <form @submit.prevent="update(selectedItem.id, selectedItem)" :id="selectedItem.id">
                        <div class="grid gap-4 py-4">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="title" class="text-right">
                                    Title
                                </Label>
                                <Input id="title" class="col-span-3" v-model="selectedItem.title"/>
                                <Label for="price" class="text-right">
                                    Price
                                </Label>
                                <Input id="price" class="col-span-3" v-model="selectedItem.price"/>
                                <Label for="description" class="text-right">
                                    Description
                                </Label>
                                <Input id="description" class="col-span-3" v-model="selectedItem.description"/>
                                <Label for="link" class="text-right">
                                    YouTube Link
                                </Label>
                                <Input id="link" class="col-span-3" v-model="selectedItem.link"/>
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
             <Toaster />
        </SettingsLayout>
    </AppLayout>
</template>
