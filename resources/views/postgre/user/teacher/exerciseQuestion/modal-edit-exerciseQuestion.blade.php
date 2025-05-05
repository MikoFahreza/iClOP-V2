<!-- Modal -->
<div class="modal fade modalEditExerciseQuestion" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Latihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('teacher.exerciseQuestion.addExerciseQuestion') }}" enctype="multipart/form-data"
                    method="POST" id="form_update_data">
                    @csrf
                    <input type="hidden" name="qid" />
                    <input type="hidden" name="eid" />
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="title">Nama Soal</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="question_title" placeholder="Nama soal"
                                    readonly />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text title_error"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="name">Latihan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Nama latihan"
                                    readonly />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="no">Nomor Soal</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="no" placeholder="Nomor soal" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-book"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger error-text no_error"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">Tambah</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
