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

const onReady = () => {
    youtubeRef.value?.playVideo();
};

// This makes it able to submit the training form.
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
    if(confirm("Weet je zeker dat je deze categorie wilt verwijderen, alle video's worden dan ook verwijderd.")) {
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
}

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
                                        <Label for="title"> Naam van de categorie </Label>
                                        <Input id="title" class="col-span-3" v-model="formCat.name" />
                                        <InputError :message="formCat.errors.name" />
                                    </div>
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="price"> Prijs </Label>
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

                <!--                Display for training category and training-->
                <div v-for="category in trainingCategories" :key="category.id" class="bg-primary rounded-lg p-8">
                    <div class="flex justify-between">
                        <Heading :title="category.name" :description="'&euro;' + category.price.toString()" />
                        <!--                        Opens the modal for category-->
                        <Button variant="secondary" @click="openModalCat(category)">Bewerk categorie</Button>
                        <Button variant="destructive" @click="deleteCategory(category.id)">Delete</Button>
                    </div>
                    <div class="flex flex-col" v-if="category.trainings.length != 0">
                        <div v-for="training in category.trainings" :key="training.id" class="bg-background my-4 flex flex-col rounded-lg">
                            <div class="p-4">
                                <div class="flex justify-between">
                                    <Heading :title="training.title" :description="training.description" />
                                    <!--                                Opens the modal for training-->
                                    <div>
                                        <Button @click="openModal(training)" class="mr-4">Bewerk</Button>
                                        <Button @click="deleteTraining(training.id)" variant="destructive">Verwijder </Button>
                                    </div>
                                </div>
                                <p class="mt-auto text-black">Gecreeërd op: {{ formatDate(new Date(training.created_at), 'DD-MM-YYYY HH:mm:ss') }}</p>
                                <p class="text-black" v-if="training.created_at != training.updated_at">
                                    Laatst geüpdate op:
                                    {{ formatDate(new Date(training.updated_at), 'DD-MM-YYYY HH:mm:ss') }}
                                </p>
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
                    <div v-else>
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
                        <div class="flex flex-col justify-between gap-4">
                            <Label for="title"> Title </Label>
                            <Input id="title" v-model="selectedItem.title" />
                            <Label for="description"> Description </Label>
                            <Input id="description" v-model="selectedItem.description" />
                            <Label>Category</Label>
                            <Select v-model="selectedItem.training_category_id">
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

            <!--            Modal for the category-->
            <!--            Chose to have the modal outside of the foreach because of faster load-->
            <!--            Having it defined in the foreach makes it load an modal for every training category-->
            <Dialog v-model:open="modalOpenCat">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle> Bewerken</DialogTitle>
                        <DialogDescription> Bewerk de training informatie</DialogDescription>
                    </DialogHeader>

                    <form @submit.prevent="updateCategory(selectedCat.id, selectedCat)" :id="selectedCat.id">
                        <div class="flex flex-col justify-between gap-4">
                            <Label for="title"> Naam </Label>
                            <Input id="title" v-model="selectedCat.name" />
                            <Label for="description"> Prijs </Label>
                            <Input id="description" v-model="selectedCat.price" />
                        </div>
                        <DialogFooter>
                            <DialogTrigger>
                                <Button type="submit" class="cursor-pointer"> Toevoegen</Button>
                            </DialogTrigger>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
            <!--            Toaster for displaying error or success messages-->
            <Toaster />
        </SettingsLayout>
    </AppLayout>
</template>
