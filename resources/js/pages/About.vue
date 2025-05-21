<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Footer from '@/components/Footer.vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import { Card, CardContent } from '@/components/ui/card';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'About',
        href: '/about',
    },
];
</script>

<template>
    <Head title="About" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative  flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min p-8">
                <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Puppy Power Academy</h2>
                    <p class="mb-4">We are strategists, designers and developers. Innovators and problem solvers. Small enough to be simple and quick, but big enough to deliver the scope you want at the pace you need. Small enough to be simple and quick, but big enough to deliver the scope you want at the pace you need.</p>
                    <p>We are strategists, designers and developers. Innovators and problem solvers. Small enough to be simple and quick.</p>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min p-8 mx-auto">
                <Carousel class="relative w-full max-w-xs">
                    <CarouselContent>
                        <CarouselItem>
                            <div class="p-1">
                                <Card>
                                    <CardContent class="flex aspect-square items-center justify-center">
                                        <span class="text-4xl font-semibold"><img class="rounded-lg " src="../../../public/images/DogInBoat.png" alt="dog"></span>
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>

                        <CarouselItem>
                            <div class="p-1">
                                <Card>
                                    <CardContent class="flex aspect-square items-center justify-center">
                                        <span class="text-4xl font-semibold"><img class="rounded-lg " src="../../../public/images/DogInGrass.png" alt="dog"></span>
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>

                        <CarouselItem>
                            <div class="p-1">
                                <Card>
                                    <CardContent class="flex aspect-square items-center justify-center">
                                        <span class="text-4xl font-semibold"><img class="rounded-lg " src="../../../public/images/CrazyDog.png" alt="dog"></span>
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>

                        <CarouselItem>
                            <div class="p-1">
                                <Card>
                                    <CardContent class="flex aspect-square items-center justify-center">
                                        <span> <img class="rounded-lg " src="../../../public/images/Doggie.png" alt="dog"></span>
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                </Carousel>
            </div>
        </div>
        <Footer/>
    </AppLayout>
</template>
