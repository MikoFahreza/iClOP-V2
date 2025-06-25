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
    public function displaySelectTestResult($test_result)
    {
        $output = "<div id='output-text' class='w-100 font-weight-bold'>";
        $allow = true;
        while ($row = pg_fetch_assoc($test_result)) {
            $line = $row['test_jawaban'];
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
        $userId = $request->user_id;
        $dbname = "latihan_{$userId}_{$request->exercise_id}";
        $topicsWithParametricTest = ['ABS', 'LENGTH', 'CURRENT_DATE', 'SUM', 'AVG', 'MAX', 'MIN'];

        try {
            $conn = $this->connectToDatabase($dbname);
            pg_query($conn, 'BEGIN;');
            if (in_array(strtoupper($test->topic), $topicsWithParametricTest)) {
                $run = $this->executeCode($conn, $request->code);
                $this->executeTest($conn, $this->test_code);
                $result = $this->executeTest($conn, 'SELECT * FROM test_jawaban(\'' . pg_escape_string($request->code) . '\');');
                $testInfo = $this->displaySelectTestResult($result);
                $runInfo = pg_fetch_all($run);
            } else {
                $run = $this->executeCode($conn, $request->code);
                $result = $this->executeTest($conn, $this->test_code);
                $testInfo = $this->displayTestResult($result);
                $runInfo = pg_fetch_all($run);
            }
            $runOutput = '';
            if ($runInfo && count($runInfo) > 0) {
                // Buat tabel HTML sederhana
                $runOutput .= "<div class='mb-2'><strong>Hasil Query Anda:</strong></div>";
                $runOutput .= "<table class='table table-bordered table-sm'><thead><tr>";
                foreach (array_keys($runInfo[0]) as $col) {
                    $runOutput .= "<th>{$col}</th>";
                }
                $runOutput .= "</tr></thead><tbody>";
                foreach ($runInfo as $row) {
                    $runOutput .= "<tr>";
                    foreach ($row as $cell) {
                        $runOutput .= "<td>{$cell}</td>";
                    }
                    $runOutput .= "</tr>";
                }
                $runOutput .= "</tbody></table>";
            } else {
                $statusString = pg_result_status($run, PGSQL_STATUS_STRING);
                $runOutput .= "<div class='mb-2'><em>{$statusString}</em></div>";
            }
            pg_query($conn, 'ROLLBACK;');
            $this->disconnectFromDatabase($conn);


            if (!$testInfo['allow']) {
                Submission::insert([
                    'student_id' => $userId,
                    'question_id' => $request->question_id,
                    'status' => 'Failed',
                    'solution' => $request->code,
                    'time_left' => $request->time_left,
                    'feedback' => $testInfo['output'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json([
                'run_output' => $runOutput,
                'result' => $testInfo['output']
            ]);
        } catch (\Exception $e) {
            Submission::insert([
                    'student_id' => $userId,
                    'question_id' => $request->question_id,
                    'status' => 'Failed',
                    'solution' => $request->code,
                    'time_left' => $request->time_left, // tambahkan ini
                    'feedback' => isset($testInfo['output']) ? $testInfo['output'] : '', // tambahkan ini
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            return response()->json(['result' => $this->displayError($e->getMessage())]);
        }
    }

    public function submitTest(Request $request)
    {
        $test = Question::findOrFail($request->task_id);
        $this->test_code = $test->test_code;
        $userId = $request->user_id;
        $dbname = "latihan_{$userId}_{$request->exercise_id}";
        $topicsWithParametricTest = ['ABS', 'LENGTH', 'CURRENT_DATE', 'SUM', 'AVG', 'MAX', 'MIN'];

        try {
            $conn = $this->connectToDatabase($dbname);
            pg_query($conn, 'BEGIN;');
            if (in_array(strtoupper($test->topic), $topicsWithParametricTest)) {
                $run = $this->executeCode($conn, $request->code);
                $this->executeTest($conn, $this->test_code);
                $result = $this->executeTest($conn, 'SELECT * FROM test_jawaban(\'' . pg_escape_string($request->code) . '\');');
                $testInfo = $this->displaySelectTestResult($result);
                $runInfo = pg_fetch_all($run);
            } else {
                $run = $this->executeCode($conn, $request->code);
                $result = $this->executeTest($conn, $this->test_code);
                $testInfo = $this->displayTestResult($result);
                $runInfo = pg_fetch_all($run);
            }
            $runOutput = '';
            if ($runInfo) {
                $runOutput .= "<div class='mb-2'><strong>Hasil Query Anda:</strong></div>";
                $runOutput .= "<table class='table table-bordered table-sm'><thead><tr>";
                foreach (array_keys($runInfo[0]) as $col) {
                    $runOutput .= "<th>{$col}</th>";
                }
                $runOutput .= "</tr></thead><tbody>";
                foreach ($runInfo as $row) {
                    $runOutput .= "<tr>";
                    foreach ($row as $cell) {
                        $runOutput .= "<td>{$cell}</td>";
                    }
                    $runOutput .= "</tr>";
                }
                $runOutput .= "</tbody></table>";
            } else {
                $runOutput .= "<div class='mb-2'><em>Tidak ada hasil dari query Anda.</em></div>";
            }

            if ($testInfo['allow']) {
                pg_query($conn, 'COMMIT;');
            } else {
                pg_query($conn, 'ROLLBACK;');
            }

            $this->disconnectFromDatabase($conn);

            Submission::updateOrCreate(
                ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                [
                    'status' => $testInfo['allow'] ? 'Passed' : 'Failed',
                    'solution' => $request->code,
                    'time_left' => $request->time_left,
                    'feedback' => $testInfo['output'],
                ]
            );

            return response()->json([
                'run_output' => $runOutput,
                'result' => $testInfo['output'], 
                'status' => $testInfo['allow'] ? 'passed' : 'failed',
                'message' => $testInfo['allow'] ? 'BERHASIL menyimpan jawaban!' : 'Masih terdapat kesalahan! Silahkan perbaiki terlebih dahulu jawaban Anda!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['result' => $this->displayError($e->getMessage())]);
        }
    }
}