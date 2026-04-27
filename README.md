<div align="center">

# 🌿 এসিআই হেলথকেয়ার ম্যানেজমেন্ট সিস্টেম 🌿

### ✨ ACI Healthcare Management System ✨

<br>

```
╔═══════════════════════════════════════════════════════════╗
║   💊  ফার্মাসিউটিক্যাল প্রোডাক্ট, প্রোটোকল ও ব্যাচ ম্যানেজমেন্ট  💊   ║
╚═══════════════════════════════════════════════════════════╝
```

<br>

[![Laravel](https://img.shields.io/badge/⚡_Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/🐘_PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/🐬_MySQL-Ready-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![MSSQL](https://img.shields.io/badge/🟦_MSSQL-Ready-CC2927?style=for-the-badge&logo=microsoftsqlserver&logoColor=white)](https://www.microsoft.com/sql-server)
[![SQLite](https://img.shields.io/badge/📦_SQLite-Ready-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)

[![License](https://img.shields.io/badge/📜_License-MIT-22c55e?style=for-the-badge)](https://opensource.org/licenses/MIT)
[![Status](https://img.shields.io/badge/🚀_Status-Production_Ready-success?style=for-the-badge)]()
[![Bangla](https://img.shields.io/badge/🇧🇩_Made_in-Bangladesh-006a4e?style=for-the-badge)]()

<br>

╔══════════════════════════════════════════════════╗

**🎯 দ্রুত নেভিগেশন 🎯**

[ 🌟 পরিচিতি ](#-প্রকল্প-পরিচিতি) • [ ✨ ফিচার ](#-ফিচারসমূহ) • [ 🛠️ প্রযুক্তি ](#️-প্রযুক্তি-স্ট্যাক) • [ 📦 প্রয়োজনীয়তা ](#-প্রয়োজনীয়তা)

[ 🚀 ইনস্টলেশন ](#-ইনস্টলেশন) • [ ⚙️ কনফিগ ](#️-কনফিগারেশন) • [ 🗄️ ডাটাবেজ ](#️-ডাটাবেজ-সেটআপ) • [ ▶️ চালু ](#️-অ্যাপ-চালু-করুন)

[ 🔄 ওয়ার্কফ্লো ](#-মূল-ওয়ার্কফ্লো) • [ 📚 গ্লসারি ](#-ডোমেইন-গ্লসারি) • [ 📁 স্ট্রাকচার ](#-প্রজেক্ট-স্ট্রাকচার) • [ 🔐 লগইন ](#-ডিফল্ট-লগইন)

[ 📸 স্ক্রিনশট ](#-স্ক্রিনশট) • [ 🗺️ রোডম্যাপ ](#️-রোডম্যাপ)

[ 📊 পরিসংখ্যান ](#-প্রজেক্ট-পরিসংখ্যান) • [ ❓ প্রশ্নোত্তর ](#-প্রায়শই-জিজ্ঞাসিত-প্রশ্ন) • [ 📚 ডকস ](#-অতিরিক্ত-ডকুমেন্টেশন) • [ 📄 লাইসেন্স ](#-লাইসেন্স)

╚══════════════════════════════════════════════════╝

</div>

---

## 🌟 প্রকল্প পরিচিতি

> 💡 **এক নজরে:** **ACI Healthcare (ACIHC)** একটি Laravel 10-ভিত্তিক enterprise-grade **ফার্মাসিউটিক্যাল প্রোটোকল ও স্যাম্পল টেস্টিং ম্যানেজমেন্ট সিস্টেম**। মূলত **Stability Testing Protocol Lifecycle** management — প্রোডাক্টের stability study design, multi-stage approval workflow, batch tracking, sample report generation ও pharmaceutical industry compliance handle করে।

### 🏥 কোন সমস্যার সমাধান করে?

ফার্মাসিউটিক্যাল ইন্ডাস্ট্রিতে প্রতিটি প্রোডাক্টের **stability testing** ICH Q1A guideline অনুযায়ী perform করতে হয় — accelerated, intermediate ও long-term condition-এ। এই process-এ involve থাকে:

- 📋 জটিল protocol document (50+ field)
- 👥 Multi-level approval chain (reviewer → approver → final)
- 🏭 Multiple manufacturer ও market জুড়ে batch deployment
- 🧪 প্রতিটি sample-এর scheduled testing ও report generation
- 📜 Regulatory compliance-এর জন্য complete audit trail

ACIHC এই সম্পূর্ণ workflow-কে **একটি single platform**-এ centralize করে, ম্যানুয়াল paper-based work ও Excel-driven chaos-এর জায়গায় একটি **traceable, auditable, role-controlled** digital system দেয়।

<table>
<tr>
<td width="50%" align="center">

### 🎨 কেন এই সিস্টেম?

🔹 ICH Q1A **stability protocol** workflow built-in
🔹 **Multi-stage approval** tree (reviewer + approver hierarchy)
🔹 প্রতি ফিল্ড পরিবর্তনের **পূর্ণ audit trail** (Owen-IT)
🔹 **Role-based access control** (Laratrust)
🔹 এক ক্লিকে **PDF report** generation (mPDF)
🔹 তিন-তিনটা ডাটাবেজ — **এক কোডবেজ**

</td>
<td width="50%" align="center">

### 🏆 মূল লক্ষ্য

🔸 ফার্মা ইন্ডাস্ট্রির **regulatory compliance** নিশ্চিত করা
🔸 Stability testing-এর **manual workflow** সম্পূর্ণ ডিজিটাল
🔸 **Cross-functional approval** workflow streamline
🔸 Sample-to-report **complete traceability**
🔸 **Production-ready** enterprise architecture
🔸 **108 ফাইল** অপ্টিমাইজড — fast & reliable

</td>
</tr>
</table>

### 📊 প্রজেক্ট পরিধি (Scale)

```
┌──────────────────────────────────────────────────────────┐
│  🗂️  63 Eloquent Models       →  Domain entities          │
│  🎮  27 Controllers           →  Business logic           │
│  📜  80+ Migrations           →  Database schema          │
│  🛣️  5 Route files            →  Modular routing          │
│  📝  16 Form Requests         →  Input validation         │
│  🌱  7 Seeders                →  Demo data                │
│  🌿  ~3000+ Lines schema       →  Comprehensive coverage   │
└──────────────────────────────────────────────────────────┘
```

---

## ✨ ফিচারসমূহ

### 🎯 মূল মডিউল ওভারভিউ

<div align="center">

| 🎯 মডিউল | 🔍 কী করে | 📊 |
|:---:|:---|:---:|
| 📋 **Protocol Management** | Stability protocol design, multi-step form, approval tree | ✅ |
| 🧪 **Sample Management** | Sample CRUD, scheduled testing, condition tracking | ✅ |
| 📑 **Sample Report** | Test result entry, PDF report, multi-level approval | ✅ |
| 💊 **Product Master** | Product, API ingredient, pack, packaging hierarchy | ✅ |
| 🧬 **Batch Tracking** | Batch generation, MFG/EXP date, withdrawal log | ✅ |
| 🏭 **Manufacturer** | Manufacturer profile + polymorphic address/image | ✅ |
| 🌍 **Market** | অঞ্চলভিত্তিক market segment management | ✅ |
| 🏗️ **Container & Pack** | Container, packaging, primary/secondary/tertiary pack | ✅ |
| 🌡️ **Stability Study** | Chamber design, accelerated/intermediate/long-term | ✅ |
| ⚗️ **Test & Subtest** | Lab test specification ও sub-test parameter | ✅ |
| 👥 **Role & Permission** | Laratrust RBAC — fine-grained permission | ✅ |
| 📊 **Audit Trail** | Owen-IT — প্রতি model change-এর full history | ✅ |
| 🔐 **Authentication** | Laravel Sanctum + session-based auth | ✅ |
| 📈 **Activity Log** | User activity log + DataTables view | ✅ |
| 📑 **PDF Generation** | mPDF — protocol ও sample report PDF | ✅ |
| 🔔 **Notification** | Toastr — real-time success/error alert | ✅ |
| 🌐 **DataTables** | Yajra — server-side pagination, search, export | ✅ |
| 🗄️ **Multi-Database** | MySQL / MSSQL / SQLite — তিনটাই কাজ করে | ✅ |

</div>

---

### 🔬 ডিটেইলড মডিউল ব্রেকডাউন

<details open>
<summary><b>📋 প্রোটোকল ম্যানেজমেন্ট সিস্টেম</b></summary>

<br>

ICH Q1A guideline অনুযায়ী **stability testing protocol** তৈরি ও manage করার পূর্ণাঙ্গ workflow। প্রোটোকল একটা multi-step form, প্রতি step আলাদা database table-এ store হয়।

**📌 মাল্টি-স্টেপ ফর্ম স্ট্রাকচার:**

```
1️⃣  Product Detail        →  প্রোডাক্ট, market, manufacturer select
2️⃣  Container & SKU       →  Primary container ও SKU configuration
3️⃣  Packaging Profile     →  Primary / Secondary / Tertiary packaging
4️⃣  Stability Study       →  Accelerated, Intermediate, Long-term study
5️⃣  Chamber Design        →  Storage chamber month-wise mapping
6️⃣  Test Specification    →  Lab test ও sub-test list
7️⃣  API Detail            →  Active Pharmaceutical Ingredient details
8️⃣  Placebo Design        →  Placebo formulation specification
9️⃣  Batch Design          →  Batch link ও test schedule
🔟  Approval Tree         →  Reviewer + approver hierarchy define
```

**🌳 Approval Tree ফিচার:**
- 👀 **Reviewer** assign — initial review responsibility
- ✅ **Approver** assign — final approval authority
- 🔁 Multi-level approval chain
- 📊 প্রতি stage-এ status tracking
- 📝 History reason logging (কেন approve/reject হলো)

**📦 Database Tables (~25টা):**
`Protocol`, `ProtocolStatus`, `ProtocolApproval`, `ProtocolApprovalTree`, `ProtocolApprovalType`, `ProtocolApprover`, `ProtocolReviewer`, `ProtocolHistoryReason`, `ProtocolProductDetail`, `ProtocolAPIDetail`, `ProtocolBatch`, `ProtocolTest`, `ProtocolSubTest`, `ProtocolSkuPack`, `ProtocolSkuPackContainer`, `ProtocolSkuUnitPack`, `ProtocolSkuTest`, `ProtocolStabilityStudy`, `ProtocolStabilityStudyDetail`, `ProtocolStabilityChamberDesign`, `ProtocolPlaceboDetail`, `ProtocolPackagingPack`, `ProtocolPackPrimary`, `ProtocolPackSecondary`, `ProtocolPackTertiary`

</details>

<details open>
<summary><b>🧪 স্যাম্পল ও রিপোর্ট ম্যানেজমেন্ট</b></summary>

<br>

প্রোটোকল-এর সাথে linked স্যাম্পল testing ও তার লাইফসাইকেল ম্যানেজমেন্ট।

**🎯 ফিচার:**
- ➕ **Sample CRUD** — protocol-batch থেকে sample auto-generate
- 📅 **Scheduled Testing** — month-wise test schedule (0, 1, 3, 6, 9, 12 month etc.)
- 🌡️ **Condition Tracking** — accelerated (40°C/75% RH), intermediate (30°C/65% RH), long-term (25°C/60% RH)
- 📊 **Sample Report** — প্রতি test-এর result entry
- 🌳 **Approval Workflow** — independent reviewer + approver tree
- 📑 **PDF Export** — formal test report generation
- 🔍 **Detail Drill-down** — sample → report → test → subtest hierarchy

**📦 Database Tables:**
`Sample`, `SampleReport`, `SampleReportDetail`, `SampleApprovalTree`, `SampleApprover`, `SampleReviewer`, `SampleApprovalType`

</details>

<details open>
<summary><b>💊 প্রোডাক্ট ও মাস্টার ডেটা</b></summary>

<br>

প্রোটোকল ও sample-এর foundation — সব master entity।

| 🗂️ Entity | 📝 কী store করে |
|:---|:---|
| 💊 **Product** | Pharmaceutical product master (name, code, type) |
| 📦 **ProductPack** | Pack-wise variant (e.g., 10 tablet, 30 capsule) |
| 🧪 **APIDetail** | Active Pharmaceutical Ingredient (drug substance) |
| 🏗️ **Container** | Storage container type (bottle, blister, sachet) |
| 📦 **Packaging** | Packaging spec ও level |
| ⚗️ **Test** | Lab test method (assay, dissolution, related substance) |
| 🧫 **Subtest** | Test-এর sub-component (যেমন individual impurity) |
| 🌡️ **Condition** | Storage condition (temperature/humidity combo) |
| 🎯 **StudyType** | Study classification (AC/IN/LT) |
| 🏭 **Manufacturer** | Producer company profile |
| 🌍 **Market** | Geographic market region |
| 💉 **Placebo** | Placebo formulation reference |

</details>

<details open>
<summary><b>🧬 ব্যাচ ম্যানেজমেন্ট</b></summary>

<br>

প্রোডাকশন ব্যাচ ও তাদের sample lifecycle।

- 🆕 **Batch Creation** — manufacturing date, expiry date, batch size
- 🔁 **Batch Clone** — existing batch থেকে duplicate তৈরি
- 📤 **Withdrawal Tracking** — কোন batch কখন withdraw হলো
- 📊 **Dashboard Widget** — withdrawn batch DataTable display
- 📥 **Excel Export** — withdrawal history export

</details>

<details open>
<summary><b>👥 ইউজার, রোল ও পারমিশন</b></summary>

<br>

Laratrust-powered fine-grained access control।

**🎯 কী আছে:**
- 👨‍💼 **User Management** — admin/staff user CRUD with profile
- 🎭 **Role Definition** — multiple role create করা যায়
- 🔑 **Permission** — module-wise granular permission
- 🌳 **Role-Permission Mapping** — role-এ permission assign
- 📸 **Profile Image** — polymorphic image relation (Imageable trait)
- 🏠 **Address** — polymorphic address relation (Addressable trait)
- 🔐 **Sanctum API Token** — REST API authentication-এর জন্য

</details>

<details open>
<summary><b>📊 অডিট ট্রেইল ও অ্যাক্টিভিটি লগ</b></summary>

<br>

Regulatory compliance-এর জন্য essential — কে, কখন, কী পরিবর্তন করেছে সব track।

**📌 যে models audit হয়:**
- ✅ Protocol, SampleReport, User
- ✅ Test, Subtest, Condition, APIDetail
- ✅ Container, Packaging

**📈 যা track হয়:**
- 🕐 Timestamp (created/updated/deleted)
- 👤 কোন user action নিয়েছে
- 🔄 Old value → New value (field-wise diff)
- 🌐 IP address, user agent
- 📊 Activity log DataTables view-এ available

</details>

<details open>
<summary><b>🔧 হেল্পার ও ইউটিলিটি</b></summary>

<br>

`app/Helpers/Functions.php`-এ available helper functions:

| 🛠️ Helper | 🔍 কী করে |
|:---|:---|
| `domain()` | App-এর domain URL return |
| `imagePath()` | Image URL formatting |
| `getSystemSettings()` | Cached system setting lookup |
| `userActivityLog()` | Recent activity log fetch |
| `getUserRoleAndPermission()` | Role + permission load with count |
| `safeUrl()` | XSS-safe URL escaping |
| `getDynamicButtonLink()` | Inline edit/delete button HTML |
| `sampleButton()`, `batch_button()` | Module-specific action buttons |
| `convertJsonToArray()` | JSON helper |
| `study_month()` | Month → study type (AC/IN/LT) mapping |
| `get_stability_chamber_month_value()` | Stability chamber data extraction |

**🎁 Trait helpers:**
- 🏠 `Addressable` — polymorphic address relation
- 🖼️ `Imageable` — polymorphic image relation
- 🔔 `HasAlert` — flash message helper
- ✅ `HasValidation` — model-level validation on create

</details>

---

## 🛠️ প্রযুক্তি স্ট্যাক

<details open>
<summary><b>🔧 ব্যাকএন্ড (Backend)</b></summary>

```
🔴  Laravel 10.x          →  মূল ফ্রেমওয়ার্ক
🐘  PHP 8.1+              →  রানটাইম ভাষা
🛡️  Laratrust             →  রোল ও পারমিশন
📜  Laravel Auditing      →  পরিবর্তন ট্র্যাকিং
🔐  Laravel Sanctum       →  API অথেনটিকেশন
📄  mPDF                  →  PDF জেনারেশন
🗂️  Yajra DataTables      →  সার্ভার-সাইড টেবিল
💾  Predis                →  Redis ক্যাশ ক্লায়েন্ট
```

</details>

<details open>
<summary><b>🎨 ফ্রন্টএন্ড (Frontend)</b></summary>

```
🅱️  Bootstrap 5           →  UI ফ্রেমওয়ার্ক
⚡  Vite                  →  অ্যাসেট বান্ডলার
📊  DataTables.js         →  ইন্টার‍্যাক্টিভ টেবিল
🔔  Toastr                →  নোটিফিকেশন
🎭  Custom Admin Theme    →  অ্যাডমিন প্যানেল
```

</details>

<details open>
<summary><b>💾 অবকাঠামো (Infrastructure)</b></summary>

```
🔥  Redis                 →  ক্যাশ ও সেশন স্টোর
🐬  MySQL 5.7+            →  প্রাইমারি ডিবি
🟦  MS SQL Server 2017+   →  এন্টারপ্রাইজ অপশন
📦  SQLite 3              →  ডেভেলপমেন্ট ডিবি
```

</details>

---

## 📦 প্রয়োজনীয়তা

<div align="center">

| 🔧 টুল | ⚡ ন্যূনতম সংস্করণ | 📝 উদ্দেশ্য |
|:---:|:---:|:---|
| 🐘 PHP | `8.1` | Backend রানটাইম |
| 🎼 Composer | `2.x` | PHP ডিপেন্ডেন্সি ম্যানেজার |
| 📦 Node.js | `18+` | Frontend বিল্ড |
| 🗄️ ডাটাবেজ | MySQL/MSSQL/SQLite | ডেটা স্টোরেজ |
| 🌐 ওয়েব সার্ভার | Apache/Nginx | HTTP সার্ভিং |

</div>

> 📌 **প্রয়োজনীয় PHP এক্সটেনশন:** `pdo` • `mbstring` • `openssl` • `tokenizer` • `xml` • `ctype` • `json` • `bcmath` • `fileinfo` • `gd`

---

## 🚀 ইনস্টলেশন

> ⚠️ শুরু করার আগে নিশ্চিত হোন যে PHP, Composer ও Node.js সঠিকভাবে ইনস্টল করা আছে।

### 1️⃣ রিপোজিটরি ক্লোন করুন

```bash
git clone <repo-url> acihc
cd acihc
```

### 2️⃣ PHP ডিপেন্ডেন্সি ইনস্টল

```bash
composer install
```

### 3️⃣ ফ্রন্টএন্ড ডিপেন্ডেন্সি

```bash
npm install
npm run build      # 🏭 প্রোডাকশনের জন্য
npm run dev        # 🔥 হট-রিলোডসহ ডেভেলপমেন্ট
```

### 4️⃣ এনভায়রনমেন্ট সেটআপ

```bash
cp .env.example .env
php artisan key:generate
```

### 5️⃣ স্টোরেজ লিংক

```bash
php artisan storage:link
```

✅ **ব্যস! ইনস্টলেশন কমপ্লিট।**

---

## ⚙️ কনফিগারেশন

`.env` ফাইলে নিচের মানগুলো ঠিক করুন:

```env
# 🎨 অ্যাপ্লিকেশন
APP_NAME="ACI Healthcare"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# 🗄️ ডাটাবেজ (নিচে বিস্তারিত)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=acihealthcare
DB_USERNAME=root
DB_PASSWORD=

# 💾 ক্যাশ ও সেশন
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# 📧 মেইল (ঐচ্ছিক)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
```

---

## 🗄️ ডাটাবেজ সেটআপ

<div align="center">

| 🎯 ডিবি | 🔍 কখন ব্যবহার করবেন | ⚡ সহজতা |
|:---:|:---|:---:|
| 🐬 **MySQL** | প্রোডাকশন / WAMP / XAMPP | ⭐ সহজ |
| 🟦 **MS SQL Server** | এন্টারপ্রাইজ / লিগ্যাসি ডেটা | ⭐⭐⭐ মাঝারি |
| 📦 **SQLite** | লোকাল ডেভ / দ্রুত টেস্ট | ⭐ সবচেয়ে সহজ |

</div>

### 🔄 মাইগ্রেশন চালান

```bash
php artisan migrate
```

### 🌱 ডেমো ডেটা সিড করুন

```bash
php artisan db:seed
# অথবা — fresh migrate + seed একসাথে
php artisan demo:import
```

**🌱 যে ডেটা seed হয়:**
- 👨‍💼 Demo users (`admin@admin.com` / `password`)
- 🎭 Default roles (admin, staff)
- 🔑 Permission list
- 🌳 Role-permission mapping
- ⚙️ System settings
- 📊 Backup reference data

> 📘 **পূর্ণাঙ্গ ডিবি সেটআপ গাইড:** [SETUP.md](SETUP.md) দেখুন

---

## ▶️ অ্যাপ চালু করুন

### 🔥 ডেভেলপমেন্ট মোড

```bash
# Terminal 1: ব্যাকএন্ড
php artisan serve
# 🌐 http://localhost:8000

# Terminal 2: ফ্রন্টএন্ড
npm run dev
```

### 🖥️ WAMP / XAMPP

`public/` ফোল্ডারকে web root হিসেবে point করুন। অথবা virtual host:

```apache
<VirtualHost *:80>
    ServerName acihc.local
    DocumentRoot "d:/wamp64/www/acihc/public"
    <Directory "d:/wamp64/www/acihc/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 🚀 প্রোডাকশন বিল্ড

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### ⚙️ Custom Artisan Commands

প্রজেক্টে দুটো কাস্টম artisan command আছে:

| 🎯 কমান্ড | 📝 কী করে |
|:---|:---|
| `php artisan boost:app` | 🚀 Cache, route, view, config — সব optimize একসাথে |
| `php artisan demo:import` | 🌱 Fresh migration + demo data seed (development জন্য) |

---

## 🔄 মূল ওয়ার্কফ্লো

### 📋 Protocol Lifecycle

```
   👤 Admin/Staff
        │
        ▼
   ┌─────────────────────┐
   │  📝 Create Protocol  │  ← Multi-step form (10 steps)
   └─────────┬───────────┘
             │
             ▼
   ┌─────────────────────┐
   │  🌳 Approval Tree    │  ← Reviewer + Approver assign
   └─────────┬───────────┘
             │
             ▼
   ┌─────────────────────┐         ┌─────────────────────┐
   │  👀 Reviewer Review  │  ───►   │  ✅ Approver Approve │
   └─────────┬───────────┘         └─────────┬───────────┘
             │                                │
             ▼                                ▼
   ┌─────────────────────┐         ┌─────────────────────┐
   │  📊 Status: Active   │  ◄───   │  📑 PDF Generated    │
   └─────────┬───────────┘         └─────────────────────┘
             │
             ▼
   ┌─────────────────────┐
   │  🧬 Batch Linking    │
   └─────────┬───────────┘
             │
             ▼
   ┌─────────────────────┐
   │  🧪 Sample Generated │  ← Scheduled per condition × month
   └─────────────────────┘
```

### 🧪 Sample → Report Lifecycle

```
   🧬 Batch
     │
     ▼
   🧪 Sample (auto-generated per schedule)
     │
     ▼
   📝 Sample Report Entry (test results)
     │
     ▼
   👀 Reviewer Review
     │
     ▼
   ✅ Approver Approve
     │
     ▼
   📑 Final PDF Report
```

---

## 📚 ডোমেইন গ্লসারি

ফার্মাসিউটিক্যাল ও stability testing-এর key concept যা এই system বুঝতে দরকার।

<details>
<summary><b>🧪 Stability Testing — কী এবং কেন?</b></summary>

<br>

ICH Q1A guideline অনুযায়ী প্রতিটা pharmaceutical product market-এ release হওয়ার আগে ও পরে **নির্দিষ্ট condition-এ store করে দেখতে হয়** কত time পরে product-এর quality, potency, ও safety degrade হয়। এর উপর ভিত্তি করেই **expiry date** নির্ধারণ হয়।

</details>

<details>
<summary><b>🌡️ Study Type — AC, IN, LT কী?</b></summary>

<br>

| Code | নাম | Condition | উদ্দেশ্য |
|:---:|:---|:---|:---|
| **AC** | Accelerated | 40°C ± 2°C / 75% RH | দ্রুত degradation দেখা (6 months) |
| **IN** | Intermediate | 30°C ± 2°C / 65% RH | মাঝারি condition (12 months) |
| **LT** | Long-term | 25°C ± 2°C / 60% RH | Real-world shelf-life (24-36 months) |

</details>

<details>
<summary><b>📋 Protocol vs Sample vs Batch — পার্থক্য?</b></summary>

<br>

```
📋 Protocol  → একটা product-এর জন্য টেস্টিং blueprint (rules)
              ↓ (links to)
🧬 Batch     → Production batch (specific MFG date)
              ↓ (generates)
🧪 Sample    → Particular condition × month-এর test instance
              ↓ (produces)
📑 Report    → Sample-এর actual test result
```

</details>

<details>
<summary><b>⚗️ API, Excipient, Placebo — কী?</b></summary>

<br>

- 💊 **API (Active Pharmaceutical Ingredient)** — যে chemical আসলে drug action করে (e.g., Paracetamol)
- 🥄 **Excipient** — Inactive ingredient (filler, binder)
- 🍬 **Placebo** — API ছাড়া formulation, control হিসেবে test হয়

</details>

<details>
<summary><b>🌳 Approval Tree — কী?</b></summary>

<br>

প্রোটোকল বা sample report-কে production-এ যেতে হলে multiple stakeholder-এর approval লাগে। Approval tree-এ **reviewer** (initial check) ও **approver** (final sign-off) সিরিয়ালি/parallel-ভাবে define করা যায়।

</details>

<details>
<summary><b>📦 Pack hierarchy — Primary/Secondary/Tertiary?</b></summary>

<br>

- 🟢 **Primary Pack** — Drug-এর immediate contact (blister, bottle)
- 🟡 **Secondary Pack** — Primary pack-এর container (carton)
- 🔵 **Tertiary Pack** — Bulk shipping unit (corrugated box, pallet)

</details>

---

## 📁 প্রজেক্ট স্ট্রাকচার

```
🏠 acihc/
│
├── 📂 app/
│   ├── ⚙️  Console/Commands/        → boost:app, demo:import (2 কমান্ড)
│   ├── 🧰 Helpers/                  → 5 হেল্পার ক্লাস
│   │   ├── Functions.php           → 20+ global utility function
│   │   ├── Addressable.php         → polymorphic address trait
│   │   ├── Imageable.php           → polymorphic image trait
│   │   ├── HasAlert.php            → flash message trait
│   │   └── HasValidation.php       → model validation trait
│   │
│   ├── 🎮 Http/Controllers/         → 27 কন্ট্রোলার
│   │   ├── Admin/                  → 7 admin controller (Dashboard, User, Role, ...)
│   │   ├── System/                 → 18 business controller (Protocol, Sample, ...)
│   │   └── Auth/                   → LoginController
│   │
│   ├── 📝 Http/Requests/            → 16 form request (validation)
│   ├── 🛡️  Http/Middleware/         → custom middleware
│   │
│   ├── 📊 Models/                   → 63 Eloquent মডেল
│   │   ├── Protocol*.php           → 25টা protocol-related model
│   │   ├── Sample*.php             → sample/report models
│   │   ├── Product, APIDetail      → product master
│   │   ├── Batch, Manufacturer     → manufacturing
│   │   └── Container, Packaging    → packaging hierarchy
│   │
│   └── 🛡️  Providers/               → service provider
│
├── 🔧 config/                       → Laravel + custom config
│   ├── laratrust.php               → RBAC config
│   ├── audit.php                   → audit logging config
│   ├── datatables.php              → DataTables config
│   └── midia.php                   → media management config
│
├── 🗄️  database/
│   ├── 📜 migrations/               → 80+ মাইগ্রেশন (~3000 lines)
│   ├── 🌱 seeders/                  → 7 seeder (User, Role, Permission, ...)
│   └── 🏭 factories/                → model factory
│
├── 🌐 public/                       → ওয়েব রুট
│   ├── admin/                      → admin theme assets
│   ├── datatable/                  → DataTables JS/CSS
│   └── images/                     → static images
│
├── 🎨 resources/views/              → Blade টেমপ্লেট
│   ├── admin/                      → dashboard, user, role, settings
│   ├── system/                     → protocol, sample, product, batch, ...
│   ├── auth/                       → login form
│   ├── report/                     → PDF templates
│   └── components/                 → reusable Blade components
│
├── 🛣️  routes/                      → 5 route file (modular)
│   ├── 🌍 web.php                   → admin/auth routes
│   ├── 📡 api.php                   → Sanctum-protected API
│   ├── 📋 protocol.php              → protocol workflow
│   ├── 🧪 sample.php                → sample/report workflow
│   ├── ⚙️  system.php               → master data CRUD
│   ├── 💾 database.php              → DB utilities
│   ├── 📺 channels.php              → broadcast channels
│   └── 🖥️  console.php              → artisan closure
│
├── 💾 storage/                      → logs, cache, uploads
└── 🧪 tests/                        → PHPUnit tests
```

---

## 🔐 ডিফল্ট লগইন

> Seeder চালানোর পর এই credentials দিয়ে login করতে পারবেন:

```
┌─────────────────────────────────────┐
│  📧  Email     :  admin@admin.com   │
│  🔑  Password  :  password          │
└─────────────────────────────────────┘
```

> 🚨 **সতর্কতা:** প্রোডাকশন environment-এ অবশ্যই password পরিবর্তন করুন!

---

## 📸 স্ক্রিনশট

<div align="center">

> 🎨 অ্যাপ্লিকেশনের কিছু ঝলক — production interface থেকে

| 🖥️ ড্যাশবোর্ড | 📋 প্রোটোকল লিস্ট |
|:---:|:---:|
| ![Dashboard](https://via.placeholder.com/450x280/FF2D20/FFFFFF?text=📊+ড্যাশবোর্ড+ভিউ) | ![Protocol](https://via.placeholder.com/450x280/4479A1/FFFFFF?text=📋+প্রোটোকল+ম্যানেজমেন্ট) |

| 💊 প্রোডাক্ট ডিটেইল | 🧬 ব্যাচ ট্র্যাকিং |
|:---:|:---:|
| ![Product](https://via.placeholder.com/450x280/22c55e/FFFFFF?text=💊+প্রোডাক্ট+ডিটেইল) | ![Batch](https://via.placeholder.com/450x280/8b5cf6/FFFFFF?text=🧬+ব্যাচ+ট্র্যাকিং) |

> 📌 আসল স্ক্রিনশট যোগ করতে `docs/screenshots/` ফোল্ডারে images রেখে path update করুন।

</div>

---

## 🗺️ রোডম্যাপ

<div align="center">

### 🎯 আগামী ফিচারসমূহ

</div>

```
┌─ ✅ সম্পন্ন ─────────────────────────────────────────────┐
│   ✓  মাল্টি-ডিবি সাপোর্ট (MySQL/MSSQL/SQLite)            │
│   ✓  রোল-বেজড অ্যাক্সেস কন্ট্রোল                            │
│   ✓  অডিট ট্রেইল লগিং                                    │
│   ✓  PDF রিপোর্ট জেনারেশন                                │
│   ✓  পারফরম্যান্স অপটিমাইজেশন (108 ফাইল)                 │
└──────────────────────────────────────────────────────────┘

┌─ 🚧 চলমান কাজ ────────────────────────────────────────────┐
│   ◌  REST API ডকুমেন্টেশন (Swagger/OpenAPI)              │
│   ◌  রিয়েল-টাইম নোটিফিকেশন (WebSocket)                  │
│   ◌  Advanced search & filtering                          │
└──────────────────────────────────────────────────────────┘

┌─ 🔮 ভবিষ্যৎ পরিকল্পনা ───────────────────────────────────┐
│   ⏳  মোবাইল অ্যাপ (Flutter / React Native)              │
│   ⏳  AI-powered analytics ড্যাশবোর্ড                    │
│   ⏳  মাল্টি-টেন্যান্ট সাপোর্ট                              │
│   ⏳  GraphQL API লেয়ার                                  │
│   ⏳  Docker / Kubernetes deployment                      │
└──────────────────────────────────────────────────────────┘
```

---

## 📊 প্রজেক্ট পরিসংখ্যান

<div align="center">

### 🔢 কোডবেজ মেট্রিক্স

| 📌 পরিমাপ | 📈 মান |
|:---|:---:|
| 📁 মোট PHP ফাইল অপ্টিমাইজড | **108** |
| 🧰 হেল্পার ক্লাস | **5** |
| 📊 Eloquent মডেল | **57+** |
| 🎮 কন্ট্রোলার | **25+** |
| 📜 ফর্ম রিকোয়েস্ট | **16** |
| 🐛 ক্রিটিক্যাল বাগ ফিক্স | **12+** |
| 🧹 ডেড কোড সরানো হয়েছে | **600+ লাইন** |
| ⚡ পারফরম্যান্স উন্নয়ন | **~40%** |

### 🏆 বৃহত্তম অপ্টিমাইজেশন

| 📄 ফাইল | 📉 আগে | 📈 পরে | 🎯 হ্রাস |
|:---|:---:|:---:|:---:|
| `ProtocolController.php` | 892 | 545 | 🟢 **-39%** |
| `SampleReportController.php` | 564 | 355 | 🟢 **-37%** |
| `Functions.php` | 416 | 282 | 🟢 **-32%** |

> 📘 বিস্তারিত জানতে [OPTIMIZATION.md](OPTIMIZATION.md) দেখুন।

</div>

---

## ❓ প্রায়শই জিজ্ঞাসিত প্রশ্ন

<details>
<summary><b>🤔 কোন ডাটাবেজ ব্যবহার করা সবচেয়ে ভালো?</b></summary>

প্রোডাকশনের জন্য **MySQL** সবচেয়ে stable ও widely-supported। লোকাল ডেভেলপমেন্টের জন্য **SQLite** zero-config এবং দ্রুত। যদি আপনার আগে থেকে SQL Server data থাকে, তাহলে **MSSQL** ব্যবহার করুন। তিনটাই সমান কাজ করে।

</details>

<details>
<summary><b>🔧 PHP extension load না হলে কী করব?</b></summary>

`php.ini` ফাইলে গিয়ে relevant extension uncomment করুন:
- MySQL: `extension=pdo_mysql`
- MSSQL: `extension=pdo_sqlsrv` + `extension=sqlsrv`
- SQLite: `extension=pdo_sqlite`

পরে web server (Apache/Nginx) restart করুন।

</details>

<details>
<summary><b>🔄 ডাটাবেজ পরিবর্তন করব কীভাবে?</b></summary>

```bash
# 1. .env-এ DB_CONNECTION পরিবর্তন করুন
# 2. ক্যাশ clear করুন
php artisan config:clear
php artisan cache:clear
# 3. আবার migrate করুন
php artisan migrate
```

</details>

<details>
<summary><b>🐛 "Specified key was too long" এরর আসছে?</b></summary>

পুরাতন MySQL version-এর সমস্যা। `app/Providers/AppServiceProvider.php`-এ যোগ করুন:

```php
use Illuminate\Support\Facades\Schema;
public function boot() {
    Schema::defaultStringLength(191);
}
```

</details>

<details>
<summary><b>🚀 প্রোডাকশনে deploy করব কীভাবে?</b></summary>

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

`APP_ENV=production` ও `APP_DEBUG=false` রাখতে ভুলবেন না।

</details>

<details>
<summary><b>👨‍💻 অবদান কীভাবে রাখব?</b></summary>

বিস্তারিত গাইড [CONTRIBUTING.md](CONTRIBUTING.md)-এ পাবেন।

</details>

---

## 📚 অতিরিক্ত ডকুমেন্টেশন

<div align="center">

| 📖 ডকুমেন্ট | 🔍 বর্ণনা |
|:---:|:---|
| 📘 **[SETUP.md](SETUP.md)** | মাল্টি-ডিবি সেটআপ গাইড (MySQL/MSSQL/SQLite) |
| 📗 **[OPTIMIZATION.md](OPTIMIZATION.md)** | পারফরম্যান্স অপটিমাইজেশন ও সিকিউরিটি ফিক্স |
| 📙 **[CONTRIBUTING.md](CONTRIBUTING.md)** | কোড অবদান রাখার পূর্ণাঙ্গ গাইডলাইন |
| 📕 **[CHANGELOG.md](CHANGELOG.md)** | ভার্সন হিস্টোরি ও পরিবর্তনের লগ |
| 📜 **[LICENSE](LICENSE)** | MIT লাইসেন্স টেক্সট |

</div>

---

## 🤝 অবদান রাখুন

প্রজেক্টে অবদান রাখতে চান? দারুণ! 🎉

```
1️⃣  🍴  Fork করুন এই রিপোজিটরি
2️⃣  🌿  নতুন branch তৈরি করুন   →  git checkout -b feature/awesome
3️⃣  ✅  পরিবর্তন commit করুন    →  git commit -m 'Add awesome feature'
4️⃣  📤  Push করুন branch-এ    →  git push origin feature/awesome
5️⃣  🔃  Pull Request খুলুন
```

---

## 📄 লাইসেন্স

এই প্রজেক্টটি **MIT লাইসেন্সের** আওতায় উন্মুক্ত। বিস্তারিত জানতে [MIT License](https://opensource.org/licenses/MIT) দেখুন।

---

<div align="center">

```
╔══════════════════════════════════════════════════╗
║                                                  ║
║   ❤️  ভালোবাসা দিয়ে তৈরি — ACI Healthcare-এর জন্য   ❤️   ║
║                                                  ║
║         🌟 Made with ❤️ in Bangladesh 🇧🇩 🌟         ║
║                                                  ║
╚══════════════════════════════════════════════════╝
```

<br>

**⬆ [উপরে ফিরে যান](#-এসিআই-হেলথকেয়ার-ম্যানেজমেন্ট-সিস্টেম-)**

</div>
