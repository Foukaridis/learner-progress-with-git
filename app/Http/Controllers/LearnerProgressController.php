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
        $courses = Course::orderBy('name')->get();

        $query = Learner::with(['enrolments.course']);

        if ($request->filled('course_id')) {
            $query->whereHas('enrolments', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        $learners = $query->get();

        return view('learner-progress', [
            'learners' => $learners,
            'courses' => $courses,
        ]);
    }
}
