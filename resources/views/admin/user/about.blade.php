@extends('admin.layouts.master')

@section('content')
    <div class="row mt-3">

        <div class="col-12 ">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Software Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4 mt-3">
                      
                        <img src="{{ asset('logo.png') }}" alt="Software Logo" class="img-fluid rounded-circle shadow" style="height: 100px; width: 100px;">
                    </div>
                    <h5 class="text-center fw-bold">Software Name: Stability Management Software</h5>
                    <p class="text-center text-muted">Version: 1.00</p>
                    <div class="mt-4">
                        <h6 class="fw-bold">Developer Information</h6>
                        <ul class="list-unstyled">
                            <li><strong>Organization: </strong>ACI HealthCare Limited</li>
                            <li><strong>Developed In: </strong>2023-2025</li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-bold">About Stability Management Software</h6>
                        <p>
                            The Stability Management Software is essential in the pharmaceutical industry,
                            supporting the design, planning, and execution of stability studies in compliance
                            with regulatory guidelines like ICH and FDA 21 CFR Part 11. It centralizes data
                            collection and management, reducing manual errors and enabling efficient
                            tracking of stability samples. By streamlining sample management, automating
                            alerts, and enabling data analysis, the software helps identify trends, calculate
                            product shelf-life, and facilitate regulatory reporting. Integrated with other key
                            systems, such as LIMS and ERP, it ensures secure data integrity, quality control,
                            and seamless information flow, ultimately enhancing compliance, efficiency,
                            and data-driven decision-making in stability programs.
                        </p>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- Add any specific JavaScript or jQuery code here if needed --}}
@endpush
