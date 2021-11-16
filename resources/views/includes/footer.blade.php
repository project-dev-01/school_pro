<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                2015 - <script>
                    document.write(new Date().getFullYear())
                </script> &copy; by <a href="https://aibots.my/">Aibots Sdn Bhd</a>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Vendor js -->
<script src="{{ asset('js/vendor.min.js') }}"></script>

<!-- Plugins js-->
<script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
<!-- <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script> -->

<script src="{{ asset('libs/selectize/js/standalone/selectize.min.js') }}"></script>

<!-- Dashboar 1 init js-->
<!-- <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script> -->

<!-- App js-->
<script src="{{ asset('js/app.min.js') }}"></script>

<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<!-- Add croptool plugin -->
<script src="{{ asset('ijaboCropTool/ijaboCropTool.min.js') }}"></script>

<!-- <script src="{{ asset('js/validation/validation.js') }}"></script> -->
<script>
    toastr.options.preventDuplicates = true;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // class routes
    var classList = "{{ route('classes.list') }}";
    var classes = "{{ route('super_admin.classes')}}";
    var deleteClasses = "{{ route('classes.delete')}}";
    var classDetails = "{{ route('classes.details') }}";

    // users routes
    var userList = "{{ route('users.user_list') }}";
    var userShow = "{{ route('users.user') }}";
    var deleteUser = "{{ route('users.delete') }}";

    // setting routes
    var pictureUpdateUrl = "{{ route('pictureUpdate') }}";
    // section routes
    var sectionList = "{{ route('section.list') }}";
    var sectionDetails = "{{ route('section.details') }}";
    var sectionDelete = "{{ route('section.delete') }}";

</script>
<!-- custom js  -->
<script src="{{ asset('js/custom/classes.js') }}"></script>
<script src="{{ asset('js/custom/user_list.js') }}"></script>
<script src="{{ asset('js/custom/settings.js') }}"></script>
<script src="{{ asset('js/custom/section.js') }}"></script>
