<!-- jQuery library js -->
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap js -->
<script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
<!-- Apex Chart js -->
<script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
<!-- Data Table js -->
<script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
<!-- Iconify Font js -->
<script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
<!-- jQuery UI js -->
<script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
<!-- Vector Map js -->
<script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- Popup js -->
<script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
<!-- Slick Slider js -->
<script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
<!-- main js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<script src="{{ asset('assets/js/homeTwoChart.js') }}"></script>
<!-- Calendar -->
<script src="{{asset('assets/js/full-calendar.js')}}"></script>
<!-- flatpicker -->
<script src="{{asset('assets/js/flatpickr.js')}}"></script>

<!-- Text editor -->
<script src="{{ asset('assets/js/editor.highlighted.min.js') }}"></script>
<script src="{{ asset('assets/js/editor.quill.js') }}"></script>
<script src="{{ asset('assets/js/editor.katex.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Lightbox JS -->
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

<script>
    setTimeout(function () {
        $('.alert').remove();
    }, 3000);

    $('.remove-button').on('click', function () {
        $(this).closest('.alert').addClass('d-none')
    });

    // let lightbox = GLightbox({
    //     touchNavigation: true,
    //     loop: false,
    //     iframe: false,
    //     width: "90vw",
    //     height: "90vh"
    // });

    let lightbox = GLightbox({
        selector: '.glightbox'
    });

</script>