@extends('user.teacher.master') @section('title')
    iCLOP | Soal Latihan
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Soal Latihan</p>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <form action="{{ route('teacher.exercise.getExerciseIDForDataTable') }}" method="POST"
                        id="select_exercise_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <select name="academic_year_id" class="form-control" id="year-dropdown">
                                            <option value="" disabled selected>Tahun Ajaran</option>
                                            @forelse ($year as $item)
                                                <option value="{{ $item->{'id'} }}">{{ $item->{'name'} }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No Data
                                                </option>
                                            @endforelse
                                        </select>
                                        <span class="text-danger error-text year_academic_id_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="exercise_id" class="form-control" id="exercise-dropdown">
                                        <option value="" disabled selected>Latihan</option>
                                    </select>
                                    <span class="text-danger error-text exercise_id_error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Pilih</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <table id="exercise_question_table" class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                            <th>No</th>
                            <th>Soal</th>
                            <th>Topik</th>
                            <th>Hapus</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="col-lg-6 col-12">
                    <table id="all_question_table" class="table table-hover table-head-fixed text-nowrap"
                        style="width: 100%">
                        <thead>
                            <th>Soal</th>
                            <th>Topik</th>
                            <th>Tambahkan</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('user.teacher.exerciseQuestion.modal-edit-exerciseQuestion')
    </div>
@endsection
@section('script')
    <script>
        let exercie_id = -1;

        $("#all_question_table").DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('teacher.exerciseQuestion.getDataTable') }}",
            columns: [{
                    data: "title",
                    name: "title",
                },
                {
                    data: "topic",
                    name: "topic",
                },
                {
                    data: "actions",
                    name: "actions",
                },
            ],
        });

        $("#exercise_question_table").DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: "{{ route('teacher.exerciseQuestion.getDataTableByExercise', ['exercise_id' => $exercise_id]) }}",
            columns: [{
                    data: "no",
                    name: "no",
                },
                {
                    data: "title",
                    name: "title",
                },
                {
                    data: "topic",
                    name: "topic",
                },
                {
                    data: "actions",
                    name: "actions",
                },
            ],
        });

        $('#year-dropdown').on('change', function() {
            var yid = this.value;
            $("#exercise-dropdown").html('');
            $.ajax({
                url: "{{ route('teacher.exercise.getExerciseAsOption') }}",
                type: "POST",
                data: {
                    yid: yid,
                },
                dataType: 'json',
                success: function(result) {
                    $('#exercise-dropdown').html('<option value="" disabled selected>Latihan</option>');
                    $.each(result.exercise, function(key, value) {
                        $("#exercise-dropdown").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        $("#select_exercise_form").on("submit", function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr("action"),
                method: $(form).attr("method"),
                data: new FormData(form),
                processData: false,
                dataType: "json",
                contentType: false,
                beforeSend: function() {
                    $(this).find("span.error-text").text("");
                },
                success: function(data) {
                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form)
                                .find("span." + prefix + "_error")
                                .text(val[0]);
                        });
                    } else {
                        exercie_id = data.msg;
                        alert(exercie_id);
                        var url =
                            "{{ route('teacher.exerciseQuestion.getDataTableByExercise', ['exercise_id' => 99]) }}"
                            .replace("99", data.msg);
                        $("#exercise_question_table").DataTable().ajax.url(url).load();
                    }
                },
            });
        });

        $(document).on("click", "#assignQuestionToExerciseBtn", function() {
            const question_id = $(this).data("id");
            const url = "{{ route('teacher.exerciseQuestion.getExerciseQuestion') }}";
            if (exercie_id == -1) {
                alert('Silakah pilih latihan terlebih dahulu!');
            } else {
                $(".modalEditExerciseQuestion").find("form")[0].reset();
                $.get(
                    url, {
                        question_id: question_id,
                        exercise_id: exercie_id

                    },
                    function(data) {
                        const modal = $(".modalEditExerciseQuestion");
                        $(modal)
                            .find("form")
                            .find('input[name="qid"]')
                            .val(data.questionDetails[0].id);
                        $(modal)
                            .find("form")
                            .find('input[name="eid"]')
                            .val(data.exerciseDetails[0].id);
                        $(modal)
                            .find("form")
                            .find('input[name="question_title"]')
                            .val(data.questionDetails[0].title);
                        $(modal)
                            .find("form")
                            .find('input[name="name"]')
                            .val(data.exerciseDetails[0].name);
                        $(modal).modal("show");
                    },
                    "json"
                );
            }
        });


        $("#form_update_data").on("submit", function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr("action"),
                method: $(form).attr("method"),
                data: new FormData(form),
                processData: false,
                dataType: "json",
                contentType: false,
                beforeSend: function() {
                    $(this).find("span.error-text").text("");
                },
                success: function(data) {
                    if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form)
                                .find("span." + prefix + "_error")
                                .text(val[0]);
                        });
                    } else {
                        $("#all_question_table")
                            .DataTable()
                            .ajax.reload(null, false);

                        var newurl =
                            "{{ route('teacher.exerciseQuestion.getDataTableByExercise', ['exercise_id' => -1]) }}"
                            .replace("-1", exercie_id);
                        $("#exercise_question_table").DataTable().ajax.url(newurl).load();

                        $(".modalEditExerciseQuestion").modal("hide");
                        $(".modalEditExerciseQuestion").find("form")[0].reset();
                        toastr.success(data.msg);
                    }
                },
            });
        });

        $(document).on("click", "#removeQuestionFromExerciseBtn", function() {
            const question_id = $(this).data('id');
            alert(exercie_id);
            const url = "{{ route('teacher.exerciseQuestion.removeExerciseQuestion') }}"
            if (confirm("Hapus Soal dari daftar Pertanyaan?")) {
                $.post(url, {
                    question_id: question_id,
                    exercise_id: exercie_id
                }, function(data) {
                    if (data.code == 1) {
                        $('#all_question_table').DataTable().ajax.reload(null, false);
                        var newurl =
                            "{{ route('teacher.exerciseQuestion.getDataTableByExercise', ['exercise_id' => -1]) }}"
                            .replace("-1", exercie_id);
                        $("#exercise_question_table").DataTable().ajax.url(newurl).load();
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });
    </script>
@endsection
