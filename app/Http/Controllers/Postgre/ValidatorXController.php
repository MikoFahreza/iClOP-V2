<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Question;
use App\Models\Postgre\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidatorXController extends Controller
{
    private $topic, $test_code;

    protected function displayHint($myhint)
    {
        return "<div class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i> {$myhint}</div>";
    }

    protected function displayError($myerror)
    {
        return "<div id='output-text' class='alert alert-danger'>{$myerror}</div>";
    }

    public function connectToDatabase($dbname)
    {
        $conn = pg_connect("host=localhost port=5432 dbname={$dbname} user=postgres password=postgres");
        if (!$conn) {
            throw new \Exception('SYSTEM_ERROR: Cannot connect to database ' . $dbname);
        }
        return $conn;
    }

    public function disconnectFromDatabase($connection)
    {
        if (!pg_close($connection)) {
            throw new \Exception('SYSTEM_ERROR: Cannot disconnect from database!');
        }
    }

    public function executeCode($connection, $code)
    {
        // if (!str_contains(strtolower($code), strtolower($topic))) {
        //     throw new \Exception($this->displayHint("Anda bisa menggunakan <strong>{$topic}</strong> pada pembelajaran kali ini"));
        // }
        $result = pg_query($connection, $code);
        if (!$result) {
            throw new \Exception($this->displayError(pg_last_error($connection)));
        }
        return $result;
    }

    public function executeTest($connection, $test_code)
    {
        $result = pg_query($connection, $test_code);
        if (!$result) {
            throw new \Exception($this->displayError(pg_last_error($connection)));
        }
        return $result;
    }

    public function displayTestResult($test_result)
    {
        $output = "<div id='output-text' class='w-100 font-weight-bold'>";
        $allow = true;
        while ($row = pg_fetch_assoc($test_result)) {
            $line = $row['runtests'];
            if (strpos($line, 'not ok') !== false || strpos($line, 'failed') !== false) {
                $allow = false;
            }
            $cls = strpos($line, 'not ok') !== false ? 'danger' : (strpos($line, 'failed') !== false ? 'warning' : 'success');
            $icon = $cls === 'success' ? 'fa-check' : ($cls === 'warning' ? 'fa-exclamation-triangle' : 'fa-times');
            $output .= "<div class='alert alert-{$cls}'><i class='fas {$icon}'></i> {$line}</div>";
        }
        $output .= "</div>";
        return ['output' => $output, 'allow' => $allow];
    }

    public function runTest(Request $request)
    {
        $test = Question::findOrFail($request->question_id);
        $this->test_code = $test->test_code;
        // $this->topic = $test->topic;
        $dbname = 'praktikum_penjualan';

        try {
            $conn = $this->connectToDatabase($dbname);
            pg_query($conn, 'BEGIN;');
            $this->executeCode($conn, $request->code);
            $result = $this->executeTest($conn, $this->test_code);
            $testInfo = $this->displayTestResult($result);
            pg_query($conn, 'ROLLBACK;');
            $this->disconnectFromDatabase($conn);

            return response()->json(['result' => $testInfo['output']]);
        } catch (\Exception $e) {
            return response()->json(['result' => $this->displayError($e->getMessage())]);
        }
    }

    public function submitTest(Request $request)
    {
        $test = Question::findOrFail($request->task_id);
        $this->test_code = $test->test_code;
        // $this->topic = $test->topic;
        $dbname = 'praktikum_penjualan';

        try {
            $conn = $this->connectToDatabase($dbname);
            pg_query($conn, 'BEGIN;');
            $this->executeCode($conn, $request->code);
            $result = $this->executeTest($conn, $this->test_code);
            $testInfo = $this->displayTestResult($result);
            pg_query($conn, 'ROLLBACK;');
            $this->disconnectFromDatabase($conn);

            Submission::updateOrCreate(
                ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                ['status' => $testInfo['allow'] ? 'Passed' : 'Failed', 'solution' => $request->code]
            );

            return response()->json([
                'result' => $testInfo['output'], 
                'status' => $testInfo['allow'] ? 'passed' : 'failed',
                'message' => $testInfo['allow'] ? 'BERHASIL menyimpan jawaban!' : 'Masih terdapat kesalahan! Silahkan perbaiki terlebih dahulu jawaban Anda!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['result' => $this->displayError($e->getMessage())]);
        }
    }
}
