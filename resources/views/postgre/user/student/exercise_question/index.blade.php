@extends('postgre.user.student.master') @section('title')
    iCLOP | Daftar Soal
@endsection
@section('content-header')
    <div class="container-fluid">
        <div class="row align-items-center" style="min-height: 60px;">
            <div class="col-4"></div>
            <div class="col-4 text-center">
                <h2 style="margin-bottom:0;">{{ $soal[0]->name }}</h2>
            </div>
            <div class="col-4 text-right">
                <div id="exercise-timer" style="display:inline-block;background:#fff;padding:10px 20px;border-radius:8px;box-shadow:0 2px 8px #0001;font-weight:bold;font-size:18px;color:#d9534f;">
                    Sisa Waktu: <span id="timer-text">--:--</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row"> <!-- Hapus style="height: 600px;" -->
                <!-- Kiri: Preview Guidance -->
                <div class="col-md-4">
                    @if(count($soal) > 0)
                        <embed src="{{ Storage::disk('public')->url('function_guidance/' . $soal[0]->guide) }}" type="application/pdf"
                        style="width: 100%; height: 500px;">
                        <!-- <embed src="{{ Storage::disk('public')->get('function_guidance/' . $soal[0]->guide) }}" type="application/pdf"
                            style="width: 100%; height: 500px;"> -->
                    @endif
                </div>
                <!-- Tengah: Editor dan Output -->
                <div class="col-md-5 d-flex flex-column">
                    <div class="editor" id="editor" style="height: 200px;"></div>
                    <div class="row mt-3">
                        <div class="col-6">
                            @if ($soal[0]->no <= 1)
                                <button class="btn btn-primary w-100" data-toggle="tooltip" data-placement="bottom"
                                    title="Sebelumnya" disabled><i class="fa fa-angle-left"></i></button>
                            @else
                                <button id="prevBtn" class="btn btn-primary w-100" data-toggle="tooltip"
                                    data-placement="bottom" title="Sebelumnya"
                                    onclick="window.location.href='/s/exercise-question/{{ $soal[0]->exercise_id }}/{{ $soal[0]->no - 1 }}'"><i
                                        class="fa fa-angle-left"></i></button>
                            @endif
                        </div>
                        <div class="col-6">
                            @if ($soal[0]->no >= $jumlah_soal)
                                <button id="nextBtn" class="btn btn-primary w-100" data-toggle="tooltip"
                                    data-placement="bottom" title="Selanjutnya" disabled><i
                                        class="fa fa-angle-right"></i></button>
                            @else
                                <button class="btn btn-primary w-100" data-toggle="tooltip" data-placement="bottom"
                                    title="Selanjutnya"
                                    onclick="window.location.href='/s/exercise-question/{{ $soal[0]->exercise_id }}/{{ $soal[0]->no + 1 }}'">
                                    <i class="fa fa-angle-right"></i></button>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <button id="runButton" class="btn btn-success w-100" data-toggle="tooltip"
                                data-placement="bottom" title="Run"><i class="fa fa-play"></i></button>
                        </div>
                        <div class="col-6">
                            <button id="submitButton" class="btn btn-outline-warning w-100" data-toggle="tooltip"
                                data-placement="bottom" title="Submit">
                                <i class="fa fa-check-double"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Tambahkan div baru untuk hasil executeCode -->
                    <div id="run-output" class="row mt-3"></div>
                    <!-- Output/Alert -->
                    <div id="output" class="row mt-3" style="min-height: 120px;"></div>
                </div>
                <!-- Kanan: Navbar Soal -->
                 
                <div class="col-md-3">
                    <!-- Timer dipindah ke atas daftar soal -->
                    <div class="d-flex flex-column" style="height: 100%;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5>Daftar Soal</h5>
                        </div>
                        <div class="nav flex-column nav-pills" style="height: 100%; overflow-y: auto; border-left: 5px solid #eee;">
                            @foreach($daftar_soal as $s)
                                <a 
                                    class="nav-link {{ $s->id == $soal[0]->id ? 'active' : '' }}" 
                                    href="/s/exercise-question/{{ $s->exercise_id }}/{{ $s->no }}">
                                    <div>
                                        <strong>{{ $s->no }}.</strong> {{ $s->topic }}
                                    </div>
                                    <div style="font-size: 0.85em; color: #888;">
                                        {{ $s->title }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button id="finishTestBtn" class="btn btn-danger"
        style="position: fixed; bottom: 30px; right: 30px; z-index: 9999;"
        data-toggle="tooltip" title="Selesaikan Tes & Hapus Database">
        <i class="fa fa-trash"></i> Selesaikan Tes
    </button>

    <script src="{{ asset('postgre/editor/ide.js') }} "></script>
    <script src="{{ asset('postgre/editor/ace-editor/ace.js') }} "></script>
    <script src="{{ asset('postgre/editor/ace-editor/mode-pgsql.js') }} "></script>
    <script src="{{ asset('postgre/editor/ace-editor/theme-monokai.js') }} "></script>
    <script src="{{ asset('postgre/editor/ace-editor/ext-language_tools.js') }}"></script>
    <script>
        var langTools = ace.require("ace/ext/language_tools");
    </script>
@endsection

@section('script')
    <script>
        // Timer settings (in seconds)
        var timerDuration = @json(isset($soal[0]->duration) ? $soal[0]->duration : 1800); // dari database, fallback 30 menit
        var timerKey = 'icloptimer_{{ $exercise_id }}_{{ Auth::user()->id }}';
        var timerInterval = null;
        var remaining = timerDuration;
        
        // Load timer from localStorage if exists
        if(localStorage.getItem(timerKey)) {
            remaining = parseInt(localStorage.getItem(timerKey));
        }
        
        function updateTimerDisplay() {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;
            document.getElementById('timer-text').textContent = `${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
        }
        
        function finishTestAuto() {
            // Otomatis selesaikan latihan
            $.ajax({
                url: "{{ route('student.finishTest') }}",
                method: "POST",
                data: {
                    exercise_id: "{{ $exercise_id }}",
                    user_id: "{{ Auth::user()->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('Waktu habis! Latihan otomatis diselesaikan.');
                    setTimeout(() => window.location.href = "{{ route('student.exercise') }}", 2000);
                },
                error: function() {
                    toastr.error('Gagal menyelesaikan tes!');
                }
            });
        }
        
        function startTimer() {
            if(timerInterval) clearInterval(timerInterval);
            timerInterval = setInterval(function() {
                if(remaining > 0) {
                    remaining--;
                    localStorage.setItem(timerKey, remaining);
                    updateTimerDisplay();
                } else {
                    clearInterval(timerInterval);
                    localStorage.removeItem(timerKey);
                    finishTestAuto();
                }
            }, 1000);
        }
        
        function pauseTimer() {
            if(timerInterval) clearInterval(timerInterval);
        }
        
        // Pause timer saat tab tidak aktif
        document.addEventListener('visibilitychange', function() {
            if(document.hidden) {
                pauseTimer();
            } else {
                startTimer();
            }
        });
        
        // Reset timer jika latihan selesai manual
        $('#finishTestBtn').click(function() {
            localStorage.removeItem(timerKey);
        });
        
        // Inisialisasi timer saat halaman siap
        $(document).ready(function() {
            updateTimerDisplay();
            startTimer();
        });
        $(document).ready(function() {
                $('#runButton').click(function() {
                    if (editor.getSession().getValue() == "") {
                        alert("Silakan tulis jawaban anda terlebih dahulu!");
                    } else {
                        $("#runButton").attr("disabled", true);
                        $("#runButton").html("<i class='fas fa-spinner'></i> Processing");
                        $("#submitButton").attr("disabled", true);
                        $("#submitButton").html("<i class='fas fa-ban'></i> Submit");
                        $.ajax({
                            url: "{{ route('student.runtest') }}",
                            method: "POST",
                            data: {
                                code: editor.getSession().getValue(),
                                question_id: "{{ $soal[0]->id }}",
                                user_id: "{{ Auth::user()->id }}",
                                exercise_id: "{{ $exercise_id }}",
                                time_left: remaining // <-- tambahkan ini
                            },
                            success: function(response) {
                                $("#run-output").html(response.run_output ? response.run_output : '');
                                $("#output").html(response.result);
                                $("#runButton").attr("disabled", false)
                                $("#runButton").html("<i class='fas fa-play'></i> Run");
                                $("#submitButton").attr("disabled", false);
                                $("#submitButton").html("<i class='fas fa-check'></i> Submit");

                            },
                            error: function() {
                                $(".output").html("Something went wrong!");
                                $("#runButton").attr("disabled", false)
                                $("#runButton").html("<i class='fas fa-play'></i> Run");
                                $("#submitButton").attr("disabled", false);
                                $("#submitButton").html("<i class='fas fa-check'></i> Submit");
                            }
                        });
                    }
                });

                $('#submitButton').click(function() {
                    $("#submitButton").attr("disabled", true);
                    $("#submitButton").html("<i class='fas fa-spinner'></i> Processing");
                    $("#runButton").attr("disabled", true);
                    $("#runButton").html("<i class='fas fa-ban'></i> Run");
                    $.ajax({
                        url: "{{ route('student.submittest') }}",
                        method: "POST",
                        data: {
                            code: editor.getSession().getValue(),
                            task_id: "{{ $soal[0]->id }}",
                            user_id: "{{ Auth::user()->id }}",
                            exercise_id: "{{ $exercise_id }}",
                            time_left: remaining // <-- tambahkan ini
                        },
                        success: function(response) {
                            $("#output").html(response.result);
                            $("#submitButton").attr("disabled", false)
                            $("#submitButton").html("<i class='fas fa-check'></i> Submit");
                            $("#runButton").attr("disabled", false);
                            $("#runButton").html("<i class='fas fa-play'></i> Run");
                            if (response.status == 'passed') {
                                toastr.success(response.message);
                            } else {
                                toastr.warning(response.message);
                            }
                        },
                        error: function() {
                            $("#output").html("Something went wrong!");
                            $("#submitButton").attr("disabled", false)
                            $("#submitButton").html("<i class='fas fa-check'></i> Submit");
                            $("#runButton").attr("disabled", false);
                            $("#runButton").html("<i class='fas fa-play'></i> Run");
                        }
                    });
                });

                $('#clearResult').click(function() {
                    const output = document.getElementById("output-text");
                    output.remove();
                });

            });
            $('#finishTestBtn').click(function() {
                if(confirm('Yakin ingin menyelesaikan latihan? Semua jawaban yang belum disubmit akan dianggap salah dan database akan dihapus!')) {
                    $.ajax({
                        url: "{{ route('student.finishTest') }}",
                        method: "POST",
                        data: {
                            exercise_id: "{{ $exercise_id }}",
                            user_id: "{{ Auth::user()->id }}",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            setTimeout(() => window.location.href = "{{ route('student.exercise') }}", 2000);
                        },
                        error: function() {
                            toastr.error('Gagal menyelesaikan tes!');
                        }
                    });
                }
            });
        $('#tabel_soal').DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('student.exerciseQuestion.questionList', ['exercise_id' => $exercise_id]) }}",
            columns: [
                { data: "no", name: "no" },
                { data: "title", name: "title" },
                { data: "topic", name: "topic" },
                { data: "description", name: "description" },
                { data: "actions", name: "actions" },
            ]
        });
        // Inisialisasi editor kode jika pakai library seperti Ace/Monaco, tambahkan di sini
    </script>
@endsection
