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
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" placeholder="Email Address" required disabled>

                        <div class="invalid-feedback">
                          Please Provide A Email Address.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="roles-{{ $row->id }}">Select Role</label>
                        <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." name="roles[]" style="width: 100%" id="roles-{{ $row->id }}" required>
                            @foreach( $roles as $role )
                            <option value="{{ $role->name }}"
                                @if(!empty($row->getRoleNames()))
                                    @foreach($row->getRoleNames() as $v)
                                        @if( ($role->name == $v) )
                                            selected
                                        @endif
                                    @endforeach
                                @endif
                            >
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select User Role.
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