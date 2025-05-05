@extends('postgre.user.admin.master') @section('title')
    iCLOP | Kelas
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
                    <form action="{{ route('admin.class.add') }}" method="POST" id="form_tambah_data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control form-control"
                                            placeholder="Nama kelas">
                                    </div>
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="academic_year_id" class="form-control">
                                        <option value="" disabled selected>Tahun Ajaran</option>
                                        @forelse ($year as $item)
                                            <option value="{{ $item->{'id'} }}">{{ $item->{'name'} }}</option>
                                        @empty
                                            <option disabled>Not Found</option>
                                        @endforelse
                                    </select>
                                    <span class="text-danger error-text year_academic_id_error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="teacher_id" class="form-control">
                                        <option disabled selected>Dosen</option>
                                        @forelse ($teacher as $item)
                                            <option value="{{ $item->{'id'} }}">{{ $item->user->{'name'} }}</option>
                                        @empty
                                            <option disabled>Not Found</option>
                                        @endforelse
                                    </select>
                                    <span class="text-danger error-text teacher_id_error"></span>
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
                        @forelse ($classes as $item)
                            <div class="col-lg-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <i class="fa-solid fa-building-columns"></i>
                                        </div>
                                        <hr>
                                        <h3 class="profile-username text-center">{{ $item->{'name'} }}</h3>
                                        <p class="text-center text-muted">
                                            {{ $item->teacher->user->{'name'} }} <br>
                                            {{ $item->year->{'name'} }}
                                        </p>
                                        <button class="btn btn-primary btn-block" id="classDetailBtn"
                                            data-id={{ $item->{'id'} }}><b>Detail</b></button>
                                        <a href="{{route('admin.student')}}" class="btn btn-success btn-block" id="classStudentBtn"
                                            data-id={{ $item->{'id'} }}><b>Mahasiswa</b></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-4">
                                <code>No Data</code>
                            </div>
                        @endforelse
                    </div>
                    {{ $classes->links() }}
                </div>
            </div>
            @include('user.admin.class.modal-edit-class')
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

        $(document).on("click", "#classDetailBtn", function() {
            const class_id = $(this).data("id");
            const url = "{{ route('admin.class.detail') }}";
            $(".modalEditClass").find("form")[0].reset();
            $.get(
                url, {
                    class_id: class_id
                },
                function(data) {
                    const classModal = $(".modalEditClass");
                    $(classModal)
                        .find("form")
                        .find('input[name="cid"]')
                        .val(data.details[0].id);
                    $(classModal)
                        .find("form")
                        .find('input[name="name"]')
                        .val(data.details[0].name);
                    $(classModal)
                        .find("form")
                        .find('select[name="academic_year_id"]')
                        .val(data.details[0].academic_year_id);
                    $(classModal).modal("show");
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
                        $(".modalEditClass").modal("hide");
                        $(".modalEditClass").find("form")[0].reset();
                        toastr.success(data.msg);
                        $("#class_container").load(location.href + " #class_container");
                    }
                },
            });
        });
    </script>
@endsection
