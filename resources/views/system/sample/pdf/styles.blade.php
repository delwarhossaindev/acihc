<style>
    body { font-family: Arial, sans-serif; font-size: 10px; color: #000; line-height: 1.4; margin: 0; padding: 0; }
    p, div, li, span { font-size: 10px; line-height: 1.4; }
    .text-left { text-align: left; }
    .text-center { text-align: center; }
    .pagebreak { page-break-after: always; }

    /* ===== Repeating page header ===== */
    .pdf-page-header { width: 100%; border-collapse: collapse; }
    .pdf-page-header td { border: 0.5pt solid #000; vertical-align: middle; padding: 6px; }
    .pdf-ph-logo { width: 70px; text-align: center; }
    .pdf-ph-title { width: 46%; text-align: center; font-size: 13px; font-weight: bold; }
    .pdf-ph-meta { text-align: center; font-size: 12px; font-weight: bold; }
    .pdf-ph-product { text-align: center; font-size: 12px; font-weight: bold; }
    .pdf-ph-qc { text-align: center; font-size: 12px; font-weight: bold; }

    /* ===== Repeating page footer ===== */
    .pdf-page-footer { text-align: center; font-size: 9px; line-height: 1.4; font-weight: normal; }
    .pdf-pf-pageno   { font-size: 9px; font-weight: normal; }

    /* ===== Information table (page 1) ===== */
    .pdf-info { border-collapse: collapse; width: 100%; font-size: 10px; margin: 4px 0 8px 0; }
    .pdf-info th, .pdf-info td { border: 0.5pt solid #000; padding: 4px 6px; vertical-align: middle; }
    .pdf-info th { font-weight: bold; text-align: left; width: 22%; background: #fff; }
    .pdf-info td { text-align: left; }
    .pdf-info .pdf-info-pkg { padding: 4px 6px; }
    .pdf-info .pdf-info-pkg strong { font-weight: bold; }
    .pdf-info .pdf-info-pkg div { margin: 1px 0; }

    /* ===== Test results table (page 2) ===== */
    .pdf-tests { border-collapse: collapse; width: 100%; font-size: 9.5px; margin: 4px 0 8px 0; }
    .pdf-tests th, .pdf-tests td { border: 0.5pt solid #000; padding: 4px 5px; vertical-align: middle; }
    .pdf-tests thead th { background: #f1f1f1; font-weight: bold; text-align: center; }
    .pdf-tests td { text-align: left; }
    .pdf-tests td.center { text-align: center; }

    /* ===== Note list ===== */
    .pdf-note-heading { font-weight: bold; font-size: 11px; margin-top: 8px; margin-bottom: 4px; }
    ol.pdf-note { list-style-type: lower-roman; margin: 4px 0 8px 18px; padding: 0; }
    ol.pdf-note li { font-size: 10px; line-height: 1.45; }

    /* ===== Approval table ===== */
    .pdf-approval { border-collapse: collapse; width: 100%; font-size: 10px; margin: 6px 0; }
    .pdf-approval th, .pdf-approval td { border: 0.5pt solid #000; padding: 4px 6px; vertical-align: middle; text-align: center; }
    .pdf-approval thead th { background: #fafafa; font-weight: bold; }
    .pdf-approval tbody th { font-weight: bold; text-align: left; width: 20%; }
</style>
