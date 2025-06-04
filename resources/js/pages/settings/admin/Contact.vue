<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Switch } from '@/components/ui/switch';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Message, type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { useDateFormat } from '@vueuse/core';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Admin panel',
        href: '/settings/admin',
    },
];

interface Props {
    messages: Message[];
}

defineProps<Props>();

const selectedMessage = ref<Message | null>(null);
const isDialogOpen = ref(false);

const submitForm = (message: Message) => {
    router.post(
        route('admin.contact.update', message.id),
        {
            'completed_at': message.completed_at ? new Date().toISOString().slice(0, 19).replace('T', ' ') : null,
            _method: 'PATCH',
        }
    )
}

const openMessageDialog = (message: Message) => {
    selectedMessage.value = message;
    isDialogOpen.value = true;
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Panel"/>

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Contact" description="View your unread contact messages"/>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left w-1/12">Afgerond</TableHead>
                            <TableHead>Naam</TableHead>
                            <TableHead>E-Mail</TableHead>
                            <TableHead>Geplaatst op</TableHead>
                            <TableHead>Bericht</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="message in messages" :key="message.id" class="group">
                            <!-- Switch Cell - NOT clickable -->
                            <TableCell class="flex" @click.stop>
                                <form>
                                    <Switch
                                        class="mr-auto"
                                        id="is-read"
                                        v-model="message.completed_at"
                                        @update:modelValue="submitForm(message)"
                                    />
                                </form>
                            </TableCell>
                            
                            <!-- Name Cell - Clickable with connected hover -->
                            <TableCell 
                                class="cursor-pointer hover:bg-muted/50 transition-colors group-hover:bg-muted/50"
                                @click="openMessageDialog(message)"
                                @mouseenter="$event.target.closest('tr').classList.add('hover-active')"
                                @mouseleave="$event.target.closest('tr').classList.remove('hover-active')"
                            >
                                {{ message.first_name + " " + message.last_name }}
                            </TableCell>
                            
                            <!-- Email Cell - Clickable with connected hover -->
                            <TableCell 
                                class="cursor-pointer hover:bg-muted/50 transition-colors group-hover:bg-muted/50"
                                @click="openMessageDialog(message)"
                                @mouseenter="$event.target.closest('tr').classList.add('hover-active')"
                                @mouseleave="$event.target.closest('tr').classList.remove('hover-active')"
                            >
                                {{ message.email }}
                            </TableCell>
                            
                            <!-- Date Cell - Clickable with connected hover -->
                            <TableCell 
                                class="cursor-pointer hover:bg-muted/50 transition-colors group-hover:bg-muted/50"
                                @click="openMessageDialog(message)"
                                @mouseenter="$event.target.closest('tr').classList.add('hover-active')"
                                @mouseleave="$event.target.closest('tr').classList.remove('hover-active')"
                            >
                                {{ useDateFormat(message.created_at, 'DD-MM-YYYY') }}
                            </TableCell>
                            
                            <!-- Message Cell - Clickable with connected hover -->
                            <TableCell 
                                class="cursor-pointer hover:bg-muted/50 transition-colors group-hover:bg-muted/50 max-w-xs"
                                @click="openMessageDialog(message)"
                                @mouseenter="$event.target.closest('tr').classList.add('hover-active')"
                                @mouseleave="$event.target.closest('tr').classList.remove('hover-active')"
                            >
                                <div class="truncate">
                                    {{ message.message }}
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <!-- Message Dialog -->
                <Dialog v-model:open="isDialogOpen">
                    <DialogContent class="sm:max-w-[600px]">
                        <DialogHeader>
                            <DialogTitle>Contact Bericht</DialogTitle>
                        </DialogHeader>
                        <div class="space-y-4" v-if="selectedMessage">
                            <!-- Contact Details -->
                            <div class="bg-muted/50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-muted-foreground">Naam:</span>
                                        <p class="font-medium">{{ selectedMessage.first_name }} {{ selectedMessage.last_name }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-muted-foreground">E-mail:</span>
                                        <p class="font-medium">{{ selectedMessage.email }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-muted-foreground">Datum:</span>
                                        <p class="font-medium">{{ useDateFormat(selectedMessage.created_at, 'DD-MM-YYYY HH:mm') }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-muted-foreground">Status:</span>
                                        <p class="font-medium" :class="selectedMessage.completed_at ? 'text-green-600' : 'text-orange-600'">
                                            {{ selectedMessage.completed_at ? 'Afgerond' : 'Open' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Message Content -->
                            <div>
                                <h4 class="font-medium text-muted-foreground mb-2">Bericht:</h4>
                                <div class="bg-background border rounded-lg p-4 max-h-96 overflow-y-auto">
                                    <p class="whitespace-pre-wrap leading-relaxed">{{ selectedMessage.message }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex justify-between pt-4">
                            <Button @click="isDialogOpen = false">
                                Sluiten
                            </Button>
                        </div>
                    </DialogContent>
                </Dialog>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
