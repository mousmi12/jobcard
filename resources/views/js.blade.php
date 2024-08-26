<!-- Core JS Files -->
<script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!-- Chart JS -->
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<!-- Notifications Plugin -->
<script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard -->
<script src="{{ asset('assets/js/now-ui-dashboard.min.js?v=1.5.0') }}" type="text/javascript"></script>
<!-- Now Ui Dashboard DEMO methods -->
<script src="{{ asset('assets/demo/demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
        demo.initDashboardPageCharts();
    });
</script>
