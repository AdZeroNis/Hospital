<script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{asset('Adminasset/js/adminlte.js')}}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(surgeryId) {
        Swal.fire({
            title: "آیا مطمئن هستید؟",
            text: "این عملیات قابل بازگشت نیست!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "بله، انجام شود!",
            cancelButtonText: "لغو"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + surgeryId).submit();
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://api.masoudebrahimi.com/assets/plugins/MD.BootstrapPersianDateTimePicker/jquery.md.bootstrap.datetimepicker.js"></script>

<script src="https://cdn.jsdelivr.net/npm/md.bootstrappersiandatetimepicker@4.2.6/dist/md.bootstrappersiandatetimepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/majidh1/JalaliDatePicker@latest/dist/jalalidatepicker.min.js"></script>


<script>
    $(document).ready(function() {
        $('#mySelect').select2();
    });
    $('#mySelect').on('change', function() {
    var selectedValues = $(this).val();
    console.log(selectedValues); // لیست مقادیر انتخاب شده را در کنسول چاپ می‌کند.
});

</script>

<script>
    document.getElementById('operation_id').addEventListener('change', function() {
        const selectedOptions = Array.from(this.selectedOptions);
        let totalAmount = 0;

        selectedOptions.forEach(option => {
            const price = parseInt(option.getAttribute('data-price'));
            totalAmount += price;
        });

        document.getElementById('total_amount').textContent = totalAmount.toLocaleString();
    });
</script>
<script>
    // فعال‌سازی دکمه زمانی که حداقل یک چک‌باکس انتخاب شده باشد
    const submitBtn = document.getElementById('submit-btn');
    const checkboxes = document.querySelectorAll('input[name="surgery_ids[]"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            submitBtn.disabled = !anyChecked;
        });
    });
</script>

    <script>
        // فعال‌سازی DatePicker روی فیلدهای تاریخ
        document.addEventListener('DOMContentLoaded', function () {
            jalaliDatepicker.init({
                // تنظیمات دلخواه
                minDate: "attr",
                maxDate: "attr",
                autoClose: true,
                showEmptyBtn: true,
                showTodayBtn: true,
                showCloseBtn: true,
            });

            // اعمال DatePicker روی فیلدهای دارای data-jdp
            jalaliDatepicker.bind(document.getElementById('surgeried_at'));
            jalaliDatepicker.bind(document.getElementById('released_at'));
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        jalaliDatepicker.startWatch({
            minDate: "attr",
            maxDate: "attr"
        });
    });
</script>

