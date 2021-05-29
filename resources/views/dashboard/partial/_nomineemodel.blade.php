<div class="modal fade" id="nomineeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('nominee.store') }}" class="needs-validation"
                enctype="multipart/form-data">

                <div class="modal-header">
                    <h4 class="modal-title" id="nomineeModalLabel">Create Nominee</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            {{ csrf_field() }}
                            <div class="card">

                                <div class="body">

                                    <div class="row clearfix">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-line">

                                                    <input type="text" name="name"
                                                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                        value="{{ old('name') }}" placeholder="Nominee Name">
                                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row clearfix">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h6>Nominee Bio</h6>
                                                <div class="form-line">
                                                    <textarea name="bio" value="{{ old('bio') }}"
                                                        class="form-control {{ $errors->has('bio') ? ' is-invalid' : '' }}"
                                                        cols="5" rows="5">
                                                    </textarea>
                                                    <div class="invalid-feedback">{{ $errors->first('bio') }}</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">SAVE</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>

            </form>

        </div>
    </div>
</div>
