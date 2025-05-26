<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Training, type BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import YouTube from 'vue3-youtube';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
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
import { formatDate } from '@vueuse/core';
import { toast, Toaster } from 'vue-sonner';

const youtubeRef = ref<InstanceType<typeof YouTube> | null>(null);

const form = useForm({
    // title, price, description, link
    title: '',
    price: '',
    description: '',
    link: '',
})

const submit = () => {
    form.post(route('admin.training.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Training toegevoegd!');
        },
        onError: () => {
            toast.error('Er is iets mis gegaan.')
        },
    })
}

const update = (trainingId: any, formData: any) => {
    router.post(
        route('admin.training.update', trainingId), {
            ...formData,
            _method: 'PATCH'
        },
        {
            forceFormData: true,
            preserveScroll: true,
        }
    )

}

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
    modalOpen.value = true
}

interface Props {
    trainings: Training[];
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
                        <DialogTrigger as-child class="ml-auto mt-auto">
                            <Button class="cursor-pointer">
                                Training toevoegen
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>
                                    Training toevoegen
                                </DialogTitle>
                                <DialogDescription>
                                    Voeg trainingen toe 
                                </DialogDescription>
                            </DialogHeader>
                            
                            <form @submit.prevent="submit">
                                <div class="grid gap-4 py-4">
                                    <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="title" class="text-right">
                                            Title
                                        </Label>
                                        <Input id="title" class="col-span-3" v-model="form.title"/>
                                        </div>
                                        <div class="grid grid-cols-4 items-center gap-4">
                                        <Label for="price" class="text-right">
                                            Price
                                        </Label>
                                        <Input id="price" class="col-span-3" v-model="form.price"/>
                                        <Label for="description" class="text-right">
                                            Description
                                        </Label>
                                        <Input id="description" class="col-span-3"  v-model="form.description"/>
                                        <Label for="link" class="text-right">
                                            YouTube Link
                                        </Label>
                                        <Input id="link" class="col-span-3" v-model="form.link"/>
                                    </div>
                                </div>
                                
                                <DialogFooter>
                                    <DialogTrigger>
                                        <Button type="submit" class="cursor-pointer">
                                            Toevoegen
                                        </Button>
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
                </div>
            </div>
            <Dialog v-model:open="modalOpen">  
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>
                            Bewerken
                        </DialogTitle>
                        <DialogDescription>
                            Bewerk de training informatie
                        </DialogDescription>
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
                                <Button type="submit" class="cursor-pointer">
                                    Toevoegen
                                </Button>
                            </DialogTrigger>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
             <Toaster />
        </SettingsLayout>
    </AppLayout>
</template>
