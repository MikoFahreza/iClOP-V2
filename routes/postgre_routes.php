<?php

use App\ExerciseQuestion;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Postgre\ClassesController;
use App\Http\Controllers\Postgre\ClassesStudentController;
use App\Http\Controllers\Postgre\ExerciseController;
use App\Http\Controllers\Postgre\ExerciseQuestionController;
use App\Http\Controllers\Postgre\ExerciseResultController;
use App\Http\Controllers\Postgre\QuestionController;
use App\Http\Controllers\Postgre\ValidatorController;
use App\Http\Controllers\Postgre\ValidatorXController;
use App\Http\Controllers\Postgre\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Postgre\AdminController;
use App\Http\Controllers\Postgre\TeacherController;
use App\Http\Controllers\Postgre\StudentController;

use App\Http\Controllers\Postgre\AcademicYearController;
Route::group(['prefix' => 'a', 'midddleware' => ['auth', 'isAdmin']], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('year', [AdminController::class, 'academic_year'])->name('admin.academic_year');
    Route::get('year/get', [AcademicYearController::class, 'getAcademicYearDataTable'])->name('admin.academic_year.get_datatable');
    Route::get('year/detail', [AcademicYearController::class, 'getAcademicYearDetail'])->name('admin.academic_year.detail');
    Route::post('year/add', [AcademicYearController::class, 'addAcademicYear'])->name('admin.academic_year.add');
    Route::post('year/update', [AcademicYearController::class, 'updateAcademicYear'])->name('admin.academic_year.update');
    Route::post('year/set-active', [AcademicYearController::class, 'setYearAsActive'])->name('admin.academic_year.setActive');
    Route::post('year/set-done', [AcademicYearController::class, 'setYearAsNonActive'])->name('admin.academic_year.setDone');

    Route::get('class', [AdminController::class, 'class'])->name('admin.class');
    Route::post('class/add', [ClassesController::class, 'addClass'])->name('admin.class.add');
    Route::get('class/detail', [ClassesController::class, 'getClassDetail'])->name('admin.class.detail');
    Route::post('class/update', [ClassesController::class, 'updateclass'])->name('admin.class.update');

    Route::get('teacher', [AdminController::class, 'teacher'])->name('admin.teacher');
    Route::post('teacher/add', [AdminController::class, 'addTeacher'])->name('admin.teacher.add');

    Route::get('student', [AdminController::class, 'student'])->name('admin.student');
    Route::post('student/class-option', [ClassesStudentController::class, 'getClassAsOption'])->name('admin.student.getClassAsOption');
    Route::get('student/get/{class_id}', [ClassesStudentController::class, 'getClassStudentDataTable'])->name('admin.student.getDatatable');
    Route::post('student/class-id', [ClassesStudentController::class, 'getClassIDForDataTable'])->name('admin.student.getClassIDForDataTable');
    Route::get('student/get-all', [ClassesStudentController::class, 'getStudentDataTable'])->name('admin.student.getAllDatatable');

    Route::post('student/assign-student', [ClassesStudentController::class, 'assignStudentToClass'])->name('admin.student.assignStudentToClass');
    Route::post('student/remove-student', [ClassesStudentController::class, 'removeStudentFromClass'])->name('admin.student.removeStudentFromClass');

});

