<?php

namespace App\Http\Controllers\Relations;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\Request;

class ManyToManyController extends Controller
{
    public function getDoctorServices()
    {
        $doctor = Doctor::with('services')->find(5);

        //return $doctor->name;
        //return $doctor->services;
    }

    public function getServiceDoctors()
    {
        return $doctors = Service::with(['doctors' => function ($q) {
            $q->select('doctors.id', 'name', 'title');
        }])->find(1);
    }

    public function DoctorServices($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        $services = $doctor->services;
        $doctors = Doctor::select('id', 'name')->get();
        $allServices = Service::select('id', 'name')->get();
        return view('relations.services', compact('services', 'doctors', 'allServices'));
    }

    public function saveServicesToDoctor(Request $request)
    {
        $doctor = Doctor::find($request->doctor_id);
        if (!$doctor)
            return abort('404');
        //$doctor->services()->attach($request->service_id);
        //$doctor->services()->sync($request->service_id); // حذف القديم واضافة الجديد
        $doctor->services()->syncWithoutDetaching($request->service_id); //اضافة الجديد مع بقاء القديم
        return 'success';
    }
}
