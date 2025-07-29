<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import select2 from 'select2';
select2();
//import $ from 'jquery'
//window.$ = $

import Select2 from 'vue3-select2-component';


const props = defineProps({
    book: { type: Object },
    authors: { type: Object },
    authorsOfBook: { type: Object }
});
const form = useForm({
    id: '', isbn: '', title: '', description: '', publisher: '', release_date: '', pages: '', image: '', authors: []

});
const title_form = ref((props.book == null) ? 'Create Book' : 'Edit Book')
const req = ref('required');
const srcImg = ref('../../storage/img/example.png')
const text_message = ref('');
const class_message = ref('hidden');
const options = ref([]);
props.authors.map((row)=>(
     options.value.push({'id': row.id, 'text': row.last_name+ ' '+ row.name}) 
));

if(props.book != null){
    form.isbn = props.book.isbn;
    form.title = props.book.title;
    form.description = props.book.description;
    form.publisher = props.book.publisher;
    form.release_date = props.book.release_date;
    form.pages = props.book.pages;
    form.image = props.book.image;
    form.id = props.book.id;
    srcImg.value = '../../storage/'+props.book.image
    props.authorsOfBook.map((row) => (
        form.authors.push(row.id)
    ))
}
const save =()=>{
    if(props.book == null){
        form.post(route('books.store'),{
            onSuccess:()=>{ok('Book created')}
        })
    }
    else{
        form.post(route('updateBook'),{
            onSuccess:()=>{ok('Book edited')}
        }) 
    }
}

const ok =(mesj)=>{
form.reset();
text_message.value = mesj;
class_message.value = 'block';
setTimeout(()=>{
    class_message.value = 'hidden';
},8000);
}

const showImg = (e)=>{
    form.image = e.target.files[0];
    srcImg.value = URL.createObjectURL(e.target.files[0])
}
</script>
<template>

    <Head title="Books" />


    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                <NavLink href="route(books.index)">
                    <DarkButton class="mr-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>

                    </DarkButton>

                </NavLink>
                {{ title_form }}

            </div>

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
        </template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <form class="mt-6 mb-6 space-y-6 max-w-xl" @submit.prevent="save">
                    <InputGroup :text="'ISBN'" :required="'required'" v-model="form.isbn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.isbn"></InputError>
                    <InputGroup :text="'Title'" :required="'required'" v-model="form.title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>

                    </InputGroup>
                    <InputError :message="form.errors.title"></InputError>
                    <InputGroup :text="'Description'" :required="'required'" v-model="form.description">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.description"></InputError>

                    <InputGroup :text="'Publisher'" :required="'required'" v-model="form.publisher" :type="'textarea'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.publisher"></InputError>
                    <InputGroup :text="'Release date'" :required="'required'" v-model="form.release_date" :type="'date'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>


                    </InputGroup>
                    <InputError :message="form.errors.release_date"></InputError>

                    <InputGroup :text="'Pages'" :required="'required'" v-model="form.pages" :type="'number'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>


                    </InputGroup>
                    <InputError :message="form.errors.pages"></InputError>
                    <InputGroup v-if="props.book==null" :text="'Image'"   @change="showImg($event)" :required="required" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </InputGroup>
                    <InputGroup v-else :text="'Image'"    @change="showImg($event)" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.image"></InputError>
                    
                    <span class="mt-2">Add Authors</span>
                    <Select2 v-model="form.authors" :options="options" :settings="{multiple:true, width:'100%'}"
                     @change ="form.authors = $event.target.value"/>
                     <InputError :message="form.errors.authors"></InputError>

                    <PrimaryButton @click="save"> Save</PrimaryButton>
                </form>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="srcImg" width="500">
            </div>
        </div>
    </AuthenticatedLayout>

</template>