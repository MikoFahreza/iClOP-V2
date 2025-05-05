<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\AcademicYear;
use App\Models\Postgre\Classes;
use App\Models\Postgre\Teacher;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    // Pages
    public function dashboard()
    {
        $tahun_ajaran = AcademicYear::where('status', '=', 'Aktif')->get();
        return view('postgre.user.admin.dashboard', compact('tahun_ajaran'));
    }

    public function academic_year()
    {
        $tahun_ajaran = AcademicYear::where('status', '=', 'Aktif')->get();
        return view('postgre.user.admin.academic_year.index', compact('tahun_ajaran'));
    }


    public function class()
    {
        $classes = Classes::with('teacher', 'year')->paginate(3);
        $teacher = Teacher::all();
        $year = AcademicYear::where('status', 'Aktif')->get();
        return view('postgre.user.admin.class.index', compact('classes', 'teacher', 'year'));
    }

    public function teacher()
    {
        $teacher = Teacher::with('user')->paginate(3);
        return view('postgre.user.admin.teacher.index', compact('teacher'));
    }

    
    public function student()
    {
        $year = AcademicYear::where('status', 'Aktif')->get();
        return view('postgre.user.admin.student.index', compact('year'));
    }
// End of Pages
}