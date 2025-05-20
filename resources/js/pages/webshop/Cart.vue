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
const openModal = ()=>{
  modalOpen.value = true;
}

const form = useForm({
    products: new Array(),
    trainings: new Array(),
    totalPrice: 0,
    country: '',
    city: '',
    street: '',
    houseNumber: 0,
    postalCode: '',
});

let shippingCost = 4.95;
let totalTax = props.taxProduct + props.taxTraining;
let total = props.subtotalPrice + totalTax + shippingCost;

const submit = () => {
    form.products = props.products;
    form.trainings = props.trainings;
    form.totalPrice = total;
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
          <form @submit.prevent="deleteAllItems">
            <Button variant="destructive">Leeg Winkelwagen</Button>
             <!-- <div> -->
               <!-- <Link :href="route('cart.delete')" variant="destructive">Leeg Winkelwagen</Link> -->
              <!-- </div> -->
          </form>
  <form class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <div class="mx-auto max-w-3xl">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text- text-center">Winkelwagen</h2>
<!-- <div class="mt-6 space-y-4 border-b border-t border-gray-200 py-8 dark:border-gray-700 sm:mt-8">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Billing & Delivery information</h4>

        <dl>
          <dt class="text-base font-medium text-gray-900 dark:text-white">Individual</dt>
          <dd class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">Bonnie Green - +1 234 567 890, San Francisco, California, United States, 3454, Scott Street</dd>
        </dl>

        <button type="button" data-modal-target="billingInformationModal" data-modal-toggle="billingInformationModal" class="text-base font-medium text-primary-700 hover:underline dark:text-primary-500">Edit</button>
      </div> -->

      <div class="mt-6 sm:mt-8">
        <div class="relative overflow-x-auto border-b border-gray-200 dark:border-gray-800">
          <table class="w-full text-left font-medium text-gray-900 dark:text-white md:table-fixed">
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                <!-- products -->
                    <tr v-for="product in props.products" :key="product.id">
                        <td class="whitespace-nowrap py-4 md:w-[384px]">
                  <div class="flex items-center gap-4">
                    <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                      <img class="h-auto w-full max-h-full dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="imac image" />
                      <!-- image -->
                      <img class="hidden h-auto w-full max-h-full dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="imac image" />
                    </a>
                    <!-- name -->
                    <a :href="route('webshop.show', product.id)" class="hover:underline">{{ product.name }}</a>
                  </div>
                </td>
                
                <!-- amount -->
                <td class="p-4 text-base font-normal text-gray-900 dark:text-white">Aantal: {{ product.amount }}</td>
                
                <!-- price -->
                <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">Prijs: €{{ product.price.toFixed(2) }}</td>
                
                <!-- Delete -->
                <!-- <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">
                  
                    <Button @click="deleteItem" variant="destructive">
                      <Icon name="Trash2" />
                    </Button>    
               
                </td> -->
            </tr>
                <!-- </div> -->
        <!-- trainings -->
                <!-- <div v-for="training in props.trainings" :key="training.id"> -->

                    <tr v-for="training in props.trainings" :key="training.id">
                    
                        <td class="whitespace-nowrap py-4 md:w-[384px]">
                  <div class="flex items-center gap-4">
                    <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                      <img class="h-auto w-full max-h-full dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg" alt="imac image" />
                      <!-- image -->
                      <img class="hidden h-auto w-full max-h-full dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="imac image" />
                    </a>
                    <!-- title   -->
                    <a href="#" class="hover:underline"><u><b>{{ training.title }}</b></u></a>
                  </div>
                  </td>
                
                <!-- amount -->
                <td class="p-4 text-base font-normal text-gray-900 dark:text-white">Aantal: 1</td>
                
                <!-- price -->
                <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">Prijs: €{{ training.price.toFixed(2) }}</td>
                
              <!-- Delete -->
                <!-- <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">
                   
                    <Button @click="deleteItem" variant="destructive">
                      <Icon name="Trash2" />
                    </Button>    
                  
                </td> -->
              </tr>
                <!-- </div> -->
           </tbody>
          </table>
        </div>

        <div class="mt-4 space-y-6">
          <!-- <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</h4> -->

          <div class="space-y-4">
            <div class="space-y-2">

              <!-- subtotal -->
              <dl class="flex items-center justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Subtotaal</dt>
                <dd class="text-base font-medium text-gray-900 dark:text-white">€{{ subtotalPrice.toFixed(2) }}</dd>
              </dl>

              
                <!-- TAX -->
              <dl class="flex items-center justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">BTW: </dt>
                <dd class="text-base font-medium text-gray-900 dark:text-white">€{{ totalTax.toFixed(2) }}</dd>
              </dl> 
              
                <!-- shipping -->
              <dl class="flex items-center justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Verzendkosten</dt>
                <dd class="text-base font-medium text-gray-900 dark:text-white">€{{ shippingCost.toFixed(2) }}</dd>
              </dl> 
            </div>
                <!-- total -->
            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
              <dt class="text-lg font-bold text-gray-900 dark:text-white">Total</dt>
              <dd class="text-lg font-bold text-gray-900 dark:text-white">€{{ total.toFixed(2) }}</dd>
            </dl>
          </div>

          <div class="flex items-start sm:items-center">
            <!-- <input id="terms-checkbox-2" type="checkbox" value="" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary-600 focus:ring-2 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" /> -->
            <!-- <label for="terms-checkbox-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"> I agree with the <a href="#" title="" class="text-primary-700 underline hover:no-underline dark:text-primary-500">Terms and Conditions</a> of use of the Flowbite marketplace </label> -->
          </div>

        </div>
      </div>
    </div>
  </form>
  <div class="gap-4 sm:flex sm:items-center">
      <Button v-on:click="route('webshop.index')" >Return to Shopping</Button> <!-- fix this route -->
      <Button @click="openModal()">Send the order</Button>
  </div>
</section>

<!-- modal -->
 <Dialog v-modal:open="openModal">
  <DialogContent class="sm:max-w-[425px]">
    <DialogHeader>
      <DialogTitle>Adres informatie</DialogTitle>
      <DialogDescription>
        Vul hier uw adresgegevens in voor verzending. Druk op order wanneer u klaar bent.
      </DialogDescription>
    </DialogHeader>
    <form @submit.prevent="submit()">
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
            <Label for="name" class="text-right"> Land </Label>
            <Input class="col-span-3" v-model="form.country" />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
            <Label for="name" class="text-right"> Stad </Label>
            <Input class="col-span-3" v-model="form.city" />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
            <Label for="username" class="text-right"> Straat </Label>
            <Input class="col-span-3" v-model="form.street" />
          </div>
          <div class="grid grid-cols-4 items-center gap-4">
            <Label for="name" class="text-right"> Huisnummer </Label>
            <Input class="col-span-3" v-model="form.houseNumber" type="number" />
          </div>
          <div class="grid grid-cols-4 items-center gap-4">
            <Label for="media" class="text-right"> Postcode </Label>
            <Input class="col-span-3" v-model="form.postalCode" />
        </div>
      </div>
    <DialogFooter>
            <Button type="submit"> Bestel </Button>
    </DialogFooter>
     </form>
  </DialogContent>
</Dialog>
     <Footer/>
    </AppLayout>
</template>
