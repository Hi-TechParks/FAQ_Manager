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
                        <label for="question">Question</label>
                        <input type="text" class="form-control" name="question" id="question" value="{{ $row->question }}" placeholder="Question" required>

                        <div class="invalid-feedback">
                          Please Provide FAQ Question.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category" id="category" required>
                            <option value="">Select Category</option>
                            @foreach( $categories as $category )
                            <option value="{{ $category->id }}" @if( $category->id == $row->category_id ) selected @endif>{{ $category->title }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select FAQ Category.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <select class="form-control" name="location" id="location" required>
                            <option value="">Select Location</option>
                            @foreach( $locations as $location )
                            <option value="{{ $location->id }}" @if( $location->id == $row->location_id ) selected @endif>{{ $location->title }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select FAQ Location.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <textarea class="form-control summernote" name="answer" id="answer" rows="8" required>{{ $row->answer }}</textarea>

                        <div class="invalid-feedback">
                          Please Provide FAQ Answer.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Thumb</label>
                        <input type="file" class="form-control" name="image" id="image" placeholder="Upload File">

                        <div class="invalid-feedback">
                          Please Provide Thumb Image.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="video_id">Youtube Video ID</label>
                        <input type="text" class="form-control" name="video_id" id="video_id" value="{{ $row->video_id }}" placeholder="Video ID">

                        <div class="invalid-feedback">
                          Please Provide Youtube Video ID.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Select Status</label>
                        <select class="wide" name="status" id="status" data-plugin="customselect">
                            <option value="1" @if( $row->status == 1 ) selected @endif>Active</option>
                            <option value="2" @if( $row->status == 2 ) selected @endif>Pending</option>
                            <option value="0" @if( $row->status == 0 ) selected @endif>Inactive</option>
                        </select>
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