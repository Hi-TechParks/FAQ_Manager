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
                        <label for="question">Question</label>
                        <input type="text" class="form-control" name="question" id="question" placeholder="Question" required>

                        <div class="invalid-feedback">
                          Please Provide FAQ Question.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category" id="category" required>
                            <option value="">Select Category</option>
                            @foreach( $categories as $category )
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
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
                            <option value="{{ $location->id }}">{{ $location->title }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select FAQ Location.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <textarea class="form-control summernote" name="answer" id="answer" rows="8" required></textarea>

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
                        <input type="text" class="form-control" name="video_id" id="video_id" placeholder="Video ID">

                        <div class="invalid-feedback">
                          Please Provide Youtube Video ID.
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