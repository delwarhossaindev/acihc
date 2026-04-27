<div align="center">

# 🤝 অবদান গাইডলাইন

### Contributing to ACI Healthcare

```
╔══════════════════════════════════════════════╗
║   🌟  আপনার অবদানে এই প্রজেক্ট আরও সমৃদ্ধ হবে  🌟   ║
╚══════════════════════════════════════════════╝
```

</div>

---

## 📖 সূচিপত্র

- [💝 শুরুর কথা](#-শুরুর-কথা)
- [🌿 আচরণবিধি](#-আচরণবিধি)
- [🔄 কন্ট্রিবিউশন প্রক্রিয়া](#-কন্ট্রিবিউশন-প্রক্রিয়া)
- [🐛 বাগ রিপোর্ট](#-বাগ-রিপোর্ট)
- [✨ ফিচার রিকোয়েস্ট](#-ফিচার-রিকোয়েস্ট)
- [💻 কোড স্ট্যান্ডার্ড](#-কোড-স্ট্যান্ডার্ড)
- [📝 কমিট মেসেজ](#-কমিট-মেসেজ-গাইডলাইন)
- [✅ Pull Request চেকলিস্ট](#-pull-request-চেকলিস্ট)
- [🧪 টেস্টিং](#-টেস্টিং)

---

## 💝 শুরুর কথা

আপনি ACI Healthcare প্রজেক্টে অবদান রাখতে এসেছেন — অসংখ্য ধন্যবাদ! 🎉

আমাদের লক্ষ্য একটি **পরিচ্ছন্ন, নিরাপদ ও কার্যকর** কোডবেজ বজায় রাখা। আপনার প্রতিটি অবদান — সেটা bug fix হোক, নতুন feature হোক, বা শুধু documentation update — আমাদের কাছে মূল্যবান।

---

## 🌿 আচরণবিধি

> 🤲 সবাই সবার সাথে **সম্মান ও সহানুভূতি** নিয়ে আচরণ করব।

| ✅ যা করবেন | ❌ যা করবেন না |
|:---|:---|
| 🤗 বন্ধুসুলভ ও সহায়ক ভাষা | 🚫 অপমানজনক বা আক্রমণাত্মক মন্তব্য |
| 💡 গঠনমূলক সমালোচনা গ্রহণ | 🚫 ব্যক্তিগত আক্রমণ |
| 🌍 ভিন্ন মতামতকে সম্মান | 🚫 হেনস্থা বা troll |
| 🙏 ভুল স্বীকার করা | 🚫 অন্যের কাজকে ছোট করা |

---

## 🔄 কন্ট্রিবিউশন প্রক্রিয়া

```
┌───────────────────────────────────────────────────┐
│                                                   │
│   1️⃣  🍴  Fork                                    │
│         ↓                                         │
│   2️⃣  📥  Clone your fork                         │
│         ↓                                         │
│   3️⃣  🌿  Create branch                           │
│         ↓                                         │
│   4️⃣  ✏️   Make changes                            │
│         ↓                                         │
│   5️⃣  🧪  Run tests                               │
│         ↓                                         │
│   6️⃣  💾  Commit                                  │
│         ↓                                         │
│   7️⃣  📤  Push                                    │
│         ↓                                         │
│   8️⃣  🔃  Open PR                                 │
│                                                   │
└───────────────────────────────────────────────────┘
```

### 🚀 ধাপে ধাপে গাইড

#### 1️⃣ Repository fork ও clone

```bash
# GitHub-এ "Fork" বাটনে click করুন, তারপর:
git clone https://github.com/YOUR-USERNAME/acihc.git
cd acihc
git remote add upstream https://github.com/ORIGINAL-OWNER/acihc.git
```

#### 2️⃣ নতুন branch তৈরি

```bash
# Feature-এর জন্য:
git checkout -b feature/awesome-feature

# Bug fix-এর জন্য:
git checkout -b fix/critical-bug

# Documentation-এর জন্য:
git checkout -b docs/update-readme
```

#### 3️⃣ পরিবর্তন করুন

- 🎯 ছোট, focused commits করুন
- 📝 প্রতিটি commit একটাই কাজ করুক
- 🧹 অপ্রয়োজনীয় file/code বাদ দিন

#### 4️⃣ Test চালান

```bash
php artisan test
# অথবা
./vendor/bin/phpunit
```

#### 5️⃣ Push ও PR

```bash
git push origin feature/awesome-feature
```

GitHub-এ গিয়ে **Pull Request** খুলুন।

---

## 🐛 বাগ রিপোর্ট

বাগ পেলে [Issue](../../issues) খুলে এই template ফলো করুন:

```markdown
## 🐞 বাগের সংক্ষিপ্ত বিবরণ
[এক/দুই বাক্যে কী সমস্যা]

## 🔁 পুনরাবৃত্তি ধাপ
1. গিয়ে...
2. ক্লিক করি...
3. দেখি...

## ✅ প্রত্যাশিত আচরণ
[কী হওয়া উচিত ছিল]

## ❌ প্রকৃত আচরণ
[কী হচ্ছে]

## 🖼️ স্ক্রিনশট
[যদি থাকে]

## 🌐 পরিবেশ
- OS: [Windows 11 / Ubuntu 22.04 / etc]
- PHP: [8.1.x]
- Laravel: [10.x]
- Browser: [Chrome 120 / etc]
```

---

## ✨ ফিচার রিকোয়েস্ট

নতুন ফিচারের আইডিয়া আছে? দারুণ! 💡

```markdown
## 🎯 ফিচারের নাম
[সংক্ষিপ্ত শিরোনাম]

## 💭 সমস্যা
[কোন সমস্যার সমাধান করবে এই ফিচার?]

## 💡 প্রস্তাবিত সমাধান
[আপনার আইডিয়া বিস্তারিত লিখুন]

## 🔄 বিকল্প সমাধান
[অন্য কোন উপায় ভেবেছেন?]

## 📌 অতিরিক্ত তথ্য
[স্ক্রিনশট, mockup, ইত্যাদি]
```

---

## 💻 কোড স্ট্যান্ডার্ড

### 🎨 PHP কোড স্টাইল

আমরা **PSR-12** ও **Laravel Pint** ফলো করি।

```bash
# Code format check
./vendor/bin/pint --test

# Auto-fix formatting
./vendor/bin/pint
```

### 📌 নামকরণের নিয়ম

| 🎯 ধরন | 📝 কনভেনশন | 🔍 উদাহরণ |
|:---|:---|:---|
| Class | `PascalCase` | `ProtocolController` |
| Method | `camelCase` | `getProductDetails()` |
| Variable | `camelCase` | `$productList` |
| Constant | `UPPER_SNAKE_CASE` | `MAX_RETRY_COUNT` |
| Database table | `snake_case` plural | `protocol_approvals` |
| Database column | `snake_case` | `created_at` |

### ✅ ভালো প্র্যাকটিস

- 🎯 **Single Responsibility** — এক ক্লাস এক কাজ
- 📝 **Type hints** ব্যবহার করুন
- 🛡️ **Validation** Form Request-এ রাখুন
- 🔒 **Mass assignment protection** নিশ্চিত করুন
- 📊 **Eloquent relationships** efficient রাখুন (N+1 এড়ান)
- 🧹 **Dead code** রাখবেন না

### ❌ যা এড়াবেন

- 🚫 Raw SQL queries (যদি না অপরিহার্য হয়)
- 🚫 Hardcoded credentials
- 🚫 অত্যধিক large method (>50 লাইন)
- 🚫 Commented-out code
- 🚫 অপ্রয়োজনীয় comments

---

## 📝 কমিট মেসেজ গাইডলাইন

আমরা **Conventional Commits** ফলো করি:

```
<type>(<scope>): <subject>

<body>

<footer>
```

### 🎯 Type

| 🏷️ Type | 📝 Description |
|:---:|:---|
| `feat` | ✨ নতুন ফিচার |
| `fix` | 🐛 বাগ ফিক্স |
| `docs` | 📚 শুধু ডকুমেন্টেশন |
| `style` | 🎨 Code formatting (no logic change) |
| `refactor` | ♻️ Code restructure (no feature/fix) |
| `perf` | ⚡ Performance improvement |
| `test` | 🧪 Test যোগ/সংশোধন |
| `chore` | 🔧 Build/tool/config changes |

### 📌 উদাহরণ

```bash
# ভালো ✅
git commit -m "feat(protocol): add multi-stage approval workflow"
git commit -m "fix(auth): resolve session timeout issue on login"
git commit -m "docs(readme): add database setup instructions"

# খারাপ ❌
git commit -m "updates"
git commit -m "fixed bug"
git commit -m "WIP"
```

---

## ✅ Pull Request চেকলিস্ট

PR খোলার আগে নিশ্চিত করুন:

- [ ] 🎯 PR title clear ও descriptive
- [ ] 📝 Description-এ পরিবর্তনের কারণ ব্যাখ্যা করেছেন
- [ ] 🧪 সব test pass করছে (`php artisan test`)
- [ ] 🎨 Code formatting OK (`./vendor/bin/pint --test`)
- [ ] 📚 Documentation update করেছেন (যদি প্রযোজ্য)
- [ ] 🔐 Sensitive information (password, key) commit করেননি
- [ ] 📦 Database migration যোগ করেছেন (যদি schema পাল্টায়)
- [ ] 🌱 Seeder update করেছেন (যদি নতুন data type যোগ হয়)
- [ ] ♻️ Backward-compatible (অথবা breaking change উল্লেখ করেছেন)

---

## 🧪 টেস্টিং

### Test setup

```bash
# Test database তৈরি
cp .env .env.testing
# .env.testing-এ DB_DATABASE=acihealthcare_test দিন

php artisan migrate --env=testing
```

### Test লেখার নিয়ম

```php
public function test_user_can_create_protocol(): void
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/protocols', [
            'name' => 'Test Protocol',
            'product_id' => 1,
        ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('protocols', [
        'name' => 'Test Protocol',
    ]);
}
```

### Test চালানো

```bash
# সব test
php artisan test

# নির্দিষ্ট file
php artisan test tests/Feature/ProtocolTest.php

# Coverage সহ
php artisan test --coverage
```

---

<div align="center">

```
╔══════════════════════════════════════════════════╗
║                                                  ║
║   🙏  আপনার অবদানের জন্য আগেই ধন্যবাদ!  🙏          ║
║                                                  ║
║          ✨ Happy Coding! ✨                     ║
║                                                  ║
╚══════════════════════════════════════════════════╝
```

**⬆ [উপরে ফিরে যান](#-অবদান-গাইডলাইন)**

</div>
