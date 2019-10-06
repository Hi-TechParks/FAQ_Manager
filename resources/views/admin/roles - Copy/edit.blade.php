    <!-- Edit modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ URL::route($url.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit {{ $title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $row->name }}" placeholder="User Name" required>

                        <div class="invalid-feedback">
                          Please Provide A User Name.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Permission</label>

                        @foreach($permission as $value)
                        <label for="permission">
                            <input type="checkbox" class="form-control" name="permission[]" id="permission" value="{{ $value->id }}" @if($value->id == $rolePermissions) checked @endif>
                            {{ $value->name }}
                        </label>
                        @endforeach

                        <div class="invalid-feedback">
                          Please Provide Permissions.
                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->