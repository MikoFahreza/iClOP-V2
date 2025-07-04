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
                        <!-- Guidance ini akan tetap sama untuk semua soal dalam satu exercise -->
                        <!-- Tidak akan di-reload saat navigasi antar soal -->
                        <iframe id="guidance-iframe" 
                                src="{{ Storage::disk('public')->url('function_guidance/' . $soal[0]->guide) }}" 
                                style="width: 100%; height: 500px; border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        </iframe>
                        <!-- Fallback untuk browser yang tidak support iframe -->
                        <!-- <embed src="{{ Storage::disk('public')->url('function_guidance/' . $soal[0]->guide) }}" type="application/pdf"
                        style="width: 100%; height: 500px;"> -->
                    @endif
                </div>
                <!-- Tengah: Editor dan Output -->
                <div class="col-md-5 d-flex flex-column">
                    <div class="editor" id="editor" style="height: 200px;"></div>
                    <!-- <div class="row mt-3">
                        <div class="col-6">
                            @if ($soal[0]->no <= 1)
                                <button class="btn btn-primary w-100" data-toggle="tooltip" data-placement="bottom"
                                    title="Sebelumnya" disabled><i class="fa fa-angle-left"></i></button>
                            @else
                                <button id="prevBtn" class="btn btn-primary w-100" data-toggle="tooltip"
                                    data-placement="bottom" title="Sebelumnya"
                                    onclick="navigateToQuestion({{ $soal[0]->no - 1 }})"><i
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
                                    onclick="navigateToQuestion({{ $soal[0]->no + 1 }})">
                                    <i class="fa fa-angle-right"></i></button>
                            @endif
                        </div>
                    </div> -->
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
                                    href="javascript:void(0)"
                                    onclick="navigateToQuestion({{ $s->no }})">
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
        <i class="fa fa-flag-checkered"></i> Selesaikan Tes
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
        var currentExerciseId = {{ $exercise_id }};
        
        // Fungsi untuk navigasi ke soal lain tanpa refresh
        function navigateToQuestion(questionNo) {
            console.log('Navigating to question:', questionNo);
            console.log('Editor status:', typeof editor, editor ? 'initialized' : 'not initialized');
            
            // Set flag untuk mencegah drop database saat navigasi internal
            isNavigatingWithinExercise = true;
            
            // Tampilkan loading di output saja, jangan di editor
            $('#output').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
            $('#run-output').html('');
            
            // AJAX request untuk mendapatkan data soal baru
            $.ajax({
                url: '/s/exercise-question/' + currentExerciseId + '/' + questionNo,
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    // Debug: log response untuk memastikan data benar
                    console.log('AJAX Response:', response);
                    
                    // Pastikan response memiliki data yang diperlukan
                    if (response && response.soal) {
                        // Update konten tanpa refresh file guidance
                        updateQuestionContent(response);
                        
                        // Update URL tanpa refresh
                        window.history.pushState({}, '', '/s/exercise-question/' + currentExerciseId + '/' + questionNo);
                        
                        // Reset flag setelah navigasi berhasil
                        isNavigatingWithinExercise = false;
                    } else {
                        console.error('Invalid response format:', response);
                        // Fallback ke refresh jika data tidak valid
                        window.location.href = '/s/exercise-question/' + currentExerciseId + '/' + questionNo;
                    }
                },
                error: function(xhr, status, error) {
                    // Jika AJAX gagal, clear loading dan restore editor
                    $('#output').html('<div class="alert alert-danger">Error loading question: ' + error + '</div>');
                    
                    // Pastikan editor kembali normal
                    if (typeof editor !== 'undefined') {
                        $('#editor').show();
                    }
                    
                    // Reset flag
                    isNavigatingWithinExercise = false;
                    
                    // Fallback ke refresh jika AJAX gagal
                    console.log('AJAX failed, falling back to page refresh');
                    setTimeout(function() {
                        window.location.href = '/s/exercise-question/' + currentExerciseId + '/' + questionNo;
                    }, 1000);
                }
            });
        }
        
        // Fungsi untuk update konten soal
        function updateQuestionContent(data) {
            // Simpan response terakhir untuk digunakan di fungsi lain
            window.lastResponse = data;
            
            // Update title
            $('h2').text(data.soal.name);
            
            // Pastikan editor sudah ter-inisialisasi dan clear loading
            if (typeof editor !== 'undefined' && editor !== null) {
                // Reset kode editor
                editor.setValue('');
                editor.clearSelection();
                // Pastikan editor terlihat dan tidak ada loading
                $('#editor').show();
                console.log('Editor sudah tersedia, direset untuk soal baru');
            } else {
                // Jika editor belum ada, inisialisasi ulang
                console.log('Editor tidak ditemukan, mencoba inisialisasi ulang...');
                // Pastikan div editor ada
                if ($('#editor').length > 0) {
                    // Tunggu sebentar lalu coba inisialisasi
                    setTimeout(function() {
                        if (typeof ace !== 'undefined') {
                            try {
                                editor = ace.edit("editor");
                                editor.setTheme("ace/theme/monokai");
                                editor.session.setMode("ace/mode/pgsql");
                                editor.setOptions({
                                    enableBasicAutocompletion: true,
                                    enableSnippets: true,
                                    enableLiveAutocompletion: true,
                                    fontSize: "12pt"
                                });
                                console.log('Editor berhasil diinisialisasi ulang');
                            } catch(e) {
                                console.error('Error inisialisasi editor:', e);
                            }
                        } else {
                            console.error('Ace editor library tidak tersedia');
                        }
                    }, 100);
                } else {
                    console.error('Div editor tidak ditemukan');
                }
            }
            
            // Clear loading dari output
            $('#output').html('');
            $('#run-output').html('');
            
            // Update navigation buttons
            updateNavigationButtons(data.soal.no, data.jumlah_soal);
            
            // Update active state di sidebar
            updateSidebarActive(data.soal.id);
            
            // Update form data untuk AJAX requests
            updateFormData(data.soal.id);
            
            // Reset button states
            resetButtonStates();
            
            // Cek status submission untuk soal baru
            checkSubmissionStatus(data.soal.id);
            
            // TIDAK UPDATE IFRAME GUIDANCE - biarkan tetap sama
            // Iframe guidance akan tetap menampilkan file yang sama untuk semua soal dalam satu exercise
            console.log('Guidance iframe tidak di-reload - tetap menampilkan file yang sama untuk semua soal dalam exercise ini');
        }
        
        // Fungsi untuk update navigation buttons
        function updateNavigationButtons(currentNo, totalQuestions) {
            // Previous button
            if (currentNo <= 1) {
                $('#prevBtn').prop('disabled', true).attr('onclick', '');
            } else {
                $('#prevBtn').prop('disabled', false).attr('onclick', 'navigateToQuestion(' + (currentNo - 1) + ')');
            }
            
            // Next button
            if (currentNo >= totalQuestions) {
                $('#nextBtn').prop('disabled', true).attr('onclick', '');
            } else {
                $('#nextBtn').prop('disabled', false).attr('onclick', 'navigateToQuestion(' + (currentNo + 1) + ')');
            }
        }
        
        // Fungsi untuk update active state di sidebar
        function updateSidebarActive(questionId) {
            // Remove active class from all nav links
            $('.nav-link').removeClass('active');
            
            // Find the nav link that corresponds to the current question
            // We'll use a simple approach - find by the question number in the response
            var currentQuestionNo = null;
            if (window.lastResponse && window.lastResponse.soal) {
                currentQuestionNo = window.lastResponse.soal.no;
            }
            
            if (currentQuestionNo) {
                $('.nav-link').each(function() {
                    var onclick = $(this).attr('onclick');
                    if (onclick) {
                        var match = onclick.match(/navigateToQuestion\((\d+)\)/);
                        if (match && parseInt(match[1]) === currentQuestionNo) {
                            $(this).addClass('active');
                            return false; // Break the loop
                        }
                    }
                });
            }
        }
        
        // Fungsi untuk reset button states
        function resetButtonStates() {
            $("#runButton").attr("disabled", false).html("<i class='fas fa-play'></i> Run");
            $("#submitButton").attr("disabled", false).html("<i class='fas fa-check'></i> Submit");
        }
        
        // Fungsi untuk cek status submission
        function checkSubmissionStatus(questionId) {
            // Hanya untuk display, tidak disable tombol submit
            $.ajax({
                url: "{{ route('student.checkSubmissionStatus') }}",
                method: "POST",
                data: {
                    question_id: questionId,
                    exercise_id: currentExerciseId,
                    user_id: "{{ Auth::user()->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Tidak ada action khusus, user bisa submit berkali-kali
                }
            });
        }
        
        // Fungsi untuk update form data
        function updateFormData(questionId) {
            // Update question_id dan task_id di semua AJAX request
            window.currentQuestionId = questionId;
        }
        
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
            isManualFinish = true; // Set flag untuk prevent beforeunload
            
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
                    isManualFinish = false; // Reset flag jika gagal
                }
            });
        }
        
        // Fungsi untuk drop database saat keluar halaman
        function dropDatabaseOnExit() {
            console.log('Attempting to drop database...');
            
            // Untuk back button, gunakan synchronous request yang lebih reliable
            const isBackButton = window.performance && window.performance.navigation && 
                                 window.performance.navigation.type === 2;
            
            if (isBackButton || !navigator.sendBeacon) {
                console.log('Using synchronous AJAX (back button or no sendBeacon support)');
                // Gunakan synchronous AJAX untuk back button
                try {
                    $.ajax({
                        url: "{{ route('student.dropDatabase') }}",
                        method: "POST",
                        data: {
                            exercise_id: "{{ $exercise_id }}",
                            user_id: "{{ Auth::user()->id }}",
                            _token: "{{ csrf_token() }}"
                        },
                        async: false, // Pastikan request selesai sebelum halaman tertutup
                        success: function(response) {
                            console.log('Database dropped successfully:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error dropping database:', error);
                        }
                    });
                } catch(e) {
                    console.error('AJAX error:', e);
                }
            } else {
                console.log('Using navigator.sendBeacon');
                const data = new FormData();
                data.append('exercise_id', '{{ $exercise_id }}');
                data.append('user_id', '{{ Auth::user()->id }}');
                data.append('_token', '{{ csrf_token() }}');
                
                const success = navigator.sendBeacon("{{ route('student.dropDatabase') }}", data);
                console.log('SendBeacon result:', success);
                
                // Backup dengan synchronous AJAX jika sendBeacon gagal
                if (!success) {
                    console.log('SendBeacon failed, using synchronous AJAX as backup');
                    try {
                        $.ajax({
                            url: "{{ route('student.dropDatabase') }}",
                            method: "POST",
                            data: {
                                exercise_id: "{{ $exercise_id }}",
                                user_id: "{{ Auth::user()->id }}",
                                _token: "{{ csrf_token() }}"
                            },
                            async: false,
                            success: function(response) {
                                console.log('Database dropped successfully (backup):', response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error dropping database (backup):', error);
                            }
                        });
                    } catch(e) {
                        console.error('AJAX backup error:', e);
                    }
                }
            }
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
        
        // Deteksi jika user menutup tab/browser
        let isPageHidden = false;
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                isPageHidden = true;
                // Jika user menyembunyikan tab, tunggu sebentar untuk melihat apakah mereka kembali
                setTimeout(() => {
                    if (isPageHidden && !isManualFinish && !isNavigatingWithinExercise) {
                        // User mungkin menutup tab, drop database
                        dropDatabaseOnExit();
                    }
                }, 5000); // Tunggu 5 detik
            } else {
                isPageHidden = false;
            }
        });
        
        // Alert saat user ingin keluar dari halaman
        window.onbeforeunload = function(e) {
            if (!isManualFinish && !isNavigatingWithinExercise) {
                // Drop database
                dropDatabaseOnExit();
                
                // Browser akan menampilkan dialog default dengan pesan standar
                // Kita tidak bisa mengubah teks dialog di browser modern
                return 'Jika Anda keluar dari halaman, database akan dihapus dan jika ada soal bersambung maka jawaban sebelumnya perlu disubmit ulang, yakin ingin keluar?';
            }
        };
        
        // Tambahan: Handle saat user benar-benar keluar (backup)
        window.addEventListener('unload', function() {
            if (!isManualFinish && !isNavigatingWithinExercise) {
                dropDatabaseOnExit();
            }
        });
        
        // Tambahan: pagehide event lebih reliable untuk mobile browsers
        window.addEventListener('pagehide', function() {
            if (!isManualFinish && !isNavigatingWithinExercise) {
                dropDatabaseOnExit();
            }
        });
        
        // Flag untuk menandai bahwa user sedang finish test secara manual
        var isManualFinish = false;
        var isNavigatingWithinExercise = false;
        
        // Reset timer jika latihan selesai manual
        $('#finishTestBtn').click(function() {
            if(confirm('Yakin ingin menyelesaikan latihan? Database akan dihapus!')) {
                isManualFinish = true; // Set flag untuk prevent beforeunload
                localStorage.removeItem(timerKey);
                
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
                        isManualFinish = false; // Reset flag jika gagal
                    }
                });
            }
        });
        
        // Inisialisasi timer saat halaman siap
        $(document).ready(function() {
            console.log('Document ready - checking editor status...');
            
            // Cek apakah editor sudah diinisialisasi
            setTimeout(function() {
                if (typeof editor !== 'undefined' && editor !== null) {
                    console.log('Editor sudah diinisialisasi dengan benar');
                } else {
                    console.log('Editor belum diinisialisasi, mencoba inisialisasi manual...');
                    if (typeof ace !== 'undefined') {
                        try {
                            editor = ace.edit("editor");
                            editor.setTheme("ace/theme/monokai");
                            editor.session.setMode("ace/mode/pgsql");
                            editor.setOptions({
                                enableBasicAutocompletion: true,
                                enableSnippets: true,
                                enableLiveAutocompletion: true,
                                fontSize: "12pt"
                            });
                            console.log('Editor berhasil diinisialisasi secara manual');
                        } catch(e) {
                            console.error('Error inisialisasi editor manual:', e);
                        }
                    }
                }
            }, 1000); // Tunggu 1 detik untuk memastikan ace sudah dimuat
            
            updateTimerDisplay();
            startTimer();
            
            // Set initial question ID
            window.currentQuestionId = "{{ $soal[0]->id }}";
            
            // Cek status submission saat halaman dibuka
            checkSubmissionStatus(window.currentQuestionId);
            
            // Prevent browser back button - push state to history
            window.history.pushState(null, null, window.location.pathname);
            
            // Handle browser back button dengan lebih aggressive
            window.addEventListener('popstate', function(event) {
                console.log('Popstate event triggered');
                if (!isManualFinish && !isNavigatingWithinExercise) {
                    // Prevent the default navigation first
                    event.preventDefault();
                    
                    // Show custom confirmation dialog
                    const userConfirmed = confirm('Jika Anda keluar dari halaman, database akan dihapus dan jika ada soal bersambung maka jawaban sebelumnya perlu disubmit ulang, yakin ingin keluar?');
                    
                    if (userConfirmed) {
                        // User confirmed, drop database and allow navigation
                        isManualFinish = true; // Set flag to prevent further database drops
                        dropDatabaseOnExit();
                        
                        // Navigate back after a short delay to ensure database drop completes
                        setTimeout(() => {
                            window.location.href = "{{ route('student.exercise') }}";
                        }, 500);
                    } else {
                        // User cancelled, stay on page - push current state back
                        window.history.pushState(null, null, window.location.pathname);
                    }
                } else {
                    // Allow normal navigation if flags are set
                    window.history.pushState(null, null, window.location.pathname);
                }
            });
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
                                question_id: window.currentQuestionId || "{{ $soal[0]->id }}",
                                user_id: "{{ Auth::user()->id }}",
                                exercise_id: "{{ $exercise_id }}",
                                time_left: remaining // <-- tambahkan ini
                            },
                            success: function(response) {
                                $("#run-output").html(response.run_output ? response.run_output : '');
                                $("#output").html(response.result);
                                $("#runButton").attr("disabled", false)
                                $("#runButton").html("<i class='fas fa-play'></i> Run");
                                
                                // Re-enable submit button
                                $("#submitButton").attr("disabled", false);
                                $("#submitButton").html("<i class='fas fa-check'></i> Submit");
                            },
                            error: function() {
                                $(".output").html("Something went wrong!");
                                $("#runButton").attr("disabled", false)
                                $("#runButton").html("<i class='fas fa-play'></i> Run");
                                
                                // Re-enable submit button
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
                            task_id: window.currentQuestionId || "{{ $soal[0]->id }}",
                            user_id: "{{ Auth::user()->id }}",
                            exercise_id: "{{ $exercise_id }}",
                            time_left: remaining // <-- tambahkan ini
                        },
                        success: function(response) {
                            $("#output").html(response.result);
                            $("#submitButton").attr("disabled", false);
                            $("#submitButton").html("<i class='fas fa-check'></i> Submit");
                            $("#runButton").attr("disabled", false);
                            $("#runButton").html("<i class='fas fa-play'></i> Run");

                            if (response.status == 'passed') {
                                toastr.success(response.message);
                                // Hapus disable submit button, user bisa submit berkali-kali
                            } else {
                                toastr.warning(response.message);
                            }
                        },
                        error: function() {
                            $("#output").html("Something went wrong!");
                            $("#submitButton").attr("disabled", false);
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
