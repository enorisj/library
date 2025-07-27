<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const props = defineProps({
  books: { type: Object },
  flash: { type: Object }
});
const text_message = ref('');
const form = useForm({ id:'',tilte:''});
const v = ref({ id:'',tilte:''});
const showModalDelete = ref(false);
const message = ref((props.flash.success != null)? props.flash.success :'');
const class_message = ref((props.flash.success != null)? '' :'hidden');

const openModalDelete = (book) =>{
    v.value.id = book.id;
    v.value.title = book.title;
    showModalDelete.value = true;
}
const closeModalDelete = () =>{
    showModalDelete.value = false;

}
const deleteBook = (id_book) =>{
  form.delete(route('books.destroy',id_book), {onSuccess: ()=>{successResponse('Book has been deleted succesfully')}})
}
const successResponse = (message) => {


text_message.value = message;
class_message.value = 'block'
closeModalDelete();
form.reset();
setTimeout(() => {
  class_message.value = 'hidden'
}, 5000)

}
</script>
<template>

    <Head title="Books" />

    <AuthenticatedLayout>
    <template #header>
      Books

    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">
      <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="class_message">
        <div class="flex justify-center items-center w-12 bg-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
          </svg>

        </div>

        <div class="px-4 py-2 -mx-3">
          <div class="mx-3">
            <span class="font-semibold text-blue-500" :style="'bg-gree-500'">Success</span>
            <p class="text-sm text-gray-600">{{ text_message }}</p>
          </div>
        </div>
      </div>
      <div class="w-full overflow-hiddenborder shadow-md">
        <div class="w-full overflow-x-auto bg-white">
          <table class="w-full whitespsce-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-100 dark:bg-purple-800">
                <th class="px-4 py-3">#header</th>
                <th class="px-4 py-3">ISBN</th>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Image</th>
                <th class="px-4 py-3">Actions</th>

              </tr>
            </thead>   
            <tbody>
              <tr v-for="book, index in books.data" :key="book.id" class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  {{ index + 1 }}
                </td>
                  <td class="px-4 py-3 text-sm">
                  {{ book.isbn }} 
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ book.title }} 
                </td>
                <td class="px-4 py-3 text-xs">
              <img :src="'storage'+'/'+book.image" width="50">
                </td>

                <td class="px-4 py-3 text-sm">
                  <NavLink :href="route('books.show',book.id)">
                    <SecondaryButton  >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                      <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                      <path fill-rule="evenodd"
                        d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                        clip-rule="evenodd" />
                    </svg>

                  </SecondaryButton>
          
                  </NavLink>
                </td>
                <td>
                  <NavLink :href="route('books.edit',book.id)">
                    <WarningButton>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                      <path
                        d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                      <path
                        d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                    </svg>

                  </WarningButton>
                  </NavLink>
                </td>
                  <td class="px-4 py-3 text-sm">
                  <DangerButton @click="openModalDelete(book)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                      <path fill-rule="evenodd"
                        d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z"
                        clip-rule="evenodd" />
                    </svg>

                  </DangerButton>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div
					class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<pagination :links="books.links" />
				</div>
      </div>

    </div>
   
 
    <Modal :show="showModalDelete" @close="closeModalDelete">
      <div class="p-6 items-center rounded-md border border-gray-300 bg-white px-4 py-2">
        <p class="text-2lg font-medium text-gray-900">
          Are you sure want delete the book? <span class="text-lg font-medium text-gray-900">{{ v.title }} </span>
        </p>
    
        <PrimaryButton @click="deleteBook(v.id)" class="mt-6 inline-flex  items-center justify-end bg-red-500">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
          </svg>

          Delete
        </PrimaryButton>
      </div>
      <div class="m-6 flex justify-end">
        <SecondaryButton @click="closeModalDelete">Cancel</SecondaryButton>
      </div>

    </Modal>
  </AuthenticatedLayout>
</template>