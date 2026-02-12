<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Learner;
use Illuminate\Http\Request;

class LearnerProgressController extends Controller
{
    /**
     * Display the learner progress dashboard.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'sort' => 'nullable|in:asc,desc',
            'view' => 'nullable|in:card,table',
        ]);

        $courses = Course::orderBy('name')->get();

        $query = Learner::with(['enrolments.course']);

        if ($request->filled('course_id')) {
            $query->whereHas('enrolments', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        $learners = $query->get();

        if ($request->filled('sort')) {
            $learners = $learners->sortBy(function ($learner) use ($request) {
                if ($request->filled('course_id')) {
                    $enrolment = $learner->enrolments->where('course_id', $request->course_id)->first();
                    return $enrolment ? (float) $enrolment->progress : 0;
                }
                return (float) $learner->enrolments->avg('progress');
            }, SORT_REGULAR, $request->sort === 'desc')->values();
        }

        return \Inertia\Inertia::render('LearnerProgress', [
            'learners' => $learners,
            'courses' => $courses,
            'filters' => $request->only(['course_id', 'sort', 'view']),
        ]);
    }
}
