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
        $teacher = User::where('role', 'teacher')->get();
        $year = AcademicYear::where('status', 'Aktif')->get();
        return view('postgre.user.admin.class.index', compact('classes', 'teacher', 'year'));
    }

    public function teacher()
    {
        $teacherPaged = User::where('role', 'teacher')->paginate(3);
        $teachers = User::where('role', 'teacher')->get();
        $years = AcademicYear::where('status', 'Aktif')->get();
        return view('postgre.user.admin.teacher.index', compact('teacherPaged','teachers', 'years'));
    }

    
    public function student()
    {
        $year = AcademicYear::where('status', 'Aktif')->get();
        return view('postgre.user.admin.student.index', compact('year'));
    }
// End of Pages
}