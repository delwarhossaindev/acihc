<style>
    /* ===== Base ===== */
    body { font-family: Arial, sans-serif; font-size: 11px; color: #000; line-height: 1.45; margin: 0; padding: 0; }
    p, div, li, span { font-size: 11px; line-height: 1.45; }

    /* ===== Section heading (1., 2., 3., …) ===== */
    .pdf-section-heading {
        font-weight: bold;
        font-size: 12.5px;
        color: #000;
        margin-top: 10px;
        margin-bottom: 4px;
    }
    .pdf-section-heading b { font-weight: bold; }
    .pdf-block { margin: 2px 0 8px 0; }
    .pdf-block div { margin: 1px 0; }
    .text-left { text-align: left; }
    .text-center { text-align: center; }
    .pagebreak { page-break-after: always; }

    /* ===== Standard data table ===== */
    .pdf-tbl {
        border-collapse: collapse;
        width: 100%;
        font-size: 10.5px;
        margin: 4px 0 8px 0;
        text-align: center;
    }
    .pdf-tbl th, .pdf-tbl td {
        border: 0.5pt solid #000;
        padding: 4px 5px;
        vertical-align: middle;
    }
    .pdf-tbl thead th {
        background: #f1f1f1;
        font-weight: 700;
    }
    .pdf-tbl td.text-left { text-align: left; }
    .pdf-approval th { background: #fafafa; }
    /* Larger, bolder checkmark for scope/applicability cells. */
    .pdf-check { font-size: 16px; font-weight: bold; line-height: 1; }

    /* ===== Repeating page header ===== */
    .pdf-page-header {
        width: 100%;
        border-collapse: collapse;
    }
    .pdf-page-header td {
        border: 0.5pt solid #000;
        vertical-align: middle;
        padding: 6px;
    }
    .pdf-ph-logo { width: 60px; text-align: center; }
    .pdf-ph-title { font-size: 13px; font-weight: bold; text-align: center; }
    .pdf-ph-meta { width: 38%; text-align: center; }
    .pdf-ph-protocol { font-size: 13px; font-weight: bold; text-align: center; }
    .pdf-ph-protocol-no { font-size: 9px; font-weight: bold; text-align: center; }
    .pdf-ph-product { text-align: center; font-size: 14px; font-weight: bold; }
    .pdf-ph-strength { text-align: center; font-size: 12px; font-weight: bold; }

    /* ===== Repeating page footer ===== */
    .pdf-page-footer { text-align: center; font-size: 9px; line-height: 1.4; font-weight: normal; }
    .pdf-pf-pageno   { font-size: 9px; font-weight: normal; }

    /* ===== Withdrawal grid (section 15) ===== */
    .pdf-grid {
        border-collapse: collapse;
        width: 100%;
        font-size: 9.5px;
        text-align: center;
        border: 1.2pt solid #000;
        margin: 6px 0;
    }
    .pdf-grid th, .pdf-grid td {
        border: 0.5pt solid #000;
        padding: 4px;
        vertical-align: middle;
    }
    .pdf-grid thead th {
        background: #e8e8e8;
        font-weight: 700;
    }
    .pdf-grid-batch { font-size: 11px; }
    .pdf-grid-remarks { width: 60px; }
    .pdf-grid-period { background: #e8e8e8; }
    .pdf-grid-h-cond { width: 56px; line-height: 1.25; }
    .pdf-grid-h-quantity { width: 60px; line-height: 1.25; }
    .pdf-grid-slash {
        background-size: 100% 100%;
        background-repeat: no-repeat;
        height: 26px;
    }
    /* Withdrawal grid rendered as a static image — slightly under full
       content width so two grids (plus the section heading + paragraph)
       fit on one A4 page. */
    .pdf-grid-img-wrap { text-align: center; margin: 0; }
    .pdf-grid-img { width: 95%; height: auto; }
    .pdf-grid-foot td { background: #f5f5f5; height: 22px; }
    .pdf-grid-foot-label { text-align: left; font-weight: 600; padding-left: 8px; }
</style>
