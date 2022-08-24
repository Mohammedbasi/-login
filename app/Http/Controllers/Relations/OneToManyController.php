<?php

namespace App\Http\Controllers\Relations;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Hospital;

class OneToManyController extends Controller
{
    public function getHospitalDoctors()
    {
        $hospital = Hospital::find(4);
        // return $hospital->doctors; return hospital doctors
        $hospital = Hospital::with('doctors')->find(1);
//        return $hospital->name;
        $doctors = $hospital->doctors;
        foreach ($doctors as $doctor) {
            echo $doctor->name . "<br>";
        }
    }

    public function hospitals()
    {
        $hospitals = Hospital::select('id', 'name', 'address')->get();
        return view('relations.hospitals', compact('hospitals'));
    }

    public function doctors($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        $doctors = $hospital->doctors;
        return view('relations.doctors', compact('doctors'));
    }

    public function HospitalHasDoctors()
    {
        return Hospital::whereHas('doctors')->get();
    }

    public function HospitalHasMale()
    {
        return Hospital::with('doctors')->whereHas('doctors', function ($q) {
            $q->where('gender', 1);
        })->get();
    }

    public function HospitalNotHasDoctors()
    {
        return Hospital::whereDoesntHave('doctors')->get();
    }

    public function deleteHospital($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        if (!$hospital)
            return abort('404');
        // delete the children (doctors) at the first
        $hospital->doctors()->delete();
        // delete the hospital at the second
        $hospital->delete();
        return redirect()->back();
    }
}
