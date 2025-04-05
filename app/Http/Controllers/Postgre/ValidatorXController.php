<?php

namespace App\Http\Controllers;

use App\Question;
use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidatorXController extends Controller
{
    private $topic, $dbname;
    private $test_code, $isAllowSubmit = true;

    protected function displayHint($myhint)
    {
        $hint = "<div class='alert alert-danger'>";
        $hint .= "<i class='fa-solid fa-triangle-exclamation'></i> " . $myhint;
        $hint .= "</div>";
        return $hint;
    }

    protected function displayError($myerror)
    {
        $error = "<div id='output-text' class='alert alert-danger'>";
        $error .= $myerror;
        $error .= "</div>";
        return $error;
    }

    public function connectToDatabase($dbname)
    {
        if (!pg_connect("host = localhost port = 5432 dbname=$dbname user=postgres  password=postgres")) {
            throw new \Exception('SYSTEM_ERROR: Cant connect to database!');
        }
        return pg_connect("host = localhost port = 5432 dbname=$dbname user=postgres  password=postgres");
    }

    public function disconnectFromDatabase($connection)
    {
        if (!pg_close($connection)) {
            throw new \Exception('SYSTEM_ERROR: Cant disconnect from database!');
        }
    }

    public function executeCode($connection, $code, $topic)
    {
        if (str_contains(strtolower($code), strtolower($topic))) {
            $result = pg_query($connection, $code);
            if (!$result) {
                throw new \Exception($this->displayError(pg_last_error($connection)));
            } else {
                return $result;
            }
        } else {
            throw new \Exception($this->displayHint("Anda bisa menggunakan <strong>$topic</strong> pada pembelajaran kali ini"));
        }
    }

    public function executeTest($connection, $test_code)
    {
        $result = pg_query($connection, $test_code);
        if (!$result) {
            throw new \Exception($this->displayError(pg_last_error($connection)));
        } else {
            return $result;
        }
    }

    public function displayTestResult($test_result)
    {
        $result = "<div id='output-text' class='w-100 font-weight-bold'> ";
        while ($row = pg_fetch_assoc($test_result)) {
            if (strpos($row['runtests'], 'not ok') !== false) {
                $this->isAllowSubmit = false;
                $result .= "<div class='alert alert-danger'>";
                $result .= "<i class='fas fa-times'></i> " . $row['runtests'];
                $result .= "</div>";
            } else if (strpos($row['runtests'], 'failed') !== false) {
                $this->isAllowSubmit = false;
                $result .= "<div class='alert alert-warning'>";
                $result .= "<i class='fas fa-exclamation-triangle'></i> " . $row['runtests'];
                $result .= "</div>";
            } else {
                if ($this->isAllowSubmit == false) {
                    $this->isAllowSubmit = false;
                } else {
                    $this->isAllowSubmit = true;
                }
                $result .= "<div class='alert alert-success'>";
                $result .= "<i class='fas fa-check'> </i> " . $row['runtests'];
                $result .= "</div>";
            }
        }
        $result .= "</div>";
        return $result;
    }

    public function runTest(Request $request)
    {

        //Get task data
        $test = Question::where('id', '=', $request->question_id)->get();
        $this->test_code = $test[0]->test_code;
        $this->topic = $test[0]->topic;
        $this->dbname = $test[0]->dbname . Auth::user()->id;

        if (strcmp($test[0]->topic, "CREATE Database") == 0) {
            if (strcasecmp($request->code, "create database my_playlist;") == 0) {
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-success'>";
                $finalResult .= "<i class='fas fa-check'> </i> " . "Membuat database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            } else {
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-danger'>";
                $finalResult .= "<i class='fas fa-times'> </i> " . "Membuat database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            }

            //Display test result
            return response()->json(['result' => $finalResult]);
        } else if (strcmp($test[0]->topic, "DROP Database") == 0) {
            if (strcasecmp($request->code, "DROP DATABASE my_playlists;") == 0) {
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-success'>";
                $finalResult .= "<i class='fas fa-check'> </i> " . "Menghapus database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            } else {
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-danger'>";
                $finalResult .= "<i class='fas fa-times'> </i> " . "Menghapus database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            }

            //Display test result
            return response()->json(['result' => $finalResult]);
        } else {
            //Get Connection 1
            try {
                $pg_connection = $this->connectToDatabase('postgres');
                pg_query($pg_connection, "DROP DATABASE IF EXISTS " . $this->dbname . ";");
                pg_query($pg_connection, "create database " . $this->dbname . ";");
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Get Connection 2
            try {
                $mhs_connection = $this->connectToDatabase($this->dbname);
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Execute Code
            $mycode = "BEGIN;";
            $mycode = $test[0]->required_table;
            $mycode .= $request->code;
            try {
                $this->executeCode($mhs_connection, $mycode, $this->topic);
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Execute Test
            try {
                $finalResult = $this->displayTestResult($this->executeTest($mhs_connection, $this->test_code));
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Close Connection
            try {
                pg_query($mhs_connection, 'ROLLBACK;');
                $this->disconnectFromDatabase($mhs_connection);
                pg_query($pg_connection, "DROP DATABASE IF EXISTS " . $this->dbname);
            } catch (\Exception $e) {
                return response()->json(['result' => $e->getMessage()]);
            }

            //Display test result
            return response()->json(['result' => $finalResult]);
        }
    }

    public function submitTest(Request $request)
    {
        //Get task data
        $test = Question::where('id', '=', $request->task_id)->get();
        $this->test_code = $test[0]->test_code;
        $this->topic = $test[0]->topic;
        $this->dbname = $test[0]->dbname . Auth::user()->id;

        //Get Connection 1
        if (strcmp($test[0]->topic, "CREATE Database") == 0) {

            if (strcasecmp($request->code, "create database my_playlist;") == 0) {
                $this->isAllowSubmit = true;
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-success'>";
                $finalResult .= "<i class='fas fa-check'> </i> " . "Membuat database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            } else {
                $this->isAllowSubmit = false;
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-danger'>";
                $finalResult .= "<i class='fas fa-times'> </i> " . "Membuat database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            }

            if ($this->isAllowSubmit == true) {

                $result = Submission::updateOrCreate(
                    ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                    ['status' => 'Passed', 'solution' => $request->code]
                );

                if (!$result) {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'passed',
                        'message' => 'GAGAL menyimpan jawaban!',
                    ]);
                } else {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'passed',
                        'message' => 'BERHASIL menyimpan jawaban!',
                    ]);
                }
            } else {

                $result = Submission::updateOrCreate(
                    ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                    ['status' => 'Failed', 'solution' => $request->code]
                );

                if (!$result) {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'failed',
                        'message' => 'GAGAL menyimpan jawaban!',
                    ]);
                } else {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'failed',
                        'message' => 'Masih terdapat kesalahan! Silahkan perbaiki terlebih dahulu jawaban Anda!',
                    ]);
                }
            }
        } else if (strcmp($test[0]->topic, "DROP Database") == 0) {
            if (strcasecmp($request->code, "DROP DATABASE my_playlists;") == 0) {
                $this->isAllowSubmit = true;
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-success'>";
                $finalResult .= "<i class='fas fa-check'> </i> " . "Menghapus database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            } else {
                $this->isAllowSubmit = false;
                $finalResult = "<div id='output-text' class='w-100'>";
                $finalResult .= "<div class='alert alert-danger'>";
                $finalResult .= "<i class='fas fa-times'> </i> " . "Menghapus database my_playlist";
                $finalResult .= "</div>";
                $finalResult .= "</div>";
            }

            if ($this->isAllowSubmit == true) {

                $result = Submission::updateOrCreate(
                    ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                    ['status' => 'Passed', 'solution' => $request->code]
                );

                if (!$result) {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'passed',
                        'message' => 'GAGAL menyimpan jawaban!',
                    ]);
                } else {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'passed',
                        'message' => 'BERHASIL menyimpan jawaban!',
                    ]);
                }
            } else {

                $result = Submission::updateOrCreate(
                    ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                    ['status' => 'Failed', 'solution' => $request->code]
                );

                if (!$result) {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'failed',
                        'message' => 'GAGAL menyimpan jawaban!',
                    ]);
                } else {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'failed',
                        'message' => 'Masih terdapat kesalahan! Silahkan perbaiki terlebih dahulu jawaban Anda!',
                    ]);
                }
            }

            //Display test result
            // return response()->json(['result' => $finalResult]);
        } else {
            //Get Connection 1
            try {
                $pg_connection = $this->connectToDatabase('postgres');
                pg_query($pg_connection, "DROP DATABASE IF EXISTS " . $this->dbname . ";");
                pg_query($pg_connection, "create database " . $this->dbname . ";");
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Get Connection 2
            try {
                $mhs_connection = $this->connectToDatabase($this->dbname);
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Execute Code
            $mycode = "BEGIN;";
            $mycode = $test[0]->required_table;
            $mycode .= $request->code;
            try {
                $this->executeCode($mhs_connection, $mycode, $this->topic);
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Execute Test
            try {
                //$this->executeTest($mhs_connection, $this->test_code);
                $finalResult = $this->displayTestResult($this->executeTest($mhs_connection, $this->test_code));
            } catch (\Exception $e) {
                return response()->json(['result' => $this->displayError($e->getMessage())]);
            }

            //Close Connection
            try {
                pg_query($mhs_connection, 'ROLLBACK;');
                $this->disconnectFromDatabase($mhs_connection);
                pg_query($pg_connection, "DROP DATABASE IF EXISTS " . $this->dbname);
            } catch (\Exception $e) {
                return response()->json(['result' => $e->getMessage()]);
            }

            if ($this->isAllowSubmit == true) {

                $result = Submission::updateOrCreate(
                    ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                    ['status' => 'Passed', 'solution' => $request->code]
                );

                if (!$result) {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'passed',
                        'message' => 'GAGAL menyimpan jawaban!',
                        'alloSubmit' => $this->isAllowSubmit
                    ]);
                } else {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'passed',
                        'message' => 'BERHASIL menyimpan jawaban!',
                        'alloSubmit' => $this->isAllowSubmit
                    ]);
                }
            } else {
                $result = Submission::updateOrCreate(
                    ['student_id' => $request->user_id, 'question_id' => $request->task_id],
                    ['status' => 'Failed', 'solution' => $request->code]
                );

                if (!$result) {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'failed',
                        'message' => 'GAGAL menyimpan jawaban!',
                        'alloSubmit' => $this->isAllowSubmit
                    ]);
                } else {
                    return response()->json([
                        'result' => $finalResult,
                        'status' => 'failed',
                        'message' => 'Masih terdapat kesalahan! Silahkan perbaiki terlebih dahulu jawaban Anda!',
                        'alloSubmit' => $this->isAllowSubmit
                    ]);
                }
            }
        }
    }
}