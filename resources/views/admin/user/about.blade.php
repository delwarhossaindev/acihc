@extends('admin.layouts.master')

@section('content')
    <style>
        .about-hero {
            background: linear-gradient(135deg, #696cff 0%, #8592ff 50%, #03c3ec 100%);
            border-radius: 1rem;
            padding: 3rem 2rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(105, 108, 255, 0.25);
        }
        .about-hero::before {
            content: "";
            position: absolute;
            top: -60px; right: -60px;
            width: 240px; height: 240px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        .about-hero::after {
            content: "";
            position: absolute;
            bottom: -90px; left: -90px;
            width: 300px; height: 300px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }
        .about-logo-wrap {
            width: 120px; height: 120px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        .about-logo-wrap img { width: 80px; height: 80px; object-fit: contain; }
        .about-version-badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 50px;
            font-weight: 600;
            backdrop-filter: blur(8px);
        }
        .stat-card {
            background: #fff;
            border-radius: 0.85rem;
            padding: 1.5rem;
            border: 1px solid rgba(67, 89, 113, 0.1);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(67, 89, 113, 0.12);
        }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 0.75rem;
        }
        .stat-icon.bg-primary-soft   { background: rgba(105, 108, 255, 0.12); color: #696cff; }
        .stat-icon.bg-success-soft   { background: rgba(113, 221, 55, 0.12); color: #71dd37; }
        .stat-icon.bg-info-soft      { background: rgba(3, 195, 236, 0.12); color: #03c3ec; }
        .stat-icon.bg-warning-soft   { background: rgba(255, 171, 0, 0.12); color: #ffab00; }
        .feature-card {
            background: #fff;
            border-radius: 0.85rem;
            padding: 1.4rem;
            border: 1px solid rgba(67, 89, 113, 0.08);
            height: 100%;
            transition: all 0.25s ease;
        }
        .feature-card:hover {
            border-color: #696cff;
            box-shadow: 0 6px 20px rgba(105, 108, 255, 0.12);
        }
        .feature-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: rgba(105, 108, 255, 0.1);
            color: #696cff;
            margin-bottom: 0.85rem;
        }
        .info-row {
            display: flex;
            align-items: center;
            padding: 0.85rem 0;
            border-bottom: 1px dashed rgba(67, 89, 113, 0.15);
        }
        .info-row:last-child { border-bottom: none; }
        .info-row .info-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: rgba(105, 108, 255, 0.1);
            color: #696cff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 0.85rem;
            flex-shrink: 0;
        }
        .info-row .info-label { font-size: 0.78rem; color: #8592a3; text-transform: uppercase; letter-spacing: 0.04em; }
        .info-row .info-value { font-weight: 600; color: #2c3142; }
        .compliance-pill {
            display: inline-block;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            margin: 0.2rem 0.3rem 0.2rem 0;
            background: rgba(105, 108, 255, 0.1);
            color: #696cff;
            border: 1px solid rgba(105, 108, 255, 0.2);
        }
    </style>

    <div class="row mt-3">
        <div class="col-12">
            <div class="about-hero text-center mb-4">
                <div class="about-logo-wrap">
                    <img src="{{ asset('logo.png') }}" alt="Software Logo">
                </div>
                <h2 class="fw-bold text-white mb-2">Stability Management Software</h2>
                <p class="text-white-50 mb-3 mx-auto" style="max-width: 640px;">
                    A modern platform for designing, planning and executing pharmaceutical stability studies — built around ICH and FDA 21 CFR Part 11 compliance.
                </p>
                <span class="about-version-badge"><i class="bx bx-rocket me-1"></i>Version 1.00</span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card text-center">
                <span class="stat-icon bg-primary-soft"><i class="bx bx-buildings"></i></span>
                <h6 class="text-muted mb-1 small">Organization</h6>
                <h6 class="fw-bold mb-0">ACI HealthCare</h6>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card text-center">
                <span class="stat-icon bg-success-soft"><i class="bx bx-calendar-check"></i></span>
                <h6 class="text-muted mb-1 small">Developed In</h6>
                <h6 class="fw-bold mb-0">2023 &ndash; 2025</h6>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card text-center">
                <span class="stat-icon bg-info-soft"><i class="bx bx-shield-quarter"></i></span>
                <h6 class="text-muted mb-1 small">Compliance</h6>
                <h6 class="fw-bold mb-0">ICH &middot; FDA</h6>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card text-center">
                <span class="stat-icon bg-warning-soft"><i class="bx bx-cog"></i></span>
                <h6 class="text-muted mb-1 small">Integration</h6>
                <h6 class="fw-bold mb-0">LIMS &middot; ERP</h6>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <span class="stat-icon bg-primary-soft me-2 mb-0" style="width:42px;height:42px;font-size:22px;">
                            <i class="bx bx-info-circle"></i>
                        </span>
                        <h5 class="fw-bold mb-0">About the Software</h5>
                    </div>
                    <p class="text-muted lh-lg mb-3">
                        The Stability Management Software is essential in the pharmaceutical industry,
                        supporting the design, planning, and execution of stability studies in compliance
                        with regulatory guidelines like <strong>ICH</strong> and <strong>FDA 21 CFR Part 11</strong>.
                        It centralizes data collection and management, reducing manual errors and enabling
                        efficient tracking of stability samples.
                    </p>
                    <p class="text-muted lh-lg mb-3">
                        By streamlining sample management, automating alerts, and enabling data analysis,
                        the software helps identify trends, calculate product shelf-life, and facilitate
                        regulatory reporting. Integrated with key systems such as <strong>LIMS</strong> and
                        <strong>ERP</strong>, it ensures secure data integrity, quality control, and
                        seamless information flow.
                    </p>
                    <div class="mt-3">
                        <span class="compliance-pill"><i class="bx bx-check-shield me-1"></i>ICH Q1A</span>
                        <span class="compliance-pill"><i class="bx bx-check-shield me-1"></i>21 CFR Part 11</span>
                        <span class="compliance-pill"><i class="bx bx-check-shield me-1"></i>GxP Ready</span>
                        <span class="compliance-pill"><i class="bx bx-check-shield me-1"></i>Audit Trail</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="stat-icon bg-info-soft me-2 mb-0" style="width:42px;height:42px;font-size:22px;">
                            <i class="bx bx-detail"></i>
                        </span>
                        <h5 class="fw-bold mb-0">Software Information</h5>
                    </div>
                    <div class="info-row">
                        <span class="info-icon"><i class="bx bx-package"></i></span>
                        <div>
                            <div class="info-label">Software Name</div>
                            <div class="info-value">Stability Management Software</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-icon"><i class="bx bx-code-alt"></i></span>
                        <div>
                            <div class="info-label">Version</div>
                            <div class="info-value">1.00</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-icon"><i class="bx bx-buildings"></i></span>
                        <div>
                            <div class="info-label">Organization</div>
                            <div class="info-value">ACI HealthCare Limited</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-icon"><i class="bx bx-calendar"></i></span>
                        <div>
                            <div class="info-label">Developed In</div>
                            <div class="info-value">2023 &ndash; 2025</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-icon"><i class="bx bx-server"></i></span>
                        <div>
                            <div class="info-label">Platform</div>
                            <div class="info-value">Laravel + MySQL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-12">
            <h5 class="fw-bold mb-3 mt-3"><i class="bx bx-grid-alt me-2 text-primary"></i>Key Capabilities</h5>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feature-card">
                <span class="feature-icon"><i class="bx bx-test-tube"></i></span>
                <h6 class="fw-bold mb-2">Stability Study Design</h6>
                <p class="text-muted small mb-0">Plan and configure stability protocols with built-in support for ICH conditions, study types and chamber assignments.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feature-card">
                <span class="feature-icon"><i class="bx bx-bell"></i></span>
                <h6 class="fw-bold mb-2">Automated Alerts</h6>
                <p class="text-muted small mb-0">Sample pull schedules and approval reminders trigger automatically &mdash; no more manual tracking sheets.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feature-card">
                <span class="feature-icon"><i class="bx bx-line-chart"></i></span>
                <h6 class="fw-bold mb-2">Data Analytics</h6>
                <p class="text-muted small mb-0">Identify degradation trends, calculate shelf-life and generate regulatory-ready stability reports.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feature-card">
                <span class="feature-icon"><i class="bx bx-link-alt"></i></span>
                <h6 class="fw-bold mb-2">LIMS &amp; ERP Integration</h6>
                <p class="text-muted small mb-0">Two-way integration with laboratory and enterprise systems for seamless data flow across departments.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feature-card">
                <span class="feature-icon"><i class="bx bx-history"></i></span>
                <h6 class="fw-bold mb-2">Complete Audit Trail</h6>
                <p class="text-muted small mb-0">Every change is logged with user, timestamp and reason &mdash; meeting 21 CFR Part 11 requirements.</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="feature-card">
                <span class="feature-icon"><i class="bx bx-lock-alt"></i></span>
                <h6 class="fw-bold mb-2">Role-Based Access</h6>
                <p class="text-muted small mb-0">Granular permissions for analysts, reviewers and approvers protect data integrity at every step.</p>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-2">
        <div class="col-12 text-center text-muted small">
            <i class="bx bx-copyright"></i> {{ date('Y') }} ACI HealthCare Limited &middot; All rights reserved
        </div>
    </div>
@endsection

@push('script')
@endpush
