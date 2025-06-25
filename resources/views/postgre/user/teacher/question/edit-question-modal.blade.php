<div class="modal fade editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-keyboard="false" data-backdrop="static" id="updateModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Update Data Pembelajaran<b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header"><b>Update Data Tugas<b></div>
                    <div class="card-body">
                        <form action="{{route('teacher.question.update')}}" enctype="multipart/form-data" method="POST"
                            id="update_question">
                            @csrf
                            <input type="hidden" name="qid">
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="title">Nama</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="title" placeholder="Nama tugas">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-book"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text title_error"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="topic">Topik</label>
                                    <div class="input-group">
                                        <select class="form-control" name="topic">
                                            <option selected disabled>- Pilih Topik -</option>
                                            <option value="ABS">ABS</option>
                                            <option value="LENGTH">LENGTH</option>
                                            <option value="CURRENT_DATE">CURRENT_DATE</option>
                                            <option value="SUM">SUM</option>
                                            <option value="AVG">AVG</option>
                                            <option value="MAX">MAX</option>
                                            <option value="MIN">MIN</option>
                                            <option value="SCALAR FUNCTION">SCALAR FUNCTION</option>
                                            <option value="SET RETURNING FUNCTION">SET RETURNING FUNCTION</option>
                                            <option value="TABLE RETURNING FUNCTION">TABLE RETURNING FUNCTION</option>
                                            <option value="SELECT FUNCTION">SELECT FUNCTION</option>
                                            <option value="CREATE PROCEDURE">CREATE PROCEDURE</option>
                                            <option value="ALTER PROCEDURE">ALTER PROCEDURE</option>
                                            <option value="CALL PROCEDURE">CALL PROCEDURE</option>
                                            <option value="DROP PROCEDURE">DROP PROCEDURE</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-list"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text topic_error"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-12">
                                    <label for="description">Deskripsi</label>
                                    <div class="input-group">
                                        <textarea rows="3" type="text" class="form-control" name="description"
                                            placeholder="Deskripsi soal"></textarea>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-sticky-note"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text description_error"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="test_code">Test Code</label>
                                    <span class="fas fa-question" data-toggle="tooltip_requiredTable"
                                        data-placement="right" title="Contoh tersedia pada button dibawah."></span>
                                    <div>
                                        <button type="button" class="toggleShowTestCodeBox btn btn-primary btn-sm mb-3"
                                            style="">Tampilkan
                                            Contoh</button>
                                    </div>
                                    <div class="testCodeBox" style="display: none;">
                                        <code style="display:block; white-space:pre-wrap">
                                                CREATE EXTENSION IF NOT EXISTS pgtap;
                                                CREATE OR REPLACE FUNCTION public.testschema()
                                                RETURNS SETOF TEXT LANGUAGE plpgsql AS $$
                                                BEGIN
                                                RETURN NEXT has_column( 'artists', 'id');
                                                RETURN NEXT col_type_is( 'artists', 'id', 'integer', 'Tipe kolom id adalah INTEGER');
                                                END;
                                                $$;
                                                SELECT * FROM runtests('public'::name);

                                                JIKA JAWABAN YANG DIHARAPKAN BERUPA SELECT
                                                    GUNAKAN TEMPLATE BERIKUT:
                                                    CREATE EXTENSION IF NOT EXISTS pgtap;
                                                    SELECT plan(1);
                                                    CREATE OR REPLACE FUNCTION test_jawaban(mahasiswa_query TEXT)
                                                    RETURNS SETOF TEXT LANGUAGE plpgsql AS $$
                                                    BEGIN
                                                    SET LOCAL pgtap.skip_plan = true;

                                                    RETURN NEXT results_eq(
                                                        mahasiswa_query,
                                                        'SELECT ABS(selisih_pembayaran) AS selisih_abs FROM transaksi WHERE id = 3', 
                                                        'Selisih pembayaran transaksi id 3 = 20000' 
                                                    ); -- sesuaikan dengan jawaban yang diharapkan
                                                    END;
                                                    $$;
                                            </code>
                                        <p>Dokumentasi selengkapnya dapat dilihat <a
                                                href="https://pgtap.org/documentation.html" target="_blank">disini</a>
                                        </p>
                                    </div>
                                    <div class="input-group">
                                        <textarea rows="5" type="text" class="form-control" name="test_code"
                                            placeholder="Test code soal"></textarea>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-code"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text test_code_error"></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>