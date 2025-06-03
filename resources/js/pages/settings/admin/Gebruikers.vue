<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

import { BreadcrumbItem, User } from '@/types';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Switch } from '@/components/ui/switch';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import HeadingSmall from '@/components/HeadingSmall.vue';
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
    users: User[]
}

defineProps<Props>();

const selectedUser = ref<User | null>(null);
const isDialogOpen = ref(false);

const submitForm = (user: User) => {
    router.post(
        route('admin.gebruikers.update', user.id),
        {
            'role_id': user.role_id === 1 ? 2 : 1, // Toggle between 1 and 2
            _method: 'PATCH',
        }
    )
}

const openEditDialog = (user: User) => {
    selectedUser.value = { ...user }; // Create a copy to avoid mutating the original
    isDialogOpen.value = true;
}

const saveUser = () => {
    if (selectedUser.value) {
        router.patch(
            route('admin.gebruikers.update', selectedUser.value.id),
            {
                name: selectedUser.value.name,
                email: selectedUser.value.email,
            },
            {
                onSuccess: () => {
                    isDialogOpen.value = false;
                    selectedUser.value = null;
                }
            }
        );
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Admin Panel"/>

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Gebruikers" description="Beheer gebruikers en hun rollen"/>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-left w-1/12">Admin</TableHead>
                            <TableHead>Naam</TableHead>
                            <TableHead>E-Mail</TableHead>
                            <TableHead>Geverifieërd</TableHead>
                            <TableHead>Gecreeërd op</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="user in users" :key="user.id" class="group">
                            <!-- Admin Switch Cell - NOT clickable -->
                            <TableCell class="flex">
                                <Switch
                                    class="mr-auto"
                                    :model-value="user.role_id === 1"
                                    @update:modelValue="submitForm(user)"
                                    :disabled="$page.props.auth.user.id === user.id"
                                />
                            </TableCell>
                            
                            <!-- Name Cell - Clickable with connected hover -->
                            <TableCell 
                                class="cursor-pointer hover:bg-muted/50 transition-colors group-hover:bg-muted/50"
                                @click="openEditDialog(user)"
                                @mouseenter="$event.target.closest('tr').classList.add('hover-active')"
                                @mouseleave="$event.target.closest('tr').classList.remove('hover-active')"
                            >
                                {{ user.name }}
                            </TableCell>
                            
                            <!-- Email Cell - Clickable with connected hover -->
                            <TableCell 
                                class="cursor-pointer hover:bg-muted/50 transition-colors group-hover:bg-muted/50"
                                @click="openEditDialog(user)"
                                @mouseenter="$event.target.closest('tr').classList.add('hover-active')"
                                @mouseleave="$event.target.closest('tr').classList.remove('hover-active')"
                            >
                                {{ user.email }}
                            </TableCell>
                            
                            <!-- Verified Cell - NOT clickable -->
                            <TableCell>
                                {{ user.email_verified_at ? "Ja" : "Nee" }}
                            </TableCell>
                            
                            <!-- Created Date Cell - NOT clickable -->
                            <TableCell>
                                {{ useDateFormat(user.created_at, 'DD-MM-YYYY') }}
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <!-- Dialog placed outside the table to avoid styling conflicts -->
                <Dialog v-model:open="isDialogOpen">
                    <DialogContent class="sm:max-w-[425px]">
                        <DialogHeader>
                            <DialogTitle>Gebruiker bewerken</DialogTitle>
                        </DialogHeader>
                        <div class="grid gap-4 py-4" v-if="selectedUser">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="name" class="text-right">Naam</Label>
                                <Input 
                                    id="name" 
                                    v-model="selectedUser.name" 
                                    class="col-span-3" 
                                />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="email" class="text-right">E-mail</Label>
                                <Input 
                                    id="email" 
                                    v-model="selectedUser.email" 
                                    type="email"
                                    class="col-span-3" 
                                />
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <Button variant="outline" @click="isDialogOpen = false">
                                Annuleren
                            </Button>
                            <Button @click="saveUser">
                                Opslaan
                            </Button>
                        </div>
                    </DialogContent>
                </Dialog>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
