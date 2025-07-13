<style>
    .app-footer {
        background-color: unset;
        border-top: 0;
        min-height: 1rem;
    }
</style>
<footer class="app-footer text-center pt-0 pb-3">
    <strong>
        Copyright &copy; 2014-2025&nbsp;
        <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
    </strong>
    All rights reserved.
</footer>

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
