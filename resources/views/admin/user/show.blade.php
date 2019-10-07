    <!-- Show modal content -->
    <div id="showModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ $title }} Details View</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Details View Start -->
                    <h4><span class="text-highlight">User Name:</span> {{ $row->name }}</h4>
                    <hr/>
                    <p><span class="text-highlight">Email :</span> {{ $row->email }}</p>

                    <hr/>
                    <p><span class="text-highlight">User Roles:</span> 
                        @if(!empty($row->getRoleNames()))
                            @foreach($row->getRoleNames() as $v)
                                <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                        @endif
                    </p>
                    <p><span class="text-highlight">Locations:</span> 
                        @foreach( $row->locations as $user_loc )
                            <label class="badge badge-primary">{{ $user_loc->title }}</label>
                        @endforeach
                    </p>
                    <p><span class="text-highlight">Categories:</span> 
                        @foreach( $row->categories as $user_cat )
                            <label class="badge badge-info">{{ $user_cat->title }}</label>
                        @endforeach
                    </p>
                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->