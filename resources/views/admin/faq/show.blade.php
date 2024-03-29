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
                    <h4><span class="text-highlight">Question:</span> {{ $row->question }}</h4>
                    <hr/>
                    <p><span class="text-highlight">Category:</span> {{ $row->category->title }}</p>
                    <p><span class="text-highlight">Location:</span> {{ $row->location->title }}</p>

                    @if(!empty($row->video_id))
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $row->video_id }}?rel=0" allowfullscreen></iframe>
                    </div>
                    <br/>
                    @endif

                    @if(is_file('uploads/'.$url.'/'.$row->image))
                    <img src="{{ asset('uploads/'.$url.'/'.$row->image) }}" class="img-fluid" alt="Thumbnail image">
                    <br/><br/>
                    @endif

                    <p><span class="text-highlight">Answer:</span> {!! $row->answer !!}</p>
                    <p><span class="text-highlight">Asked By:</span> {!! $row->asked_by !!}</p>
                    <p><span class="text-highlight">Email:</span> {!! $row->email !!}</p>

                    <hr/>
                    <p><span class="text-highlight">Status:</span> 
                    @if( $row->status == 1 )
                    <span class="badge badge-success badge-pill">Active</span>
                    @elseif( $row->status == 2 )
                    <span class="badge badge-primary badge-pill">Pending</span>
                    @else
                    <span class="badge badge-danger badge-pill">Inactive</span>
                    @endif
                    </p>
                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->