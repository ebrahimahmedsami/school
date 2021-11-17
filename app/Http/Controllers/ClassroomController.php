<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classrooms = Classroom::all();
        $grades = Grade::all();
        return view('classrooms.classrooms',compact('classrooms','grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $this->validate($request,[
                'List_Classes.*.name' => 'required',
                'List_Classes.*.name_en' => 'required',
            ]);
            foreach ($request->List_Classes as $list){
                $class= new Classroom();
                $class->name = ['en' => $list['name_en'], 'ar' => $list['name']];
                $class->grade_id = $list['grade_id'];
                $class->save();
            }

            toastr()->success('Saved Successfully!', 'Classes Saved');
            return redirect()->route('classrooms.index');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class_data = Classroom::findOrFail($id);
        if($class_data){
            return response()->json(['status' => true, 'data' => $class_data]);
        }
        return response()->json(['status' => false, 'data' => '']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $class_data = Classroom::findOrFail($id);
        if($class_data){
            $class_data->update([
                $class_data->name = ['ar' => $request->name_edit, 'en' => $request->name_en_edit],
                $class_data->grade_id = $request->grade_id,
            ]);
            toastr()->success('Updated Successfully!', 'Class Edited');
            return redirect()->route('classrooms.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Classroom::findOrFail($id)->delete();
        toastr()->error('Deleted Successfully!', 'Class Deleted');
        return redirect()->route('classrooms.index');
    }

    public function delete_all(Request $request){
        $delete_all_ids = explode(',',$request->delete_all_id);
        Classroom::find($delete_all_ids)->each(function ($class, $key) {
            $class->delete();
        });
        toastr()->error('Deleted Successfully!', 'Classes Deleted');
        return redirect()->route('classrooms.index');
    }

    public function filter_by_grade(Request $request){
        $filtered_classrooms = Classroom::where('grade_id',$request->filter_grade_id)->get();
        $grades = Grade::all();
        return view('classrooms.classrooms',compact('filtered_classrooms','grades'));
    }
}
