<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">Anything you want</div>
    <strong>
        Copyright &copy; 2014-2025&nbsp;
        <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
    </strong>
    All rights reserved.
</footer>

<!-- Toast Tag -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast toast-custom" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-chat-square-dots-fill me-2"></i>
            <div class="me-auto">{{ config('app.name') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close">
                <i class="bi bix"></i>
            </button>
        </div>
        <div class="toast-body">
        </div>
    </div>
</div>

</div>
<script src="{{ asset('assets/plugins/overlayscrollbars/js/overlayscrollbars.browser.es6.min.js') }}"></script>
<script src="{{ asset('assets/plugins/popper.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('assets/plugins/dataTables/js/datatables.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/adminlte.js') }}"></script>
<script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
</script>
@stack('script')
</body>

</html>
