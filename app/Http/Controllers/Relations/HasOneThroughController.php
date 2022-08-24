<?php

namespace App\Http\Controllers\Relations;

use App\Http\Controllers\Controller;
use App\Models\Patient;

class HasOneThroughController extends Controller
{
    public function getPatientDoctor()
    {
        $patient = Patient::find(2);
        return $patient->doctor;
    }
}
