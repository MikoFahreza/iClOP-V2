<!-- Modal -->
<div class="modal fade modalEditTahun" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tahun Ajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.academic_year.update') }}" enctype="multipart/form-data" method="POST"
                    id="form_update_data">
                    @csrf
                    <input type="hidden" name="yid" />
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="name">Nama</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Nama" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="semester">Semester</label>
                            <div class="input-group">
                                <select name="semester" class="form-control" id="semeseter">
                                    <option selected disabled>
                                        -- Semester --
                                    </option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text semester_error"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="start_date">Tanggal Mulai</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="start_date"
                                    placeholder="Tanggal mulai" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text start_date_error"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="end_date">Tanggal berkahir</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="end_date"
                                    placeholder="Tanggal berakhir" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text end_date_error"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">
                        Update
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
