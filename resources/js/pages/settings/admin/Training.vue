<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
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
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

const youtubeRef = ref<InstanceType<typeof YouTube> | null>(null);

const onReady = () => {
    youtubeRef.value?.playVideo();
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];

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
                            <Button>
                                Training toevoegen
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>

                                </DialogTitle>
                                <DialogDescription>

                                </DialogDescription>
                            </DialogHeader>
                            
                            <div>
                                
                            </div>
                            
                            <DialogFooter>

                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
                </div>
                <div class="flex flex-col">
                    <div v-for="training in trainings" :key="training.id" class="flex">
                        <div class="w-1/2 border-2 border-white">
        
                        </div>
                        <div class="w-1/2 flex flex-col border-2 border-blue-900">
                            <div class="my-4 mx-auto border-red-900 border-2 h-fit w-fit">
                                <Heading :title="training.title"/>
                                <YouTube :height="216" :width="384" ref="youtubeRef" :src="training.link" :vars="{ autoplay: 0 }" @ready="onReady" class="-mt-8"></YouTube>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
