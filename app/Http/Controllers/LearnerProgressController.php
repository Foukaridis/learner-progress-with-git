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
        $learners = Learner::with(['enrolments.course'])->get();

        return view('learner-progress', [
            'learners' => $learners,
        ]);
    }
}
