<!-- Center modal content -->
<div class="modal fade addClassModal" id="addClassModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myaddClassModalLabel">Add Class</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="classesForm" method="post" action="{{ route('classes.add') }}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="name">Class Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter class name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="name_numeric">Class Numeric</label>
                        <input type="text" id="name_numeric" name="name_numeric" class="form-control" placeholder="Enter class numeric">
                        <span class="text-danger error-text name_numeric_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" id="classSubmit" class="btn btn-success waves-effect waves-light">Submit</button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->