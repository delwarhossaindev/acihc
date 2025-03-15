<ul class="navbar-nav flex-row align-items-center ms-auto">

    {{-- <!-- Notification -->
    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <i class="bx bx-bell bx-sm"></i>
        <span class="badge bg-danger rounded-pill badge-notifications">5</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end py-0">
        <li class="dropdown-menu-header border-bottom">
          <div class="dropdown-header d-flex align-items-center py-3">
            <h5 class="text-body mb-0 me-auto">Notification</h5>
            <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Mark all as read" aria-label="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>
          </div>
        </li>
        <li class="dropdown-notifications-list scrollable-container ps">
          <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action dropdown-notifications-item">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">Congratulation Lettie 🎉</h6>
                  <p class="mb-0">Won the monthly best seller gold badge</p>
                  <small class="text-muted">1h ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">Charles Franklin</h6>
                  <p class="mb-0">Accepted your connection</p>
                  <small class="text-muted">12hr ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">New Message ✉️</h6>
                  <p class="mb-0">You have new message from Natalie</p>
                  <small class="text-muted">1h ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-cart"></i></span>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">Whoo! You have new order 🛒 </h6>
                  <p class="mb-0">ACME Inc. made new order $1,154</p>
                  <small class="text-muted">1 day ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">Application has been approved 🚀 </h6>
                  <p class="mb-0">Your ABC project application has been approved.</p>
                  <small class="text-muted">2 days ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-pie-chart-alt"></i></span>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">Monthly report is generated</h6>
                  <p class="mb-0">July monthly financial report is generated </p>
                  <small class="text-muted">3 days ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">Send connection request</h6>
                  <p class="mb-0">Peter sent you connection request</p>
                  <small class="text-muted">4 days ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">New message from Jane</h6>
                  <p class="mb-0">Your have new message from Jane</p>
                  <small class="text-muted">5 days ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar">
                    <span class="avatar-initial rounded-circle bg-label-warning"><i class="bx bx-error"></i></span>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1">CPU is running high</h6>
                  <p class="mb-0">CPU Utilization Percent is currently at 88.63%,</p>
                  <small class="text-muted">5 days ago</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                  <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                  <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
              </div>
            </li>
          </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></li>
        <li class="dropdown-menu-footer border-top">
          <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">
            View all notifications
          </a>
        </li>
      </ul>
    </li>
    <!--/ Notification --> --}}
    <!-- User -->

    @auth
    <li class="nav-item navbar-dropdown dropdown-user dropdown">

      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        @if(auth()->user()->hasImage())
        <div class="avatar avatar-online">
          <img src="{{ auth()->user()->image->path }}" alt="" class="flag-icon flag-icon-us flag-icon-squared rounded-circle me-1 fs-3">
        </div>
        @else
        <div class="avatar avatar-online">
          <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="" class="">
        </div>
        @endif
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="{{ route('profile') }}">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                @if(auth()->user()->hasImage())
                <div class="avatar avatar-online">
                  <img src="{{ auth()->user()->image->path }}" alt="" class="flag-icon flag-icon-us flag-icon-squared rounded-circle me-1 fs-3">
                </div>
                @else
                <div class="avatar avatar-online">
                  <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="" class="w-px-40 h-auto rounded-circle">
                </div>
                @endif
              </div>
              <div class="flex-grow-1">
                <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                @forelse (auth()->user()->roles()->get() as $role)
                <small class="badge bg-label-success">
                  {{ ucfirst($role->name) }}
                </small>
                @empty
                <small class="text-muted">
                  No role assigned to this user
                </small>
                @endforelse
              </div>
            </div>
          </a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a class="dropdown-item" href="{{ route('profile') }}">
            <i class="bx bx-user me-2"></i>
            <span class="align-middle">My Profile</span>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="{{ route('update.password') }}">
            <i class="bx bx-lock me-2"></i>
            <span class="align-middle">Change Password</span>
          </a>
        </li>
        {{-- <li>
          <a class="dropdown-item" href="pages-account-settings-billing.html">
            <span class="d-flex align-items-center align-middle">
              <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
              <span class="flex-grow-1 align-middle">Billing</span>
              <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
            </span>
          </a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a class="dropdown-item" href="pages-help-center-landing.html">
            <i class="bx bx-support me-2"></i>
            <span class="align-middle">Help</span>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="pages-faq.html">
            <i class="bx bx-help-circle me-2"></i>
            <span class="align-middle">FAQ</span>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="pages-pricing.html">
            <i class="bx bx-dollar me-2"></i>
            <span class="align-middle">Pricing</span>
          </a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li> --}}
        <li>
          <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="bx bx-power-off me-2"></i>
            <span class="align-middle">Log Out</span>
          </a>
        </li>
      </ul>
    </li>
    @endauth
    <!--/ User -->


  </ul>
