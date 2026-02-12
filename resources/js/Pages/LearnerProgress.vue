<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';

// The route helper is provided globally by @routes and ZiggyVue plugin

const props = defineProps({
    learners: Array,
    courses: Array,
    filters: Object,
});

const courseId = ref(props.filters.course_id || '');
const sort = ref(props.filters.sort || '');
const view = ref(props.filters.view || 'card');

const updateFilters = () => {
    router.get(route('learner-progress'), {
        course_id: courseId.value,
        sort: sort.value,
        view: view.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    courseId.value = '';
    sort.value = '';
    updateFilters();
};

const setView = (v) => {
    view.value = v;
    updateFilters();
};

const getInitials = (firstname, lastname) => {
    return `${firstname.charAt(0)}${lastname.charAt(0)}`.toUpperCase();
};

const formatProgress = (progress) => {
    return progress !== null ? Math.round(progress) + '%' : 'N/A';
};
</script>

<template>
    <Head title="Learner Progress Dashboard" />

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
        <div class="max-w-5xl mx-auto">
            <header class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Learner Progress Dashboard</h1>
                <p class="mt-2 text-lg text-gray-600">Overview of student performance and course completion.</p>

                <div class="mt-8 flex justify-center gap-4">
                    <div class="flex flex-wrap justify-center gap-4 items-center">
                        <select 
                            v-model="courseId" 
                            @change="updateFilters"
                            class="block rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 bg-white/70 backdrop-blur-md"
                        >
                            <option value="">All Courses</option>
                            <option v-for="course in courses" :key="course.id" :value="course.id">
                                {{ course.name }}
                            </option>
                        </select>

                        <select 
                            v-model="sort" 
                            @change="updateFilters"
                            class="block rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 bg-white/70 backdrop-blur-md"
                        >
                            <option value="">Default Sort</option>
                            <option value="desc">Highest Progress</option>
                            <option value="asc">Lowest Progress</option>
                        </select>

                        <button 
                            v-if="courseId || sort"
                            @click="clearFilters"
                            class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Clear all
                        </button>

                        <div class="flex items-center bg-gray-200/50 rounded-xl p-1 ml-4 shadow-inner">
                            <button 
                                @click="setView('card')"
                                :class="[
                                    'p-2 rounded-lg transition-all',
                                    view === 'card' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-500 hover:text-gray-700'
                                ]"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button 
                                @click="setView('table')"
                                :class="[
                                    'p-2 rounded-lg transition-all',
                                    view === 'table' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-500 hover:text-gray-700'
                                ]"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Table View -->
            <div v-if="view === 'table'" class="bg-white/70 backdrop-blur-md rounded-2xl shadow-sm border border-white/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Learner</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Enrolled Courses</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Progress Details</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="learner in learners" :key="learner.id" class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs ring-2 ring-indigo-50">
                                            {{ getInitials(learner.firstname, learner.lastname) }}
                                        </div>
                                        <div class="text-sm font-bold text-gray-900">{{ learner.firstname }} {{ learner.lastname }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 bg-gray-100 rounded-lg text-xs font-semibold">
                                        {{ learner.enrolments.length }} {{ learner.enrolments.length === 1 ? 'Course' : 'Courses' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-4">
                                        <div v-for="enrolment in learner.enrolments" :key="enrolment.id" class="grid grid-cols-[140px_100px_40px] items-center gap-4">
                                            <span class="text-[10px] uppercase tracking-wide font-bold text-gray-400 truncate" :title="enrolment.course.name">
                                                {{ enrolment.course.name }}
                                            </span>
                                            <div class="bg-gray-200 rounded-full h-1 overflow-hidden">
                                                <div 
                                                    class="h-full rounded-full bg-indigo-500"
                                                    :style="{ width: (enrolment.progress || 0) + '%' }"
                                                ></div>
                                            </div>
                                            <span 
                                                class="text-xs font-bold text-right"
                                                :class="enrolment.progress !== null ? 'text-indigo-600' : 'text-gray-400'"
                                            >
                                                {{ formatProgress(enrolment.progress) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="learners.length === 0">
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500 font-medium italic">
                                    No learners found matching the criteria.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card View -->
            <div v-else class="grid gap-6 md:grid-cols-2">
                <div 
                    v-for="learner in learners" 
                    :key="learner.id"
                    class="bg-white/70 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/50 hover:shadow-md transition-shadow"
                >
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl ring-4 ring-indigo-50">
                            {{ getInitials(learner.firstname, learner.lastname) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ learner.firstname }} {{ learner.lastname }}</h2>
                            <p class="text-sm text-gray-500 font-medium">
                                {{ learner.enrolments.length }} enrolled {{ learner.enrolments.length === 1 ? 'course' : 'courses' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div v-for="enrolment in learner.enrolments" :key="enrolment.id" class="bg-gray-50/50 rounded-xl p-4 border border-gray-100/50">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-700 text-sm">{{ enrolment.course.name }}</span>
                                <span 
                                    class="text-sm font-bold"
                                    :class="enrolment.progress !== null ? 'text-indigo-600' : 'text-gray-400'"
                                >
                                    {{ enrolment.progress !== null ? Math.round(enrolment.progress) + '%' : 'Not started' }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 shadow-inner">
                                <div 
                                    class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 transition-all duration-500"
                                    :style="{ width: (enrolment.progress || 0) + '%' }"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="learners.length === 0" class="col-span-full py-20 text-center bg-white/50 backdrop-blur-sm rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500 font-medium">No learners found matching the criteria.</p>
                </div>
            </div>
        </div>
    </div>
</template>
