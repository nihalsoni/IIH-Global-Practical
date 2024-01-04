<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Skill;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $students = Student::all();
        return view('student.index');
        // return response()->json($students);
    }
    public function get_students(){
        $students = Student::with(['state','city'])->where('user_id',auth()->user()->id)->get();
        return response()->json($students);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dob' => 'required',
            'gender' => 'required',
            'skills' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);
        // dd($request->all());
        $student = new Student();
        $student->user_id=auth()->user()->id;
        $student->first_name=$request->firstname;
        $student->last_name=$request->lastname;
        $student->dob=$request->dob;
        $student->gender=$request->gender;
        if(isset($request->skills) && !empty($request->skills)){$student->skills=json_encode($request->skills,true);}else{$student->skills=json_encode([],true);}
        $student->state=$request->state;
        $student->city=$request->city;
        $student->save();

        return response()->json(['success' => 'Student added successfully']);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if(!empty($student)){
            if(isset($request->firstname) && !empty($request->firstname)){$student->first_name=$request->firstname;}
            if(isset($request->lastname) && !empty($request->lastname)){$student->last_name=$request->lastname;}
            if(isset($request->dob) && !empty($request->dob)){$student->dob=$request->dob;}
            if(isset($request->gender) && !empty($request->gender)){$student->gender=$request->gender;}
            if(isset($request->skills) && !empty($request->skills)){$student->skills=json_encode($request->skills,true);}
            if(isset($request->state) && !empty($request->state)){$student->state=$request->state;}
            if(isset($request->city) && !empty($request->city)){$student->city=$request->city;}
            $student->save();
        }

        return response()->json(['success' => 'Student updated successfully']);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();

        return response()->json(['success' => 'Student deleted successfully']);
    }
    public function skills(){
        $skills=Skill::all();
        return response()->json($skills);
    }
    public function states(){
        $states=State::all();
        return response()->json($states);
    }
    public function city($id){
        $cities = City::where('state_id', $id)->get();
        return response()->json($cities);
    }
}
