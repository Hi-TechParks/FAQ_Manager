    <!-- Add modal content -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ URL::route($url.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add {{ $title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Role Name" required>

                        <div class="invalid-feedback">
                          Please Provide A Role Name.
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="">Permissions</label>
                        </div>

                        @foreach($permission as $value)
                        <div class="col-sm-12">
                        <label for="permission-{{ $value->id }}">
                            <input type="checkbox" class="form-control" name="permission[]" id="permission-{{ $value->id }}" value="{{ $value->id }}" data-plugin="switchery" data-color="#1bb99a" data-size="small">
                            {{ $value->name }}
                        </label>
                        </div>
                        @endforeach

                        <div class="invalid-feedback">
                          Please Provide Minimum One Permissions.
                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->