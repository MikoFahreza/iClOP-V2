@extends('postgre.user.student.master') @section('title')
    iCLOP | Daftar Soal
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Daftar Soal</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row" style="height: 600px;">
                <!-- Kiri: Preview Guidance -->
                <div class="col-md-4">
                    @if(count($soal) > 0)
                        <embed src="{{ Storage::disk('public')->url('function_guidance/' . $soal[0]->guide) }}" type="application/pdf"
                            style="width: 100%; height: 500px;">
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
                                    onclick="window.location.href='/s/exercise-question/question/{{ $soal[0]->exercise_id }}/{{ $soal[0]->no - 1 }}'"><i
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
                                    onclick="window.location.href='/s/exercise-question/question/{{ $soal[0]->exercise_id }}/{{ $soal[0]->no + 1 }}'">
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
                                data-placement="bottom" title="Submit"><i class="fa fa-check-double"></i></button>
                        </div>
                    </div>
                    <!-- Output/Alert -->
                    <div id="output" class="row mt-3" style="min-height: 120px;"></div>
                </div>
                <!-- Kanan: Navbar Soal -->
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" style="height: 100%; overflow-y: auto; border-left: 1px solid #eee;">
                        @foreach($soal as $s)
                            <a 
                                class="nav-link {{ $s->id == $soal[0]->id ? 'active' : '' }}" 
                                href="/s/exercise-question/question/{{ $s->exercise_id }}/{{ $s->no }}">
                                {{ $s->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            },
                            success: function(response) {
                                //$(".output").html(response);
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
                            user_id: "{{ Auth::user()->id }}"
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
