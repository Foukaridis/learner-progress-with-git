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
                        class="flex flex-wrap justify-center gap-4">
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

                        @if(request()->anyFilled(['course_id', 'sort']))
                            <a href="{{ route('learner-progress') }}"
                                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">Clear
                                all</a>
                        @endif
                    </form>
                </div>
            </header>

            <div class="grid gap-6 md:grid-cols-2">
                @forelse($learners as $learner)
                    <div class="bg-white/70 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/50">
                        <div class="flex items-center gap-4 mb-6">
                            <div
                                class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($learner->firstname, 0, 1) }}{{ substr($learner->lastname, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $learner->firstname }}
                                    {{ $learner->lastname }}
                                </h2>
                                <p class="text-sm text-gray-500">{{ $learner->enrolments->count() }} enrolled
                                    {{ $learner->enrolments->count() === 1 ? 'course' : 'courses' }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach($learner->enrolments as $enrolment)
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold text-gray-700">{{ $enrolment->course->name }}</span>
                                        <span class="text-sm font-bold text-indigo-600">
                                            {{ number_format($enrolment->progress, 0) }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-full rounded-full bg-indigo-600"
                                            style="width: {{ $enrolment->progress }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-gray-500">No learners found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>

</html>