Route::group(['prefix' => 't', 'midddleware' => ['auth', 'isTeacher']], function () {
    Route::get('dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

    Route::get('class', [TeacherController::class, 'class'])->name('teacher.class');
    Route::get('class/my', [TeacherController::class, 'getClass'])->name('teacher.class.get');
    Route::post('class/class-option', [ClassesStudentController::class, 'getClassAsOption'])->name('teacher.student.getClassAsOption');
    Route::get('class/get/{class_id}', [ClassesStudentController::class, 'getClassStudentDataTable'])->name('teacher.class.getDatatable');
    Route::post('class/class-id', [ClassesStudentController::class, 'getClassIDForDataTable'])->name('teacher.class.getClassIDForDataTable');
    Route::get('class/get-all', [ClassesStudentController::class, 'getStudentDataTable'])->name('teacher.class.getAllDatatable');

    Route::get('question', [TeacherController::class, 'question'])->name('teacher.question');
    Route::get('question/datatable', [QuestionController::class, 'getQuestionDataTable'])->name('teacher.question.datatable');
    Route::post('question/add', [QuestionController::class, 'addQuestion'])->name('teacher.question.add');
    Route::get('question/detail', [QuestionController::class, 'getQuestionDetail'])->name('teacher.question.detail');
    Route::post('question/update', [QuestionController::class, 'updateQuestion'])->name('teacher.question.update');

    Route::get('exercise', [TeacherController::class, 'exercise'])->name('teacher.exercise');
    Route::post('exercise/add', [ExerciseController::class, 'addExercise'])->name('teacher.exercise.add');
    Route::get('exercise/detail', [ExerciseController::class, 'getExerciseDetail'])->name('teacher.exercise.detail');
    Route::post('exercise/update', [ExerciseController::class, 'updateExercise'])->name('teacher.exercise.update');

    Route::get('exercise-question/{exercise_id}', [TeacherController::class, 'exerciseQuestion'])->name('teacher.exerciseQuestion');
    Route::get('exercise-question/get/all', [ExerciseQuestionController::class, 'getExerciseQuestionDataTable'])->name('teacher.exerciseQuestion.getDataTable');
    Route::get('exercise-question/get/exercise/{exercise_id}', [ExerciseQuestionController::class, 'getExerciseQuestionDataTableByExercise'])->name('teacher.exerciseQuestion.getDataTableByExercise');
    Route::post('exercise-question/set', [ExerciseQuestionController::class, 'setExerciseQuestionDataTable'])->name('teacher.exerciseQuestion.set');
    Route::post('exercise-question/delete', [ExerciseQuestionController::class, 'deleteExerciseQuestionDataTable'])->name('teacher.exerciseQuestion.delete');

    Route::post('exercise/exercise-option', [ExerciseController::class, 'getExerciseAsOption'])->name('teacher.exercise.getExerciseAsOption');
    Route::post('student/class-id', [ExerciseController::class, 'getExerciseIDForDataTable'])->name('teacher.exercise.getExerciseIDForDataTable');

    Route::get('exercise/exercise-question/detail', [ExerciseQuestionController::class, 'getExerciseQuestion'])->name('teacher.exerciseQuestion.getExerciseQuestion');
    Route::post('exercise/exercise-question/add', [ExerciseQuestionController::class, 'addExerciseQuestion'])->name('teacher.exerciseQuestion.addExerciseQuestion');
    Route::post('exercise/exercise-question/remove', [ExerciseQuestionController::class, 'removeExerciseQuestion'])->name('teacher.exerciseQuestion.removeExerciseQuestion');


    Route::get('exercise-result', [TeacherController::class, 'exerciseResult'])->name('teacher.exerciseResult');
    Route::get('exercise-result/class/{class_id}', [ExerciseResultController::class, 'exerciseResultByClass'])->name('teacher.exerciseResultByClass');
    Route::get('exercise-result/exercise/{exercise_id}/class/{class_id)', [ExerciseResultController::class, 'exerciseResultByExerciseDataTable'])->name('teacher.exerciseResultByExerciseDataTable');
    Route::post('exercise-result/get/exercise-id', [ExerciseResultController::class, 'getExerciseIDForDataTable'])->name('teacher.exerciseResult.getExerciseIDForDataTable');
});

Route::group(['prefix' => 's', 'midddleware' => ['auth', 'isStudent']], function () {
    Route::get('dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

    // Route::post('runtest', [ValidatorController::class, 'runtest'])->name('student.runtest');
    // Route::post('submittest', [ValidatorController::class, 'submittest'])->name('student.submittest');

    Route::post('runtest', [ValidatorXController::class, 'runtest'])->name('student.runtest');
    Route::post('submittest', [ValidatorXController::class, 'submittest'])->name('student.submittest');

    Route::get('exercise', [StudentController::class, 'exercise'])->name('student.exercise');
    Route::get('exercise-question/{exercise_id}/{question_no}', [StudentController::class, 'exerciseQuestion'])->name('student.exerciseQuestion');

    Route::get('exercise-question/question/{exercise_id}', [ExerciseQuestionController::class, 'getExerciseQuestionList'])->name('student.exerciseQuestion.questionList');
    Route::get('exercise-question/question/{exercise_id}/{question_no}', [ExerciseQuestionController::class, 'getExerciseQuestionItem'])->name('student.exerciseQuestion.question');

    Route::get('result', [StudentController::class, 'result'])->name('student.result');
    Route::get('result/exercise/{exercise_id}', [StudentController::class, 'resultByExercise'])->name('student.result.byExercise');
    Route::get('result/exercise/list/{exercise_id}', [StudentController::class, 'getResultByExerciseDataTable'])->name('student.result.getByExerciseDataTable');
    Route::get('result/exercise/detail/solution', [StudentController::class, 'getSubmissionResultDetail'])->name('student.result.getSubmissionDetail');
});


Route::get('/p', [AuthController::class, 'logout'])->name('logout');