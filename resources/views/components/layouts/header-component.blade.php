<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
<meta name="theme-color" content="#696cff" />
<title>@yield('title', 'ACI Healthcare')</title>
<meta name="description" content="" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet"
/>
<link rel="icon" href="{{ asset('admin/assets/img/icon/favicon.jpg') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-auth.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<!-- Datatable -->
<link rel="stylesheet" href="{{ asset('datatable/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatable/css/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('datatable/css/responsive.bootstrap5.css') }}">
<!-- End Datatable -->

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}"/>
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<!--End Select2 -->

<!-- Tagify -->
<link rel="stylesheet" href="{{ asset('js/component/tagify.css') }}">
<!-- Tagify -->

<link rel="stylesheet" href="{{ asset('admin/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />

<script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    /* ===== Sneat menu overrides ===== */
    .bg-menu-theme .menu-inner > .menu-item.active > .menu-link,
    .bg-menu-theme.menu-horizontal .menu-inner > .menu-item.active > .menu-sub > .menu-item.active:not(:has(.menu-sub)) > .menu-link {
        color: #fff !important;
        background-color: #696cff !important;
    }
    .bg-menu-theme .menu-item.open:not(.menu-item-closing) > .menu-toggle,
    .bg-menu-theme .menu-item.active > .menu-link {
        color: #ffffff;
    }
    .bg-menu-theme .menu-inner-shadow {
        background: linear-gradient(#2b2c40 41%, rgba(43, 44, 64, 0.11) 95%, rgba(43, 44, 64, 0));
    }

    /* ===== App responsive title ===== */
    .app-title {
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: #566a7f;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
        flex: 1 1 auto;
        min-width: 0;
    }
    @media (max-width: 991.98px) {
        .app-title { font-size: 0.9rem; }
    }
    @media (max-width: 575.98px) {
        .app-title { display: none; }
    }

    /* ===== Stat cards ===== */
    .stat-card {
        border: 0;
        border-radius: 0.6rem;
        box-shadow: 0 0.125rem 0.5rem 0 rgba(67, 89, 113, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem 0 rgba(67, 89, 113, 0.18);
    }
    .stat-card .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }
    .stat-card .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1.1;
        color: #2c3e50;
    }
    .stat-card .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    /* ===== Responsive tables ===== */
    .table-responsive-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.5rem;
    }
    .table-responsive-wrapper table { min-width: 720px; }

    /* ===== Better forms on mobile ===== */
    @media (max-width: 575.98px) {
        .card-body { padding: 1rem; }
        .container-xxl, .container-p-y { padding-left: 0.75rem; padding-right: 0.75rem; }
        h4.fw-bold { font-size: 1.05rem; }
    }

    /* ===== DataTables responsive overrides ===== */
    table.dataTable.responsive > tbody > tr > td.dtr-control:before {
        background-color: #696cff;
        border-color: #696cff;
    }
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 0.375rem;
    }
    @media (max-width: 575.98px) {
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            float: none !important;
            text-align: left !important;
            margin-bottom: 0.5rem;
        }
    }

    /* ===== Sidebar smooth on small screens ===== */
    @media (max-width: 1199.98px) {
        .layout-menu { z-index: 1080; }
    }
</style>
{!! midia_css() !!}
@stack('style')
