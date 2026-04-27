<div align="center">

# 📜 পরিবর্তনের লগ (Changelog)

### সব উল্লেখযোগ্য পরিবর্তনের তালিকা

```
╔══════════════════════════════════════════════╗
║   📅  ভার্সন হিস্টোরি ও আপডেট ট্র্যাকিং  📅       ║
╚══════════════════════════════════════════════╝
```

</div>

---

> 📌 এই ফাইলের ফরম্যাট [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) অনুসরণ করে।
> এই প্রজেক্ট [Semantic Versioning](https://semver.org/spec/v2.0.0.html) মেনে চলে।

---

## 🏷️ পরিবর্তনের ধরন

| 🏷️ ট্যাগ | 📝 বর্ণনা |
|:---:|:---|
| ✨ `Added` | নতুন ফিচার |
| 🔄 `Changed` | বিদ্যমান ফিচারে পরিবর্তন |
| 🗑️ `Deprecated` | শীঘ্রই বাদ পড়বে |
| ❌ `Removed` | বাদ দেয়া হয়েছে |
| 🐛 `Fixed` | বাগ ফিক্স |
| 🔐 `Security` | নিরাপত্তা সংক্রান্ত |

---

## 🚧 [Unreleased]

### ✨ Added
- 📚 পূর্ণাঙ্গ বাংলা ডকুমেন্টেশন (README, CONTRIBUTING, CHANGELOG)
- 📜 MIT লাইসেন্স ফাইল
- 🗺️ ভবিষ্যৎ রোডম্যাপ
- ❓ FAQ section README-তে

### 🔄 Changed
- 🎨 README সম্পূর্ণ নতুন স্টাইলে redesign

---

## 🎉 [2.0.0] - 2026-04-27

### ✨ Added
- 🗄️ মাল্টি-ডাটাবেজ সাপোর্ট (MySQL / MS SQL Server / SQLite)
- 📘 [SETUP.md](SETUP.md) - পূর্ণাঙ্গ DB সেটআপ গাইড
- 📗 [OPTIMIZATION.md](OPTIMIZATION.md) - অপ্টিমাইজেশন ডকুমেন্টেশন
- 🌱 ডেমো ডেটা ইম্পোর্ট কমান্ড (`php artisan demo:import`)
- ⚡ পারফরম্যান্স boost কমান্ড (`php artisan boost:performance`)

### 🔄 Changed
- ♻️ **108 PHP ফাইল** অপ্টিমাইজ করা হয়েছে
- 📉 `ProtocolController.php`: 892 → 545 লাইন (**-39%**)
- 📉 `SampleReportController.php`: 564 → 355 লাইন (**-37%**)
- 📉 `Functions.php` helper: 416 → 282 লাইন (**-32%**)
- 🚀 Eloquent query অপ্টিমাইজেশন - N+1 সমস্যা সমাধান
- 💾 ক্যাশিং strategy উন্নত করা হয়েছে

### 🐛 Fixed
- 🛠️ **12+ ক্রিটিক্যাল বাগ** ফিক্স
- 🔧 `Addressable` helper-এ relation name বাগ
- 🔧 `Imageable`-এ `count()` → `exists()` (পারফরম্যান্স)
- 🔧 `HasValidation` boot() পদ্ধতিতে critical bug
- 🔧 CSRF middleware-এ নিরাপত্তা সমস্যা

### 🔐 Security
- 🛡️ XSS সুরক্ষা যোগ - সব user input-এ
- 🛡️ Mass assignment vulnerability ফিক্স
- 🛡️ CSRF middleware হার্ডেনিং
- 🛡️ SQL injection-এর সম্ভাব্য vector বন্ধ

### 🧹 Removed
- 🗑️ **600+ লাইন** dead code সরানো হয়েছে
- 🗑️ অব্যবহৃত helper functions
- 🗑️ Commented-out legacy code

---

## 🚀 [1.5.0] - 2025-Q4

### ✨ Added
- 📊 Yajra DataTables integration
- 📑 mPDF দিয়ে PDF report generation
- 🔔 Toastr notification system
- 📜 Laravel Auditing দিয়ে audit trail

### 🔄 Changed
- ⬆️ Laravel framework `^9.0` → `^10.10`
- ⬆️ PHP requirement `^8.0` → `^8.1`

---

## 🎯 [1.0.0] - 2025-Q2

### ✨ Added
- 💊 Product management module
- 📋 Protocol management with multi-stage approval
- 🧬 Batch ও sample tracking
- 🏭 Manufacturer ও market management
- 👥 Laratrust দিয়ে role-based access control
- 🔐 Laravel Sanctum দিয়ে API authentication
- 🎨 Custom admin theme (Bootstrap 5)
- 💾 Redis (Predis) ক্যাশ ও session
- 🗄️ MySQL primary database support

### 📌 প্রাথমিক রিলিজ

> 🎉 **প্রথম production-ready release** — পূর্ণাঙ্গ pharmaceutical management system হিসেবে।

---

## 📅 ভার্সন তুলনা

<div align="center">

| 🏷️ ভার্সন | 📅 তারিখ | 🎯 মূল হাইলাইট |
|:---:|:---:|:---|
| **2.0.0** | 2026-04-27 | মাল্টি-DB, 40% পারফরম্যান্স বুস্ট, সিকিউরিটি ফিক্স |
| **1.5.0** | 2025-Q4 | DataTables, PDF, Audit logging |
| **1.0.0** | 2025-Q2 | প্রাথমিক production রিলিজ |

</div>

---

<div align="center">

```
╔══════════════════════════════════════════════════╗
║                                                  ║
║   🌟  প্রতিটি আপডেটে আমরা আরও ভালো হচ্ছি  🌟       ║
║                                                  ║
╚══════════════════════════════════════════════════╝
```

**⬆ [উপরে ফিরে যান](#-পরিবর্তনের-লগ-changelog)**

</div>
