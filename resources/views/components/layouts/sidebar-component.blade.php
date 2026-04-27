@auth
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background: #2b2c40 !important;">
  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
        <span class="app-brand-logo demo ">
            <img src="{{ asset('logo.png') }}" alt="ACI Healthcare Logo" style="height: 35px; width: auto;">
          </span>
          <span class="app-brand-text menu-text fw-bolder text-white" style="margin: 4px; font-size: 15px; padding-top: 2px;">
            ACI HealthCare Limited
          </span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  @php
    $user = auth()->user();
    $route = Route::current()->getName();
  @endphp

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item text-white font-weight-bold {{ $route == 'dashboard' ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon text-white font-weight-bold menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics" class="text-white font-weight-bold" >Dashboard</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-white font-weight-bold">Master Data</span>
    </li>
    <li class="menu-item text-white font-weight-bold @if($route == 'manufacturer')
       {{ 'active open' }}
       @elseif($route == 'market')
       {{ 'active open' }}
       @elseif($route == 'studytype' || request()->is('studytype/*'))
       {{ 'active open' }}
       @elseif($route == 'condition')
       {{ 'active open' }}
       @elseif($route == 'apidetail')
       {{ 'active open' }}
       @elseif($route == 'product' || request()->is('product/*'))
       {{ 'active open' }}
       @elseif($route == 'test')
       {{ 'active open' }}
       @elseif($route == 'pack')
       {{ 'active open' }}
       @elseif($route == 'subtest')
       {{ 'active open' }}
    @endif">
      <a href="javascript:void(0);" class="menu-link menu-toggle text-white font-weight-bold">
        <i class="menu-icon tf-icons bx bx-food-menu"></i>
        <div data-i18n="Account Settings">Settings</div>
      </a>
      <ul class="menu-sub">
        @if ($user->hasPermission('ManufacturerController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'manufacturer' ? 'active' : '' }}">
          <a href="{{ route('manufacturer') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Manufacturer</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('MarketController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'market' ? 'active' : '' }}">
          <a href="{{ route('market') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Market</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('StudyController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'studytype' || request()->is('studytype/*') ? 'active' : '' }}">
          <a href="{{ route('studytype') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Study Type</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('ConditionController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'condition' ? 'active' : '' }}">
          <a href="{{ route('condition') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Condition</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('ApiController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'apidetail' ? 'active' : '' }}">
          <a href="{{ route('apidetail') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">API Details</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('PackController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'pack' ? 'active' : '' }}">
          <a href="{{ route('pack') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Unit Pack</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('ProductController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'product' || request()->is('product/*') ? 'active' : '' }}">
          <a href="{{ route('product') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Product</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('TestController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'test' ? 'active' : '' }}">
          <a href="{{ route('test') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Test</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('SubtestController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'subtest' ? 'active' : '' }}">
          <a href="{{ route('subtest') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Sub Test</div>
          </a>
        </li>
        @endif
      </ul>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-white font-weight-bold">Packaging</span>
    </li>
    <li class="menu-item @if($route == 'packaging')
          {{ 'active open' }}
          @elseif($route == 'container' || request()->is('container/*'))
          {{ 'active open' }}
      @endif">
      <a href="javascript:void(0);" class="menu-link text-white font-weight-bold menu-toggle">
        <i class="menu-icon tf-icons bx bx-window-open"></i>
        <div data-i18n="Account Settings">Packaging</div>
      </a>
      <ul class="menu-sub">
        @if ($user->hasPermission('PackagingController@index'))
        <li class="menu-item {{ $route == 'packaging' ? 'active' : '' }}">
          <a href="{{ route('packaging') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Packaging Component</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('ContainerController@index'))
        <li class="menu-item {{ $route == 'container' || request()->is('container/*') ? 'active' : '' }}">
          <a href="{{ route('container') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Packaging Profile</div>
          </a>
        </li>
        @endif
      </ul>
    </li>

    <!-- Protocol -->
    <li class="menu-header small text-uppercase text-white font-weight-bold">
      <span class="menu-header-text">Protocol</span>
    </li>
    @if ($user->hasPermission('ProtocolController@index'))
    <li class="menu-item {{ $route == 'packaging' || request()->is('protocol/*') || request()->is('protocols') ? 'active' : '' }}">
      <a href="{{ route('protocol') }}" class="menu-link text-white font-weight-bold">
        <i class="menu-icon tf-icons bx bx-check-shield"></i>
        <div data-i18n="Analytics">Protocol</div>
      </a>
    </li>
    @endif

    <!-- Database -->
    {{-- <li class="menu-header small text-uppercase text-white font-weight-bold">
      <span class="menu-header-text">Database Section</span>
    </li>
    @if ($user->hasPermission('DatabaseController@index'))
    <li class="menu-item {{ $route == 'database' || request()->is('database/*') || request()->is('database') ? 'active' : '' }}">
      <a href="{{ route('database.index') }}" class="menu-link text-white font-weight-bold">
        <i class="menu-icon tf-icons bx bx-check-shield"></i>
        <div data-i18n="Analytics">Database</div>
      </a>
    </li>
     @endif --}}

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-white font-weight-bold">Received Sample</span>
    </li>
    <li class="menu-item @if($route == 'sample.index' || request()->is('sample/*') || request()->is('all/*'))
          {{ 'active open' }}
          @elseif($route == 'batch.index' || request()->is('batch/*'))
          {{ 'active open' }}
      @endif">
      <a href="javascript:void(0);" class="menu-link menu-toggle text-white font-weight-bold">
        <i class="menu-icon tf-icons bx bx-check-shield"></i>
        <div data-i18n="Account Settings">Sample</div>
      </a>
      <ul class="menu-sub">
        @if ($user->hasPermission('SampleController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'sample.index' || request()->is('sample/*') ? 'active' : '' }}">
          <a href="{{ route('sample.index') }}" class="menu-link">
            <div data-i18n="Account">Sample</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('BatchController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'batch.index' || request()->is('batch/*') ? 'active' : '' }}">
          <a href="{{ route('batch.index') }}" class="menu-link">
            <div data-i18n="Account">Batch</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('SampleReportController@index'))
        <li class="menu-item text-white font-weight-bold {{ $route == 'sample.report.index' ? 'active' : '' }}">
          <a href="{{ route('sample.report.index') }}" class="menu-link">
            <div data-i18n="Account">All Report</div>
          </a>
        </li>
        @endif
      </ul>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-white font-weight-bold">User Management</span>
    </li>
    @if ($user->hasPermission('UserController@index'))
    <li class="menu-item  {{ $route == 'user' ? 'active open' : '' }}">
      <a href="{{ route('user') }}" class="menu-link text-white font-weight-bold">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Analytics ">User</div>
      </a>
    </li>
    @endif


    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-white font-weight-bold">General Settings</span>
    </li>

    <li class="menu-item text-white font-weight-bold
    @if($route == 'role' || request()->is('role/*'))
       {{ 'active open' }}
       @elseif($route == 'permission')
       {{ 'active open' }}
       @elseif($route == 'settings')
       {{ 'active open' }}
    @endif">
    {{-- @if ($user->hasPermission('UserController@access')) --}}
      <a href="javascript:void(0);" class="menu-link menu-toggle text-white font-weight-bold">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Account Settings">Access Control</div>
      </a>
      {{-- @endif --}}
      <ul class="menu-sub">
        @if ($user->hasPermission('RoleController@index'))
        <li class="menu-item {{ $route == 'role' || request()->is('role/*') ? 'active' : '' }}">
          <a href="{{ route('role') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Role</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('PermissionController@index'))
        <li class="menu-item {{ $route == 'permission' ? 'active' : '' }}">
          <a href="{{ route('permission') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">Permission</div>
          </a>
        </li>
        @endif
        @if ($user->hasPermission('SettingsController@index'))
        <li class="menu-item {{ $route == 'settings' ? 'active' : '' }}">
          <a href="{{ route('settings') }}" class="menu-link text-white font-weight-bold">
            <div data-i18n="Account">App Settings</div>
          </a>
        </li>
        @endif
      </ul>
    </li>


    <li class="menu-item text-white font-weight-bold {{ $route == 'about' ? 'active' : '' }}">
      <a href="{{ route('about') }}" class="menu-link">
        <i class="menu-icon text-white font-weight-bold tf-icons tf-icons bx bxs-inbox"></i>
        <div data-i18n="Analytics" class="text-white font-weight-bold" >About</div>
      </a>
    </li>

  </ul>
</aside>
@endauth
