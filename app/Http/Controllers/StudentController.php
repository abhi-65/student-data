<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Requests\StudentRequest;
use DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $this->saveLog(__FUNCTION__,$request,'Request for student List');
            if ($request->ajax()) {
                $data = Student::select('*');
                return Datatables::of($data)
                        ->addColumn('action', function($row){
                                $edit = '<a href="'.route('edit-student',[$row->id]).'" class="btn btn-xs btn-primary">Edit</a>';
                                return $edit;
                        
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            return view('student.index');
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
        
    }

    public function add($id=null)
    {
        try
        {
            $this->saveLog(__FUNCTION__,$id,'Request for add/edit student');
            $student = null;
            if(!empty($id))
            {
                $student = Student::where('id',$id)->first();
            }
            return view('student.add',compact('student'));
        }
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }
    }

    public function save(StudentRequest $studentRequest)
    {
        try
        {
            $this->saveLog(__FUNCTION__,$studentRequest,'Request for save/update student');
            $id= null;
            if(isset($studentRequest['id']) && !empty($studentRequest['id']))
            {
                $id = $studentRequest['id'];
            }
            $student = Student::updateOrCreate([
                'id'=>$id
            ],[
                'student_name' => $studentRequest['student_name'],
                'grade' => $studentRequest['grade'],
                'date_of_birth' => date('Y-m-d',strtotime($studentRequest['date_of_birth'])),
                'address' => $studentRequest['address'],
                'country' => $studentRequest['country'],
                'photo' => $studentRequest['photo_name'],
                'city' => $studentRequest['city']
            ]);
            if($studentRequest->hasFile('photo'))
            {
                $fileName = time().'.'.$studentRequest->photo->extension();  
       
                $studentRequest->photo->move(public_path('photo/student'), $fileName);
                Student::where('id',$student->id)->update(['photo'=>$fileName]);
            }
            return redirect()->route('index');
        }  
        catch(Exception $e)
        {
            abort(404,$e->getMessage());
        }  
    }
}
