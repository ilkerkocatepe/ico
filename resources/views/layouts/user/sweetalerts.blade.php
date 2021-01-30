@if( session('success') )
    <script>
        $(document).ready(function() {
            swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500,
                buttonsStyling: false
            });
        });
    </script>
@endif

@if( session('error') )
    <script>
        $(document).ready(function() {
            swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1500,
                buttonsStyling: false
            });
        });
    </script>
@endif

@if( session('warning') )
    <script>
        $(document).ready(function() {
            swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: '{{ session('warning') }}',
                showConfirmButton: false,
                timer: 1500,
                buttonsStyling: false
            });
        });
    </script>
@endif
@if( session('message') )
    <script>
        $(document).ready(function() {
            swal.fire({
                position: 'top-end',
                icon: 'info',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 1500,
                buttonsStyling: false
            });
        });
    </script>
@endif
