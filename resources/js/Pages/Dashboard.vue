<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,ArcElement)

import { ref } from 'vue';

const props = defineProps({
	authors: { type: Object },
	books: { type: Number },
	countries: { type: Object },
})

const data_author = ref([]);
const data_country = ref([]);
const charData1 = ref([]);
const charOption1 = ref([]);
const charData2 = ref([]);
const charOption2 = ref([]);
const data_author2 = ref([]);
const data_book = ref([]);
const colors = ref([]);

const random = () => {
	return Math.floor(Math.random() * 256)
}
//graphic1
props.countries.map((row) => (
	data_country.value.push(row.country),
	data_author.value.push(row.authors.length),
	colors.value.push('rgb(' + random() + ',' + random() + ',' + random() + ')')
));
charOption1.value = { responsive: true };
charData1.value = {
	labels: data_country.value,
	datasets: [{
		label: 'Authors', data: data_author.value, backgroundColor: colors
	}]
};
//graphic2
props.authors.map((row) => (
	data_book.value.push(row.books.length),
	data_author2.value.push(row.last_name+' '+row.name),
	colors.value.push('rgb(' + random() + ',' + random() + ',' + random() + ')')
));
charOption2.value = { responsive: true };
charData2.value = {
	labels: data_author2.value,
	datasets: [{
		label: 'Authors', data: data_book.value, backgroundColor: colors
	}]
};


</script>

<template>

	<Head title="Dashboard" />

	<AuthenticatedLayout>
		<template #header>
			Dashboard
		</template>

		<div class="p-4 bg-white rounded-lg shadow-xs">
			<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
				<!-- Card -->
				<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
					<div
						class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
						<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
							<path
								d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
							</path>
						</svg>
					</div>
					<div>
						<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
							Total authors
						</p>
						<p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
							{{ authors.length }}
						</p>
					</div>
				</div>
				<!-- Card -->
				<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
					<div
						class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
							stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
						</svg>

					</div>
					<div>
						<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
							Total books
						</p>
						<p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
							{{ books }}
						</p>
					</div>
				</div>
				<!-- Card -->
				<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
					<div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
							stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
						</svg>

					</div>
					<div>
						<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
							Total country
						</p>
						<p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
							{{ countries.length }}
						</p>
					</div>
				</div>
			</div>
			<div class=" grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
				<div class="min-w-0 p-4 rounded-lg shadow-xs">
					<span class="text-lg p-4">Authors by country</span>
					<div class=" flex items-center">
						<Bar :data="charData1" :options="charOption1"></Bar>

					</div>

				</div>
				<div class="min-w-0 p-4 rounded-lg shadow-xs">
						<span class="text-lg p-4">Books by authors</span>
					<div class=" flex items-center">
						<Pie :data="charData2" :options="charOption2"/>

					</div>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
