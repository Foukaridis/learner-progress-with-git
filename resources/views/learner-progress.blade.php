<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learner Progress Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="antialiased text-gray-900">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <header class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Learner Progress Dashboard</h1>
                <p class="mt-2 text-lg text-gray-600">Overview of student performance and course completion.</p>

                <div class="mt-8 flex justify-center gap-4">
                    <form action="{{ route('learner-progress') }}" method="GET"
                        class="flex flex-wrap justify-center gap-4 items-center">
                        <select name="course_id" onchange="this.form.submit()"
                            class="block rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 bg-white/70 backdrop-blur-md">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="sort" onchange="this.form.submit()"
                            class="block rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 bg-white/70 backdrop-blur-md">
                            <option value="">Default Sort</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Highest Progress
                            </option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Lowest Progress</option>
                        </select>

                        @if(request()->anyFilled(['course_id', 'sort', 'view']))
                            <a href="{{ route('learner-progress') }}"
                                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">Clear
                                all</a>
                        @endif

                        <div class="flex items-center bg-gray-200/50 rounded-xl p-1 ml-4 shadow-inner">
                            <button type="submit" name="view" value="card"
                                class="p-2 rounded-lg transition-all {{ request('view', 'card') === 'card' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                            </button>
                            <button type="submit" name="view" value="table"
                                class="p-2 rounded-lg transition-all {{ request('view') === 'table' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </header>

            @if(request('view') === 'table')
                <div class="bg-white/70 backdrop-blur-md rounded-2xl shadow-sm border border-white/50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Learner</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Enrolled Courses</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Progress Details</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($learners as $learner)
                                    <tr class="hover:bg-gray-50/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs ring-2 ring-indigo-50">
                                                    {{ substr($learner->firstname, 0, 1) }}{{ substr($learner->lastname, 0, 1) }}
                                                </div>
                                                <div class="text-sm font-bold text-gray-900">{{ $learner->firstname }}
                                                    {{ $learner->lastname }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="px-2 py-1 bg-gray-100 rounded-lg text-xs font-semibold">{{ $learner->enrolments->count() }}
                                                {{ $learner->enrolments->count() === 1 ? 'Course' : 'Courses' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-4">
                                                @foreach($learner->enrolments as $enrolment)
                                                    <div class="grid grid-cols-[140px_100px_40px] items-center gap-4">
                                                        <span
                                                            class="text-[10px] uppercase tracking-wide font-bold text-gray-400 truncate" title="{{ $enrolment->course->name }}">{{ $enrolment->course->name }}</span>
                                                        <div
                                                            class="bg-gray-200 rounded-full h-1 overflow-hidden">
                                                            <div class="h-full rounded-full bg-indigo-500"
                                                                style="width: {{ $enrolment->progress }}%"></div>
                                                        </div>
                                                        <span
                                                            class="text-xs font-bold text-indigo-600 text-right">{{ number_format($enrolment->progress, 0) }}%</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-500 font-medium italic">No
                                            learners found matching the criteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2">
                    @forelse($learners as $learner)
                        <div
                            class="bg-white/70 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/50 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl ring-4 ring-indigo-50">
                                    {{ substr($learner->firstname, 0, 1) }}{{ substr($learner->lastname, 0, 1) }}
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">{{ $learner->firstname }}
                                        {{ $learner->lastname }}
                                    </h2>
                                    <p class="text-sm text-gray-500 font-medium">{{ $learner->enrolments->count() }} enrolled
                                        {{ $learner->enrolments->count() === 1 ? 'course' : 'courses' }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @foreach($learner->enrolments as $enrolment)
                                    <div class="bg-gray-50/50 rounded-xl p-4 border border-gray-100/50">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-semibold text-gray-700 text-sm">{{ $enrolment->course->name }}</span>
                                            <span class="text-sm font-bold text-indigo-600">
                                                {{ number_format($enrolment->progress, 0) }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 shadow-inner">
                                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 transition-all duration-500"
                                                style="width: {{ $enrolment->progress }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full py-20 text-center bg-white/50 backdrop-blur-sm rounded-2xl border border-dashed border-gray-300">
                            <p class="text-gray-500 font-medium">No learners found matching the criteria.</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</body>

</html>