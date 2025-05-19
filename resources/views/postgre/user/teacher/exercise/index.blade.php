@extends('postgre.user.teacher.master') @section('title')
    iCLOP | Latihan
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Kelas</p>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('content')
    <div class="content">
        <div class="container" id="class_container">
            <div class="row">
                <div class="col-lg-4">
                    <form action="{{ route('teacher.exercise.add') }}" method="POST" id="form_tambah_data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control form-control"
                                            placeholder="Nama latihan">
                                    </div>
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="year_id" class="form-control">
                                        <option value="" disabled selected>Tahun Ajaran</option>
                                        @forelse ($year as $item)
                                            <option value="{{ $item->{'id'} }}">{{ $item->{'name'} }}</option>
                                        @empty
                                            <option disabled>Not Found</option>
                                        @endforelse
                                    </select>
                                    <span class="text-danger error-text year_id_error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="description" class="form-control" placeholder="Deskripsi">
                                    <span class="text-danger error-text description_error"></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-info">Tambah</button>
                    </form>
                </div>
                <div class="col-lg-8">
                    <form action="" method="GET">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type your keywords here">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3">
                        @forelse ($exercise as $item)
                            <div class="col-lg-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <i class="fa-solid fa-building-columns"></i>
                                        </div>
                                        <hr>
                                        <h3 class="profile-username text-center">{{ $item->{'name'} }}</h3>
                                        <p class="text-center text-muted">
                                            {{ $item->year->{'name'} }}
                                        </p>
                                        <button class="btn btn-primary btn-block" id="exerciseDetailBtn"
                                            data-id={{ $item->{'id'} }}><b>Detail</b></button>
                                        <a href="{{ route('teacher.exerciseQuestion', ['exercise_id' => $item->{'id'}]) }}" class="btn btn-success btn-block"
                                            id="classStudentBtn" data-id={{ $item->{'id'} }}><b>Soal</b></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-4">
                                <code>No Data</code>
                            </div>
                        @endforelse
                    </div>
                    {{ $exercise->links() }}
                </div>
            </div>
            @include('postgre.user.teacher.exercise.modal-edit-exercise')
        </div>
    </div>
    @endsection @section('script')
    <script>
        $("#form_tambah_data").on("submit", function(e) {
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
                        $(form)[0].reset();
                        // alert(data.msg);
                        toastr.success(data.msg);
                        $("#class_container").load(location.href + " #class_container");
                    }
                },
            });
        });

        $(document).on("click", "#exerciseDetailBtn", function() {
            const eid = $(this).data("id");
            const url = "{{ route('teacher.exercise.detail') }}";
            $(".modalEditExercise").find("form")[0].reset();
            $.get(
                url, {
                    eid: eid
                },
                function(data) {
                    const exerciseModal = $(".modalEditExercise");
                    $(exerciseModal)
                        .find("form")
                        .find('input[name="eid"]')
                        .val(data.details[0].id);
                    $(exerciseModal)
                        .find("form")
                        .find('input[name="name"]')
                        .val(data.details[0].name);
                    $(exerciseModal)
                        .find("form")
                        .find('select[name="academic_year_id"]')
                        .val(data.details[0].academic_year_id);
                    $(exerciseModal)
                        .find("form")
                        .find('input[name="description"]')
                        .val(data.details[0].description);
                    $(exerciseModal).modal("show");
                },
                "json"
            );
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
                        $(".modalEditExercise").modal("hide");
                        $(".modalEditExercise").find("form")[0].reset();
                        toastr.success(data.msg);
                        $("#class_container").load(location.href + " #class_container");
                    }
                },
            });
        });
    </script>
@endsection
