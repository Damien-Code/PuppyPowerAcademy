<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Product, type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Footer from '@/components/Footer.vue';
import Button from '@/components/ui/button/Button.vue';
import {
  Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle
} from '@/components/ui/dialog';
import { ref } from 'vue';
import DialogTrigger from '@/components/ui/dialog/DialogTrigger.vue';
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
  trainings: TrainingCategory[]
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
  products: [],
  trainings: [],
  total_price: 0,
  country: '',
  city: '',
  street: '',
  house_number: 0,
  postal_code: '',
});

const shippingCost = 4.95;
const totalTax = props.taxProduct + props.taxTraining;
const total = props.subtotalPrice + totalTax + shippingCost;

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
    <section class="bg-white rounded-lg w-fit m-auto antialiased p-4">
    <div v-if="props.trainings.length > 0 || props.products.length > 0">
        <form @submit.prevent="deleteAllItems" class="pb-4">
          <Button variant="destructive" class="cursor-pointer flex mx-auto md:mr-auto md:ml-0">Leeg Winkelwagen</Button>
        </form>
      </div>
      <form class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mx-auto max-w-3xl">
          <h2 class="text-xl font-semibold text-gray-900 text-center">Winkelwagen</h2>

          <div class="mt-6 sm:mt-8">
            <div class="relative overflow-x-auto border-b border-gray-200">
              <table class="w-full text-left font-medium text-gray-900 md:table-fixed">
                <tbody class="divide-y divide-gray-200">
                  <div v-if="props.trainings.length == 0 && props.products.length == 0">Uw winkelwagen is leeg</div>
                  <!-- products -->
                  <tr v-for="product in props.products" :key="product.id">
                    <td class="whitespace-nowrap py-4 md:w-[384px]">
                      <div class="flex items-center gap-4">
                        <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                          <img class="h-auto w-full max-h-full"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="imac image" />
                          <!-- image -->
                          <img class="hidden h-auto w-full max-h-full"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"
                            alt="imac image" />
                        </a>
                        <!-- name -->
                        <a :href="route('webshop.show', product.id)" class="hover:underline">{{ product.name }}</a>
                      </div>
                    </td>

                    <!-- amount -->
                    <td class="p-4 text-base font-normal text-gray-900">Aantal: {{ product.amount }}
                    </td>

                    <!-- price -->
                    <td class="p-4 text-right text-base font-bold text-gray-900">Prijs: €{{
                      product.price.toFixed(2) }}</td>
                  </tr>
                  <!-- trainings -->
                  <tr v-for="training in props.trainings" :key="training.id">

                    <td class="whitespace-nowrap py-4 md:w-[384px]">
                      <div class="flex items-center gap-4">
                        <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                          <img class="h-auto w-full max-h-full"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="imac image" />
                          <!-- image -->
                          <img class="hidden h-auto w-full max-h-full"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"
                            alt="imac image" />
                        </a>
                        <!-- title   -->
                        <a href="/training" class="hover:underline"><u><b>{{ training.name }}</b></u></a>
                      </div>
                    </td>

                    <!-- amount -->
                    <td class="p-4 text-base font-normal text-gray-900">Aantal: 1</td>

                    <!-- price -->
                    <td class="p-4 text-right text-base font-bold text-gray-900">Prijs: €{{
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
                      <dt class="text-gray-500">Subtotaal</dt>
                      <dd class="text-base font-medium text-gray-900">€{{ subtotalPrice.toFixed(2) }}
                      </dd>
                    </dl>


                    <!-- TAX -->
                    <dl class="flex items-center justify-between gap-4">
                      <dt class="text-gray-500">BTW: </dt>
                      <dd class="text-base font-medium text-gray-900">€{{ totalTax.toFixed(2) }}</dd>
                    </dl>

                    <!-- shipping -->
                    <dl class="flex items-center justify-between gap-4">
                      <dt class="text-gray-500">Verzendkosten</dt>
                      <dd class="text-base font-medium text-gray-900">€{{ shippingCost.toFixed(2) }}
                      </dd>
                    </dl>
                  </div>
                  <!-- total -->
                  <dl
                    class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2">
                    <dt class="text-lg font-bold text-gray-900">Totaal</dt>
                    <dd class="text-lg font-bold text-gray-900">€{{ total.toFixed(2) }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="flex justify-between pt-4 sm:items-center">
        <Button @click="$inertia.visit(route('webshop.index'))" class="cursor-pointer">Terug naar webshop</Button>
        <div v-if="props.trainings.length > 0 || props.products.length > 0">

          <!-- modal -->
          <Dialog v-modal:open="openModal">
            <DialogTrigger>
              <Button @click="openModal()" class="cursor-pointer">Bestel</Button>
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
