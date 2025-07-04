<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Exercise;
use App\Models\Postgre\ExerciseQuestion;
use App\Models\Postgre\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('postgre.user.student.dashboard');
    }

    public function exercise()
    {
        $exercise = Exercise::all();
        return view('postgre.user.student.exercise.index', compact('exercise'));
    }

    private function createUserExerciseDatabase($userId, $exerciseId)
    {
        $dbName = "latihan_{$userId}_{$exerciseId}";
        $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres");
        $check = pg_query($conn, "SELECT 1 FROM pg_database WHERE datname = '{$dbName}'");
        if (pg_num_rows($check) == 0) {
            pg_query($conn, "CREATE DATABASE \"{$dbName}\"");
            // Isi tabel dan data
            $dbConn = pg_connect("host=localhost port=5432 dbname={$dbName} user=postgres password=postgres");
            $initSql = <<<SQL
CREATE TABLE pelanggan (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    alamat TEXT
);
CREATE TABLE penjualan (
    id SERIAL PRIMARY KEY,
    id_pelanggan INT REFERENCES pelanggan(id),
    tanggal DATE NOT NULL,
    total INT
);
CREATE TABLE transaksi (
    id SERIAL PRIMARY KEY,
    nama_pelanggan VARCHAR(100),
    selisih_pembayaran INT,
    total INT,
    tanggal_transaksi DATE
);
INSERT INTO pelanggan (nama, email, alamat) VALUES
('Andi Wijaya', 'andi@gmail.com', 'Jl. Melati 1'),
('Budi Santoso', 'budi@gmail.com', 'Jl. Mawar 2'),
('Citra Dewi', 'citra@gmail.com', 'Jl. Kenanga 3'),
('Dewi Ayu', 'dewi@gmail.com', 'Jl. Dahlia 4');
INSERT INTO penjualan (id_pelanggan, tanggal, total) VALUES
(1, '2025-06-01', 500000),
(2, '2025-06-02', 450000),
(3, '2025-06-03', 520000),
(4, '2025-06-04', 480000);
INSERT INTO transaksi (nama_pelanggan, selisih_pembayaran, total, tanggal_transaksi) VALUES
('Andi Wijaya', -50000, 500000, '2025-06-01'),
('Budi Santoso', 0, 450000, '2025-06-02'),
('Citra Dewi', 20000, 520000, '2025-06-03'),
('Dewi Ayu', -30000, 480000, '2025-06-04'),
('Ayu Cantika', 0, 0, '2025-06-05');
SQL;
            foreach (explode(';', $initSql) as $sql) {
                if (trim($sql)) pg_query($dbConn, $sql);
            }
            pg_close($dbConn);
        }
        pg_close($conn);
        return $dbName;
    }

    public function exerciseQuestion(Request $request)
    {
        $exercise_id = $request->exercise_id;
        $userId = Auth::user()->id;
        $dbName = $this->createUserExerciseDatabase($userId, $exercise_id);

        $soal = DB::table('postgre_exercise_question')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->join('postgre_exercise', 'postgre_exercise_question.exercise_id', 'postgre_exercise.id')
            ->where('postgre_exercise_question.exercise_id', '=', $exercise_id)
            ->where('postgre_exercise_question.no', '=', $request->question_no)
            ->select('postgre_exercise_question.no', 'postgre_question.id', 'postgre_question.title', 'postgre_question.topic', 'postgre_question.description', 'postgre_question.test_code', 'postgre_exercise.guide', 'postgre_exercise.name', 'postgre_exercise.duration', 'postgre_exercise_question.exercise_id')
            ->get();
        $daftar_soal = DB::table('postgre_exercise_question')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->join('postgre_exercise', 'postgre_exercise_question.exercise_id', 'postgre_exercise.id')
            ->where('postgre_exercise_question.exercise_id', '=', $exercise_id)
            ->select('postgre_exercise_question.no', 'postgre_question.id', 'postgre_question.title', 'postgre_question.topic', 'postgre_question.description', 'postgre_question.test_code', 'postgre_exercise.guide', 'postgre_exercise.name', 'postgre_exercise_question.exercise_id')
            ->orderBy('postgre_exercise_question.no')
            ->get();
        $jumlah_soal = ExerciseQuestion::where('exercise_id', '=', $exercise_id)->get()->count();

        // Tambahan: cek submission untuk soal aktif
        $currentQuestionId = $soal[0]->id ?? null;
        $submission = null;
        if ($currentQuestionId) {
            $submission = DB::table('postgre_submissions')
                ->where('student_id', $userId)
                ->where('question_id', $currentQuestionId)
                ->first();
        }

        return view(
            'postgre.user.student.exercise_question.index',
            compact('exercise_id', 'soal', 'jumlah_soal', 'daftar_soal', 'dbName', 'submission')
        );
    }

    public function result()
    {
        $exercise = Exercise::all();
        return view('postgre.user.student.result.index', compact('exercise'));
    }

    public function resultByExercise(Request $request)
    {
        $exercise_id = $request->exercise_id;
        $passed = DB::table('postgre_exercise_question')
            ->join('postgre_submissions', 'postgre_exercise_question.question_id', 'postgre_submissions.question_id')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->where('postgre_submissions.status', 'Passed')
            ->where('postgre_exercise_question.exercise_id', $request->exercise_id)
            ->where('postgre_submissions.student_id', Auth::user()->id)->get()->count();
            
        $question = DB::table('postgre_exercise_question')->where('exercise_id', $exercise_id)->get()->count();
        $result = floor(($passed / $question) * 100);
        return view('postgre.user.student.result.resultByExercise', compact('exercise_id', 'passed', 'question', 'result'));
    }

    public function getResultByExerciseDataTable(Request $request)
    {
        $nilai = DB::table('postgre_exercise_question')
            ->join('postgre_submissions', 'postgre_exercise_question.question_id', 'postgre_submissions.question_id')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->where('postgre_exercise_question.exercise_id', $request->exercise_id)
            ->where('postgre_submissions.student_id', Auth::user()->id)
            ->select(
                'postgre_submissions.id',
                'postgre_exercise_question.no',
                'postgre_question.title',
                'postgre_submissions.status',
                'postgre_submissions.created_at',
                'postgre_submissions.updated_at',
                'postgre_submissions.time_left', 
                'postgre_submissions.feedback'
            );

        return DataTables::of($nilai)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
                    <button id="jawaban" type="button" class="btn btn-primary btn-block" data-id="' . $row->id . '">Jawaban</button>
                    <button id="feedback" type="button" class="btn btn-info btn-block" data-id="' . $row->id . '">Feedback</button>
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getSubmissionResultDetail(Request $request)
    {
        $nilai = Submission::with('soal')->where('id', $request->submission_id)->get();
        return response()
            ->json(['details' => $nilai]);

    }

    public function finishTest(Request $request)
    {
        $userId = $request->user_id;
        $exerciseId = $request->exercise_id;
        $dbName = "latihan_{$userId}_{$exerciseId}";

        // Submit otomatis semua soal yang belum disubmit
        $soalIds = DB::table('postgre_exercise_question')
            ->where('exercise_id', $exerciseId)
            ->pluck('question_id');
        foreach ($soalIds as $qid) {
            $exist = DB::table('postgre_submissions')
                ->where('student_id', $userId)
                ->where('question_id', $qid)
                ->exists();
            if (!$exist) {
                DB::table('postgre_submissions')->insert([
                    'student_id' => $userId,
                    'question_id' => $qid,
                    'status' => 'Failed',
                    'solution' => '',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // Drop database
        $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres");
        pg_query($conn, "SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = '{$dbName}'");
        pg_query($conn, "DROP DATABASE IF EXISTS \"{$dbName}\"");
        pg_close($conn);

        return response()->json(['message' => 'Tes selesai dan database berhasil dihapus!']);
    }

    public function checkSubmissionStatus(Request $request)
    {
        $submission = DB::table('postgre_submissions')
            ->where('student_id', $request->user_id)
            ->where('question_id', $request->question_id)
            ->first();

        if ($submission && $submission->status === 'Passed') {
            return response()->json(['status' => 'Passed']);
        }

        return response()->json(['status' => 'Not Passed']);
    }
}