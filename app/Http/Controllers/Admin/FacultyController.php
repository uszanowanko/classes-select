<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Session;
use App\Faculty;

class FacultyController extends Controller
{
     public function index($id = null, Request $request) {  
        $sortProperty = $request->input('sortProperty')?:'name';
        $sortOrder = $request->input('sortOrder')?:'asc';
         
        $query = Faculty::where([]);
         
        $filtered = false;
        //sprawdza czy poprawne i dodaje filtry przychodzące postem
        foreach ($request->all() as $key => $filter) {
            switch($key) {
                case 'active':
                    $query->where($key, !!$filter);
                    $filtered = true;
                    break;
            }
        }
         
         //ustawia domyślne wartości, jeśli nie filtrowany
        if (!$filtered) {
            $query->where('active', true);
        }
         
         $query->orderBy($sortProperty, $sortOrder);
        
        $request->flash();
         
        return view('admin/faculties',[
            'faculties' => $query->get(),
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered
        ]);
    }
    
    public function getFacultyForm($id = null) {        
        $faculty = $id? Faculty::find($id) : null;
        return view('admin/faculty',[
            'faculty' => $faculty
        ]);
    }
    
    public function saveFaculty($id = null, Request $request) {
        $faculty = $id? Faculty::find($id) : new Faculty();
        $faculty->fill($request->all());
        $faculty->save();
        Session::flash('success', 'Pomyślnie zapisano wydział');
        return redirect()->route('admin.faculties');
    }
    
    public function deleteFaculty($id) {
        $faculty = Faculty::find($id);
        $faculty->active = false;
        $faculty->save();
        Session::flash('success', 'Pomyślnie usunięto wydział');
        return redirect()->route('admin.faculties');
    }
}
