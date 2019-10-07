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

                    <div class="form-group">
                        <label for="locations-{{ $row->id }}">Select Location</label>
                        <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." name="locations[]" style="width: 100%" id="locations-{{ $row->id }}" required>
                            @foreach( $locations as $location )
                            <option value="{{ $location->id }}"
                                @if(!empty($row->locations))
                                    @foreach( $row->locations as $user_loc )
                                        @if( $location->id == $user_loc->id )
                                            selected
                                        @endif
                                    @endforeach
                                @endif
                            >
                                {{ $location->title }}
                            </option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select Location Permit.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="categories-{{ $row->id }}">Select Category</label>
                        <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." name="categories[]" style="width: 100%" id="categories-{{ $row->id }}" required>
                            @foreach( $categories as $category )
                            <option value="{{ $category->id }}"
                                @if(!empty($row->categories))
                                    @foreach( $row->categories as $user_cat )
                                        @if( $category->id == $user_cat->id )
                                            selected
                                        @endif
                                    @endforeach
                                @endif
                            >
                                {{ $category->title }}
                            </option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select Category Permit.
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