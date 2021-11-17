<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradesRequest;
use App\Models\Grade;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GradeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $grades = Grade::all();
      return view('grades.grades',compact('grades'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(GradesRequest $request)
  {
      if(Grade::where('name->ar',$request->name)->orwhere('name->en',$request->name_en)->exists()){
          return redirect()->back()->withErrors(['error' => 'Grade name must be unique']);
      }
      try {
          $grade = new Grade();
          $grade->name = ['en' => $request->name_en, 'ar' => $request->name];
          $grade->notes = $request->notes;
          $grade->save();
          toastr()->success('Saved Successfully!', 'Grade Saved');
          return redirect()->route('grades.index');
      }catch (\Exception $e){
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }



  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
      $grade_data = Grade::findOrFail($id);
      if($grade_data){
          return response()->json(['status' => true, 'data' => $grade_data]);
      }
      return response()->json(['status' => false, 'data' => '']);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request,$id)
  {
       $grade_data = Grade::findOrFail($id);
      if($grade_data){
          $grade_data->update([
              $grade_data->Name = ['ar' => $request->name_edit, 'en' => $request->name_en_edit],
              $grade_data->Notes = $request->notes_edit,
          ]);
          toastr()->success('Updated Successfully!', 'Grade Edited');
          return redirect()->route('grades.index');
      }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
      $grade = Grade::findOrFail($id);
      if($grade->classrooms->count() == 0){
          Grade::findOrFail($id)->delete();
          toastr()->error('Deleted Successfully!', 'Grade Deleted');
          return redirect()->route('grades.index');
      }else{
          toastr()->error('Can not delete', 'Grade has related classes');
          return redirect()->route('grades.index');
      }
  }

}

?>
