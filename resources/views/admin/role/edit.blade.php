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
                        <label for="name">Role Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $row->name }}" placeholder="Role Name" required>

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
                        <label for="permission-{{ $row->id }}-{{ $value->id }}">
                            <input type="checkbox" class="form-control" name="permission[]" id="permission-{{ $row->id }}-{{ $value->id }}" value="{{ $value->id }}" 

                            @if(!empty($row->getPermissionNames()))
                                @foreach($row->getPermissionNames() as $v)

                                    @if($value->name == $v) checked @endif

                                @endforeach
                            @endif

                             data-plugin="switchery" data-color="#1bb99a" data-size="small" >
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->