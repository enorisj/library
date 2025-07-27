<template>
    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400 mt-6">
        <select
            class="rounded block w-full pl-10 mt-1 text-sm text-black  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple focus:shadow-outline-gray form-input"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input" :placeholder="text"
            :required="required">
            
            <option value="" selected> {{ text }} </option>
            <option v-for="option_value in  options" :key="option_value.id" :value="option_value.id">
                
                {{ option_value.country }} </option>
        </select>
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue', 'text', 'options', 'required',]);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>