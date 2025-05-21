<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Product, Training, type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import Footer from '@/components/Footer.vue';
import Button from '@/components/ui/button/Button.vue';
import { Link } from '@inertiajs/vue3';
import Icon from '@/components/Icon.vue';
import { Trash2 } from 'lucide-vue-next';
import {
  Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle
} from '@/components/ui/dialog';
import { ref } from 'vue';
import DialogTrigger from '@/components/ui/dialog/DialogTrigger.vue';
import { toast } from 'vue-sonner';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Cart',
    href: '/webshop/cart',
  },
];
interface Props {
  products: Product[]
  trainings: Training[]
  subtotalPrice: number
  taxProduct: number
  taxTraining: number
}

const props = defineProps<Props>();

//modal
const modalOpen = ref(false);
const openModal = () => {
  modalOpen.value = true;
}

const form = useForm({
  products: new Array(),
  trainings: new Array(),
  total_price: 0,
  country: '',
  city: '',
  street: '',
  house_number: 0,
  postal_code: '',
});

let shippingCost = 4.95;
let totalTax = props.taxProduct + props.taxTraining;
let total = props.subtotalPrice + totalTax + shippingCost;

const submit = () => {
  form.products = props.products;
  form.trainings = props.trainings;
  // form.country = this.country
  form.total_price = total;
  modalOpen.value = false;
  form.post(route('cart.store'), {

  })
};

const deleteAllItems = () => {
  form.delete(route('cart.destroy'))
};

</script>

<template>

  <Head title="Cart" />

  <AppLayout :breadcrumbs="breadcrumbs">

    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
      <div v-if="props.trainings.length > 0 || props.products.length > 0">
        <form @submit.prevent="deleteAllItems">
          <Button variant="destructive">Leeg Winkelwagen</Button>
        </form>
      </div>
      <form class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mx-auto max-w-3xl">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text- text-center">Winkelwagen</h2>

          <div class="mt-6 sm:mt-8">
            <div class="relative overflow-x-auto border-b border-gray-200 dark:border-gray-800">
              <table class="w-full text-left font-medium text-gray-900 dark:text-white md:table-fixed">
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                  <div v-if="props.trainings.length == 0 && props.products.length == 0">Uw winkelwagen is leeg</div>
                  <!-- products -->
                  <tr v-for="product in props.products" :key="product.id">
                    <td class="whitespace-nowrap py-4 md:w-[384px]">
                      <div class="flex items-center gap-4">
                        <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                          <img class="h-auto w-full max-h-full dark:hidden"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="imac image" />
                          <!-- image -->
                          <img class="hidden h-auto w-full max-h-full dark:block"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"
                            alt="imac image" />
                        </a>
                        <!-- name -->
                        <a :href="route('webshop.show', product.id)" class="hover:underline">{{ product.name }}</a>
                      </div>
                    </td>

                    <!-- amount -->
                    <td class="p-4 text-base font-normal text-gray-900 dark:text-white">Aantal: {{ product.amount }}
                    </td>

                    <!-- price -->
                    <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">Prijs: €{{
                      product.price.toFixed(2) }}</td>
                  </tr>
                  <!-- trainings -->
                  <tr v-for="training in props.trainings" :key="training.id">

                    <td class="whitespace-nowrap py-4 md:w-[384px]">
                      <div class="flex items-center gap-4">
                        <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                          <img class="h-auto w-full max-h-full dark:hidden"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="imac image" />
                          <!-- image -->
                          <img class="hidden h-auto w-full max-h-full dark:block"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"
                            alt="imac image" />
                        </a>
                        <!-- title   -->
                        <a href="#" class="hover:underline"><u><b>{{ training.title }}</b></u></a>
                      </div>
                    </td>

                    <!-- amount -->
                    <td class="p-4 text-base font-normal text-gray-900 dark:text-white">Aantal: 1</td>

                    <!-- price -->
                    <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">Prijs: €{{
                      training.price.toFixed(2) }}</td>

                    <!-- Delete -->

                  </tr>
                </tbody>
              </table>
            </div>
            <div v-if="props.trainings.length > 0 || props.products.length > 0">

              <div class="mt-4 space-y-6">

                <div class="space-y-4">
                  <div class="space-y-2">

                    <!-- subtotal -->
                    <dl class="flex items-center justify-between gap-4">
                      <dt class="text-gray-500 dark:text-gray-400">Subtotaal</dt>
                      <dd class="text-base font-medium text-gray-900 dark:text-white">€{{ subtotalPrice.toFixed(2) }}
                      </dd>
                    </dl>


                    <!-- TAX -->
                    <dl class="flex items-center justify-between gap-4">
                      <dt class="text-gray-500 dark:text-gray-400">BTW: </dt>
                      <dd class="text-base font-medium text-gray-900 dark:text-white">€{{ totalTax.toFixed(2) }}</dd>
                    </dl>

                    <!-- shipping -->
                    <dl class="flex items-center justify-between gap-4">
                      <dt class="text-gray-500 dark:text-gray-400">Verzendkosten</dt>
                      <dd class="text-base font-medium text-gray-900 dark:text-white">€{{ shippingCost.toFixed(2) }}
                      </dd>
                    </dl>
                  </div>
                  <!-- total -->
                  <dl
                    class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                    <dt class="text-lg font-bold text-gray-900 dark:text-white">Totaal</dt>
                    <dd class="text-lg font-bold text-gray-900 dark:text-white">€{{ total.toFixed(2) }}</dd>
                  </dl>
                </div>



              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="gap-4 sm:flex sm:items-center">
        <Button v-on:click="route('webshop.index')">Terug naar webshop</Button> <!-- fix this route -->
        <div v-if="props.trainings.length > 0 || props.products.length > 0">

          <!-- modal -->
          <Dialog v-modal:open="openModal">
            <DialogTrigger>
              <Button @click="openModal()">Bestel</Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-[425px]">
              <form @submit.prevent="submit">
                <DialogHeader>
                  <DialogTitle>Adres informatie</DialogTitle>
                  <DialogDescription>
                    Vul hier uw adresgegevens in voor verzending. Druk op Bestel wanneer u klaar bent.
                  </DialogDescription>
                </DialogHeader>

                <div class="grid gap-4 py-4">
                  <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="country" class="text-right"> Land </Label>
                    <Input class="col-span-3" type="text" v-model="form.country" />
                    <InputError class="col-span-3" :message="form.errors.country" />
                  </div>
                  <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="name" class="text-right"> Stad </Label>
                    <Input class="col-span-3" type="text" v-model="form.city" />
                    <InputError class="col-span-3" :message="form.errors.city" />
                  </div>
                  <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="username" class="text-right"> Straat </Label>
                    <Input class="col-span-3" type="text" v-model="form.street" />
                    <InputError class="col-span-3" :message="form.errors.street" />
                  </div>
                  <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="name" class="text-right"> Huisnummer </Label>
                    <Input class="col-span-3" v-model="form.house_number" type="number" />
                    <InputError class="col-span-3" :message="form.errors.house_number" />
                  </div>
                  <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="media" class="text-right"> Postcode </Label>
                    <Input class="col-span-3" type="text" v-model="form.postal_code" />
                    <InputError class="col-span-3" :message="form.errors.postal_code" />
                  </div>
                </div>
                <DialogFooter>
                  <Button type="submit"> Bestel </Button>
                </DialogFooter>
              </form>
            </DialogContent>

          </Dialog>
        </div>
      </div>
    </section>
    <Footer />
  </AppLayout>
</template>
