<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const props = defineProps({
  authors: { type: Object },
  countries: { type: Object }
});

const form = useForm({ name: '', last_name: '', country_id: '' });
const v = ref({ id: '', name: '', last_name: '', books: [] });
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDelete = ref(false);

const title = ref('');
const operation = ref('create');
const text_message = ref('');
const class_message = ref('hidden');

const openModalView = (auhor) => {

  v.value.name = auhor.name + ' ' + auhor.last_name;
  v.value.country = auhor.country.country;
  v.value.books = auhor.books;

  showModalView.value = true
}
const openModalForm = (action, auhor) => {
  showModalForm.value = true;
  operation.value = action;
  if (operation.value == 'create') {
    title.value = "Create author";

  }
  else {
    title.value = "Edit author";
    form.name = auhor.name;
    form.last_name = auhor.last_name;
    form.country_id = auhor.country_id
    v.value.id = auhor.id
  }

}
const openModalDelete = (author) => {

  v.value.id = author.id
  v.value.name = author.name + ' ' + author.last_name
  showModalDelete.value = true;
}

const closeModalView = () => { showModalView.value = false }
const closeModalForm = () => {
  showModalForm.value = false;
  form.reset();
}
const closeModalDelete = () => { showModalDelete.value = false }

const save = () => {
  if (operation.value == 'create') {
    form.post(route('authors.store'), {
      onError: () => { },
      onSuccess: () => { successResponse('Author created') },
    })
  }
  else {
    form.put(route('authors.update', v.value.id), {
      onError: () => { },
      onSuccess: () => { successResponse('Author edited') },
    })
  }
}
const successResponse = (message) => {


  text_message.value = message;
  class_message.value = 'block'
  closeModalForm();
  closeModalView();
  closeModalDelete();
  form.reset();
  setTimeout(() => {
    class_message.value = 'hidden'
  }, 5000)

}
const deleteAuthor = (id_author) => {
  form.delete(route('authors.destroy', id_author), {
    onError: () => { },
    onSuccess: () => { successResponse('Author deleted') },
  })
}
</script>

<template>

  <Head title="Authors" />

  <AuthenticatedLayout>
    <template #header>
      Authors
      
      <DarkButton @click="openModalForm('create', author)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
        </svg>
      </DarkButton>

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
                <th class="px-4 py-3">Full Name</th>
                <th class="px-4 py-3">Country</th>
                <th class="px-4 py-3">Actions</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="author, index in authors" :key="author.id" class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  {{ index + 1 }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ author.name }} {{ author.last_name }}
                </td>
                <td class="px-4 py-3 text-xs">
                  {{ author.country.country }}
                </td>

                <td class="px-4 py-3 text-sm">
                  <SecondaryButton @click="openModalView(author)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                      <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                      <path fill-rule="evenodd"
                        d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                        clip-rule="evenodd" />
                    </svg>
                  </SecondaryButton>
                  <WarningButton @click="openModalForm('edit', author)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                      <path
                        d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                      <path
                        d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                    </svg>

                  </WarningButton>
                  <DangerButton @click="openModalDelete(author)">
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
      </div>
    </div>

    <Modal :show="showModalView" @close="closeModalView">
      <div class="p-6 items-center rounded-md border border-gray-300 bg-white px-4 py-2">
        <p> Author: <span class="text-lg font-medium text-gray-900">{{ v.name }} </span></p>
        <p> Country: <span class="text-lg font-medium text-gray-900">{{ v.country }}</span></p>
        Books:
        <ol>
          <li class="text-lg font-medium text-gray-900" v-for="book, idx in v.books">
            {{ (idx + 1) + ')' + book.title }}

          </li>
        </ol>

      </div>
      <div class="m-6 flex justify-end">
        <SecondaryButton @click="closeModalView">Cancel</SecondaryButton>
      </div>

    </Modal>
    <Modal :show="showModalForm" @close="closeModalForm">
      <div class="p-6 items-center rounded-md border border-gray-300 bg-white px-4 py-2">
        <h2 class="text-lg fond-medium text-gray-900">{{ title }}</h2>
        <div class="mt-9 mb-6 space -y-6  max-w-xl">
          <InputGroup :text="'Name'" :required="'required'" v-model:="form.name" :modelValue="v.name" :type="'text'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
          </InputGroup>
          <InputError class="mt-1" :message="form.errors.name"></InputError>

          <InputGroup :text="'Last name'" :required="'required'" v-model:="form.last_name" :modelValue="v.last_name"
            :type="'text'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
          </InputGroup>
          <InputError class="mt-1" :message="form.errors.last_name"></InputError>

          <SelectInput :text="'Country'" :options="countries" v-model="form.country_id">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
            </svg>


          </SelectInput>
          <InputError class="mt-1" :message="form.errors.country_id"></InputError>

          <PrimaryButton @click="save" class="mt-6 inline-flex flex items-center justify-end">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
            </svg>

            Save
          </PrimaryButton>

        </div>
      </div>
      <div class="m-6 flex justify-end">
        <SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
      </div>

    </Modal>
    <Modal :show="showModalDelete" @close="closeModalDelete">
      <div class="p-6 items-center rounded-md border border-gray-300 bg-white px-4 py-2">
        <p class="text-2lg font-medium text-gray-900">
          Are you sure want delete the author? <span class="text-lg font-medium text-gray-900">{{ v.name }} </span>
        </p>

        <PrimaryButton @click="deleteAuthor(v.id)" class="mt-6 inline-flex flex items-center justify-end bg-red-500">
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