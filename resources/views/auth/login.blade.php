<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <x-layouts.header-component />
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <!-- Logo -->
                                </span>
                                <span class="app-brand-text text-body fw-bolder">ACI Healthcare</span>
                            </a>
                            <br>

                        </div>
                        <div> <span style="position: absolute; top: 49px; left: 87px;">Stability Management Software</span></div>
                        <!-- /Logo -->

                        <x-alert.alert-component />

                        <form action="{{ route('login') }}" method="POST" class="mb-3 needs-validation" role="form"
                            novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter your email"
                                    required />
                                <div class="invalid-tooltip">This field is required</div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" required />
                                    <div class="invalid-tooltip">This field is required</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->
    <x-layouts.footer-component />
</body>

</html>
