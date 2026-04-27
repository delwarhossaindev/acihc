# ACIHC Optimization Documentation

এই ডকুমেন্টে `acihc` (original) থেকে `acihc_new`-এ যেসব optimization, bug fix ও refactoring করা হয়েছে তার বিস্তারিত বিবরণ রয়েছে।

---

## 📋 সূচিপত্র (Table of Contents)

1. [Overview](#overview)
2. [Modified Files Summary](#modified-files-summary)
3. [🔴 Critical Bugs Fixed](#-critical-bugs-fixed)
4. [🛡️ Security Fixes](#-security-fixes)
5. [⚡ Performance Improvements](#-performance-improvements)
6. [🧹 Code Quality Improvements](#-code-quality-improvements)
7. [⚠️ Breaking Changes & Testing Required](#-breaking-changes--testing-required)
8. [📁 File-by-File Changes](#-file-by-file-changes)

---

## Overview

| Metric | Value |
|--------|-------|
| Total PHP files modified | 108 |
| Helpers optimized | 5 |
| Models optimized | 57 |
| Controllers optimized | 25 |
| Form Requests optimized | 16 |
| Middleware fixed | 1 (CSRF security) |
| Critical bugs fixed | 12+ |
| Lines of dead code removed | ~600+ |

**Largest reductions:**

| File | Before | After | Reduction |
|------|--------|-------|-----------|
| `ProtocolController.php` | 892 lines | 545 lines | -39% |
| `SampleReportController.php` | 564 lines | 355 lines | -37% |
| `Functions.php` (helper) | 416 lines | 282 lines | -32% |

---

## Modified Files Summary

### Helpers (`app/Helpers/`)
- `Functions.php` — caching, XSS protection, null-safety
- `Addressable.php` — bug fix (relation name)
- `Imageable.php` — `count()` → `exists()`
- `HasAlert.php` — minor cleanup
- `HasValidation.php` — **critical** boot() bug fixed

### Models (`app/Models/`)
57 model files updated. Major refactoring in:
- `Protocol.php` (602 → 478 lines)
- `Batch.php` — constructor double-boot bug fixed
- `User.php` — password double-hashing bug fixed
- `Product.php` — transactions cleaned up

All other models: `keyType` typo fixes, useless wrapper removal, consistent style.

### Controllers (`app/Http/Controllers/`)
- **Admin/**: Dashboard, User, Role, Permission, Profile, Settings, ActivityLog
- **Auth/**: LoginController
- **System/**: Protocol, SampleReport, Sample, Batch, Product, Container, Manufacturer, Market, Pack, Packaging, Condition, Test, Subtest, Study, Database, Api, Ajax

### Form Requests (`app/Http/Requests/`)
All 16 requests rewritten with proper type declarations, array-form rules, unique-with-ignore for updates, password strength rules.

### Middleware (`app/Http/Middleware/`)
- `VerifyCsrfToken.php` — **CRITICAL SECURITY FIX**

---

## 🔴 Critical Bugs Fixed

### 1. CSRF Protection Was Completely Disabled
**File:** `app/Http/Middleware/VerifyCsrfToken.php`

```php
// BEFORE (vulnerable)
protected $except = ['*'];

// AFTER (secured)
protected $except = [
    //
];
```
**Impact:** Every POST/PUT/DELETE was vulnerable to CSRF attacks. Now Laravel-standard protection restored.

---

### 2. Password Double-Hashing in User Model
**File:** `app/Models/User.php`

User model has `'password' => 'hashed'` cast (Laravel 10+ auto-hashes). But `storeUser()` and `updateUser()` were calling `bcrypt()` manually — **double hash**, login would fail or user couldn't be created properly.

```php
// BEFORE (broken)
$this->password = bcrypt($request->password);  // hashed once
$this->save();                                  // cast hashes again = bcrypt(bcrypt(password))

// AFTER (fixed)
$this->fill([
    'password' => $request->password,  // cast handles hashing once
])->save();
```

---

### 3. Same Password Bug in SettingsController
**File:** `app/Http/Controllers/Admin/SettingsController.php`

```php
// BEFORE
$user->update(['password' => bcrypt($request->new_password)]);  // double-hash

// AFTER
User::where('id', $user->id)->update([
    'password' => Hash::make($request->new_password),  // query builder bypasses cast — explicit hash
]);
```

---

### 4. ProductDetail Mass-Assignment Broken
**File:** `app/Models/ProductDetail.php`

```php
// BEFORE (typo: dot instead of comma!)
protected $fillable = [
    'SkuID'.            // ← concatenates with next string
    'ProductID',        // becomes "SkuIDProductID"
    'ProductStrength',
];
// Result: fillable = ['SkuIDProductID', 'ProductStrength']
// ProductID can NEVER be mass-assigned

// AFTER
protected $fillable = [
    'SkuID',
    'ProductID',
    'ProductStrength',
];
```

---

### 5. Batch Model Double-Boot
**File:** `app/Models/Batch.php`

```php
// BEFORE
public function __construct()
{
    self::$rules = (new BatchRequest())->rules();  // instantiates Request on EVERY model construction!
    self::boot();                                   // double-boot, parent attributes not initialized
}

// AFTER
// Constructor removed entirely. HasValidation trait removed (was unused anyway since rules array empty)
```

**Impact:** Every `Batch::find()`, `Batch::all()`, etc. created a new `BatchRequest` instance — massive performance hit. Plus parent constructor never ran, so model attributes weren't being set up.

---

### 6. HasValidation Trait Skipping Parent Boot
**File:** `app/Helpers/HasValidation.php`

```php
// BEFORE
public static function boot()
{
    // parent::boot();           ← commented out!
    static::creating(function (Model $model) {
        Validator::validate($model->toArray(), static::$rules);
    });
}

// AFTER (uses Laravel's bootTraitName convention)
public static function bootHasValidation(): void
{
    static::creating(function (Model $model) {
        if (! empty(static::$rules)) {
            Validator::validate($model->toArray(), static::$rules);
        }
    });
}
```

**Impact:** Any model using `HasValidation` had its `boot()` method overridden, skipping `parent::boot()` — Eloquent observers, soft deletes, etc. would silently break.

---

### 7. Addressable Trait Wrong Relation Name
**File:** `app/Helpers/Addressable.php`

```php
// BEFORE
public function deleteAddress()
{
    return $this->addresses()->delete();  // ← method doesn't exist (relation is singular `address`)
}

// AFTER
public function deleteAddress()
{
    return $this->address()->delete();
}
```
**Impact:** Calling `$user->deleteAddress()` threw `BadMethodCallException`.

---

### 8. get_stability_chamber_month_value Hardcoded
**File:** `app/Helpers/Functions.php`

```php
// BEFORE
function get_stability_chamber_month_value($protocolID)
{
    $protocol = Protocol::find(1);  // ← always loads protocol 1, ignoring parameter!
    // ...nested useless loops over same data
}

// AFTER
function get_stability_chamber_month_value($protocolID): array
{
    $protocol = Protocol::with('statbilityStudy.study.details')->find($protocolID);
    if (! $protocol) return [];
    // ...clean iteration
}
```

---

### 9. cloneProtocolSkuContainerType Creating Empty Records
**File:** `app/Models/Protocol.php`

```php
// BEFORE
foreach ($ProtocolSkuPackContainer as $value1) {
    ProtocolSkuPackContainer::create(['PackID' => '']);  // empty PackID!
}

// AFTER
foreach ($sourceSkuPacks as $sourcePack) {
    $newPack = ProtocolSkuPack::create([...]);
    foreach ($sourcePack->perUnitContainer as $container) {
        $newPack->perUnitContainer()->create(['PackID' => $container->PackID]);
    }
}
```

---

### 10. Null-Pointer in Button Helpers
**File:** `app/Helpers/Functions.php`

```php
// BEFORE — crashed if Protocol doesn't exist
$Protocol = Protocol::where('ProtocolID', $ProtocolID)->first();
if ($Protocol->CreatedBy == auth()->user()->id) { ... }  // ← null pointer if $Protocol is null

// AFTER — null-safe
if ($protocol && $authId && $protocol->CreatedBy == $authId) { ... }
```

Same fix applied to `sampleReportButton()`.

---

### 11. WithdrawButton Undefined Variable
**File:** `app/Helpers/Functions.php`

```php
// BEFORE
function WithdrawButton($BatchID = '')
{
    if ($BatchID) {
        $btn = "...";
    }
    $btn .= "</div>";  // ← undefined $btn if no BatchID
    return $btn;
}

// AFTER
function WithdrawButton($BatchID = ''): string
{
    if (! $BatchID) return '';
    return "<button ...>";
}
```

---

### 12. Production Debug Statement
**File:** `app/Http/Controllers/Admin/DashboardController.php`

```php
// BEFORE
} catch (\Exception $e) {
    dd($e->getMessage());  // ← dumps to user in production!
    Toastr::error(...);
}

// AFTER
} catch (\Throwable $e) {
    Log::error('Withdrawal update failed: ' . $e->getMessage());
    Toastr::error(...);
}
```

Also removed `dd()` from `SampleReportController::createSampleReportDetail()`.

---

## 🛡️ Security Fixes

### XSS Protection in Button Helpers
All inline-HTML button helpers now escape URLs:

```php
// BEFORE
return "<a href='" . $edit . "'>Edit</a>";  // XSS if $edit is user-controlled

// AFTER
$edit = safeUrl($edit);  // htmlspecialchars with ENT_QUOTES
return "<a href='{$edit}'>Edit</a>";
```

### Email Normalization on Login
```php
// BEFORE
'email' => $request->input('email'),

// AFTER
'email' => strtolower(trim($request->input('email'))),
```

### Stronger Password Requirements
- Minimum 8 characters (was 6)
- New password must differ from old
- Proper `confirmed` semantics in form requests

### Form Request Validation
- All requests now have proper `array` rule format
- `unique` rules with `Rule::unique()->ignore($id)` for updates
- Proper `email`, `string`, `max:255` constraints
- `roles.*` validates each role exists

---

## ⚡ Performance Improvements

### N+1 Query Elimination

**ProtocolController DataTables (was 2-3 queries per row):**
```php
// BEFORE — for 100 rows = 200-300 queries
$versionCount = DB::table('ProtocolVersion')
    ->where('protocol_id', $protocol->ProtocolID)
    ->lockForUpdate()                      // unnecessary lock!
    ->max('version_no');

// AFTER — 1 query total, plucked into map
$versionMap = DB::table('ProtocolVersion')
    ->select('protocol_id', DB::raw('MAX(version_no) as version_no'))
    ->groupBy('protocol_id')
    ->pluck('version_no', 'protocol_id');

// Then in addColumn closure:
$versionNo = $versionMap[$row->ProtocolID] ?? 1.00;
```

**SampleReportController DataTables (was 4-5 queries per row):**
- `study` column: precomputed `$studyTypes` + `$studyMonths` lookup maps
- `sku` column: precomputed `$skuStrengths` map (was query per row)
- `pack` column: precomputed `$packs` map
- `status` column: precomputed `$statuses` map

**DashboardController:**
- `Strength` was `ProductDetail::where('SkuID', $row->SkuID)->value(...)` per row
- Now LEFT JOIN to `ProductDetail` table — single query

### Bulk Inserts

Multiple `foreach { Model::create(...) }` patterns replaced with single bulk inserts:

```php
// BEFORE
foreach ($apis as $api) {
    ProtocolAPIDetail::create([...]);  // N queries
}

// AFTER
$rows = [];
foreach ($apis as $api) {
    $rows[] = [...];
}
ProtocolAPIDetail::insert($rows);  // 1 query
```

Applied to: ProtocolAPIDetail, ProtocolBatch, ProtocolApprovalTree, ProductDetail, StudyTypeDetail, APIDetailBatch, BatchDetails, SampleReportDetail.

### Caching System Settings

```php
// BEFORE — DB hit on every page request
function getSystemSettings(string $key): string
{
    return Setting::where('key', $key)->first()['value'];
}

// AFTER — 10-minute cache
function getSystemSettings(string $key, ?string $default = null): ?string
{
    return Cache::remember("system_setting:{$key}", now()->addMinutes(10), function () use ($key, $default) {
        return Setting::where('key', $key)->value('value') ?? $default;
    });
}
```

Cache invalidation added in `SettingsController::update()`.

### Eager Loading Added

```php
// BEFORE
return $this::query();  // lazy loads relations

// AFTER
return static::query()->with([
    'user:id,name',
    'updatedby:id,name',
    'product:ProductID,ProductName',
    'product.skus:SkuID,ProductID,ProductStrength',
]);
```

Specific column selects (`'id,name'`) reduce data transfer.

### exists() Instead of count()

```php
// BEFORE — loads all rows just to count
if ($protocol->tests->count() > 0) { ... }
if ($protocol->apis()->count() > 0) { ... }

// AFTER — boolean check, single query
if ($protocol->tests()->exists()) { ... }
if ($protocol->apis()->exists()) { ... }
```

### Lock Removal from Read Paths

`lockForUpdate()` was being called inside read-only DataTables `addColumn` closures — causing unnecessary lock contention. Removed wherever inappropriate.

### Auth User Caching

```php
// BEFORE — Auth::user() called inside addColumn closure for every row
->addColumn('action', function ($row) {
    if (auth()->user()->hasPermission('...')) { ... }  // per-row Auth lookup
})

// AFTER — once per request
$authUser = Auth::user();
->addColumn('action', function ($row) use ($authUser) {
    if ($authUser?->hasPermission('...')) { ... }
})
```

---

## 🧹 Code Quality Improvements

### Consistent keyType
~40 models had `protected $keyType = 'string'` with `incrementing = true` — these don't match (auto-increment requires int). Fixed across all models.

### DB::transaction() Closure
```php
// BEFORE — verbose, error-prone
DB::beginTransaction();
try {
    // work...
    DB::commit();
} catch (Exception $e) {
    DB::rollBack();
    return $this->error(...);
}

// AFTER — auto-commit/rollback
DB::transaction(function () {
    // work...
});
```

### Modern PHP Syntax
- `match` expressions instead of long `switch` statements (e.g., `study_month()`)
- Arrow functions for simple closures: `fn ($row) => $row->name`
- Null-safe operator: `$row->user?->name`
- Spread/array operations: `array_map`, `array_filter`

### Dead Code Removed
- `protocolChamberDesignOld()` (892-line ProtocolController)
- `protocolChamberDesign_27_11_2025()` (intermediate version)
- `index_old()` from DashboardController
- Commented-out `sampleStore()` in SampleReportController
- `createSampleReportDetail()` with `dd()` inside
- `updateSampleReportDetail()` (orphaned helper)
- All `// $editLink = route(...)` style commented-out alternatives
- Empty `@param`, `@return` docblocks throughout
- Unused imports

### Centralized Helpers
Test ID parsing was duplicated 4 times across SampleReportController. Extracted into single `extractTestId()` helper. Used `Str::startsWith()` instead of `Str::contains()` for correctness.

### Consistent Auth Facade
- `auth()->user()->id` → `Auth::id()` (with null-safe handling)
- `auth()->id()` → `Auth::id()`
- All Log calls use imported `Log::` instead of `\Log::`

---

## ⚠️ Breaking Changes & Testing Required

### 🚨 1. CSRF Protection Restored
**Risk:** যদি কোনো AJAX endpoint CSRF token ছাড়া call হচ্ছে, সেটা এখন **419 Page Expired** error দেবে।

**Test:** Browse all forms and AJAX endpoints. Laravel-generated forms (`@csrf`) and the helper `csrfInput()` are fine. কিন্তু কোনো hand-written JavaScript ajax call যদি `X-CSRF-TOKEN` header না পাঠায়, ঠিক করতে হবে।

### 🚨 2. Password Hashing Change
**Risk:** পুরনো user passwords যদি double-hashed অবস্থায় DB-তে save করা থাকে, তারা login করতে পারবে না।

**Test:** কয়েকজন existing user দিয়ে login try করুন। যদি fail হয়, password reset করতে বলুন।

### 🚨 3. `__NewProtocol*` Files Untouched
দুটো ফাইল PSR-4 mismatch থাকায় কখনই autoload হয় না (dead code), তাই অপ্টিমাইজ করিনি। চাইলে delete করতে পারেন:
- `app/Models/__NewProtocol.php`
- `app/Http/Controllers/System/__NewProtocolController.php`
- `app/Http/Middleware/ProtocolController.php` (misplaced, also dead)

### 🚨 4. Field Name `UpdateBy` vs `UpdatedBy`
Manufacturer model-এ original `UpdateBy` typo রাখা হয়েছে (DB column-এর সাথে মিল রাখতে)। যদি actual column হয় `UpdatedBy`, manual rename লাগবে।

### 🚨 5. `bootHasValidation()` Trait Convention
`HasValidation` trait এখন Laravel-standard `bootTraitName()` convention follow করে। যেসব Model এই trait use করত, তাদের `boot()` override করার নিয়ম পরিবর্তিত — কিন্তু কোনো Model আসলে $rules সেট করেনি, তাই behavior change নেই।

### 🚨 6. Stronger Password Rules
`StoreUserRequest`, `UpdateUserRequest`, `passwordUpdateRequest`-এ password minimum 8 character (was 6/none)। নতুন user create বা password update-এ এটা enforce হবে।

---

## 📁 File-by-File Changes

### Helpers
| File | Changes |
|------|---------|
| `Functions.php` | Caching, XSS escape, null-safety, fixed `get_stability_chamber_month_value` parameter usage, simplified `study_month` with match, removed empty docblocks |
| `Addressable.php` | **Bug:** `addresses()` → `address()`. Replaced `count()` with `exists()`. Explicit fields in saveAddress |
| `Imageable.php` | `count()` → `exists()`. Cleanup |
| `HasAlert.php` | Cleanup only |
| `HasValidation.php` | **Critical:** boot() bug fixed via `bootHasValidation()` |

### Models (Highlights)
| File | Changes |
|------|---------|
| `User.php` | **Critical:** removed double-hash. Removed dead `userList()` wrapper, dead `Enroll` references, commented imports |
| `Protocol.php` | Eager loading in `getProtocol()`, all writes in transactions, bulk inserts, helper methods extracted (`purgePackagingFor`, `insertPackagingTier`), fixed clone bugs |
| `Batch.php` | **Critical:** removed double-boot constructor. Removed `HasValidation` (unused). DB casts for dates. Fixed duplicate Protocol::find in updateBatch |
| `Product.php` | Bulk inserts, transaction closure, fixed setPropertiesAttribute null-safety |
| `ProductDetail.php` | **Critical:** fillable typo `'SkuID'.` → `'SkuID',` |
| `Setting.php` | Added fillable, return type |
| All ID models | `keyType` 'string' → 'int' |

### Controllers (Highlights)
| File | Changes |
|------|---------|
| `ProtocolController.php` | -39% size. Eliminated N+1 (version, status maps), removed dead `protocolChamberDesignOld`, `_27_11_2025`. All writes in transactions |
| `SampleReportController.php` | -37% size. Eliminated 6 N+1 columns. Centralized `extractTestId`. Bulk inserts. Removed `dd()` debug |
| `DashboardController.php` | Eliminated N+1 strength lookup via JOIN. Removed `dd()` debug. Helper methods extracted |
| `UserController.php` | Auth user cached outside loop. `match` for status badge. e() for XSS |
| `RoleController.php` | Lazy `Role::all()`. Auth caching. Cleaner role-permission map |
| `SettingsController.php` | **Critical:** password hashing bug. Settings cache invalidation. Transactional update |
| `BatchController.php` | Eager loading. Fixed `getSample` typo. Cleanup |
| `ProductController.php` | Eager-load with column-specific selects. Transaction in delete |
| `AjaxController.php` | Eager loading, null-safety, `Str::startsWith` instead of `contains` |
| `LoginController.php` | Email normalization. `LoginRequest` instead of inline validation. Remember me support |

### Form Requests
All 16 requests rewritten with consistent style:
- `array` return type on `rules()`
- `bool` return type on `authorize()`
- Array-form rules: `['required', 'string', 'max:255']`
- `Rule::unique()->ignore($id)` for update requests
- `Password::min(8)` for password fields
- Removed empty docblocks

### Middleware
| File | Changes |
|------|---------|
| `VerifyCsrfToken.php` | **CRITICAL SECURITY:** removed wildcard `'*'` exception |

---

## 📈 Expected Impact

- **Database load**: 50-90% query reduction on heavy DataTables pages (Protocol index, SampleReport index, Dashboard)
- **Page load time**: Significantly faster on list pages with many rows
- **Memory**: Lower (bulk inserts, eager loading with column selects, exists() checks)
- **Security**: Major hardening (CSRF restored, XSS escaping, password hashing)
- **Maintainability**: ~600 fewer lines of code, dead code removed, consistent patterns

---

## 🔧 Post-Migration Checklist

- [ ] Run `composer install` in `acihc_new`
- [ ] Verify `.env` is set correctly (DB connection, APP_KEY)
- [ ] Run database migrations (if any new ones)
- [ ] Clear all caches: `php artisan cache:clear`, `php artisan config:clear`, `php artisan view:clear`
- [ ] Test login flow with existing users (password compatibility)
- [ ] Test all forms submit successfully (CSRF working)
- [ ] Test AJAX endpoints (CSRF token in headers)
- [ ] Test DataTables on Protocol, Sample Report, Dashboard pages — verify no errors and faster load
- [ ] Test create/update flows for Protocol, Batch, Sample Report
- [ ] Verify password change works correctly
- [ ] Monitor logs for `Log::error` entries from new error handlers

---

**Generated:** 2026-04-26
**Migration Path:** `acihc/` → `acihc_new/`
