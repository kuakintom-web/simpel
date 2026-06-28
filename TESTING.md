# Testing & Validation Guide

## Unit Tests

SIMPEL-Alkhairaat menyediakan test suite untuk memastikan kualitas kode.

### Menjalankan Tests

```bash
cd /path/to/simpel
php tests/run.php
```

### Test yang Tersedia

#### 1. Validation Tests

```php
use App\Tests\ValidationTest;

$test = new ValidationTest();
$test->testRequiredValidation();
$test->testEmailValidation();
$test->testNumericValidation();
```

#### 2. Filter Tests

```php
use App\Tests\FilterTest;

$test = new FilterTest();
$test->testFilterWhere();
$test->testFilterSearch();
$test->testFilterPagination();
```

## Form Validation

### Contoh Penggunaan Validator

```php
use App\Helpers\Validator;

$data = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'age' => 30
];

$validator = new Validator($data);
$validator->validate([
    'name' => 'required|min:3',
    'email' => 'required|email',
    'age' => 'numeric'
]);

if ($validator->passes()) {
    // Data valid
} else {
    $errors = $validator->errors();
    // Handle validation errors
}
```

## Advanced Filtering

### Filter dengan Berbagai Kondisi

```php
use App\Helpers\Filter;

// Basic where
$filter = new Filter('schools');
$results = $filter->where('status', '=', 'aktif')
                  ->orderBy('name', 'ASC')
                  ->limit(10)
                  ->get();

// Search
$filter = new Filter('schools');
$results = $filter->search('Alkhairaat', ['name', 'address'])
                  ->get();

// Between dates
$filter = new Filter('financial_reports');
$results = $filter->between('report_date', '2024-01-01', '2024-12-31')
                  ->get();

// In condition
$filter = new Filter('schools');
$results = $filter->in('district_id', [1, 2, 3])
                  ->get();

// Pagination
$filter = new Filter('schools');
$page = 1;
$perPage = 25;
$results = $filter->paginate($page, $perPage)->get();
$total = $filter->count();
```

## Logging & Activity Tracking

### Log User Activity

```php
use App\Helpers\Logger;

// Simple log
Logger::log(
    $_SESSION['user_id'],
    'CREATE',
    'schools',
    'Created new school'
);

// Log with details
Logger::log(
    $_SESSION['user_id'],
    'UPDATE',
    'schools',
    'Updated school data',
    ['school_id' => 1, 'field' => 'name']
);

// Get logs
$logs = Logger::getLogs($_SESSION['user_id'], 50);
```

## Database Backup & Restore

### Create Backup

```php
use App\Helpers\Backup;

$result = Backup::create();
if ($result['success']) {
    echo "Backup created: " . $result['filename'];
}
```

### Restore from Backup

```php
use App\Helpers\Backup;

$result = Backup::restore('backup_simpel_2024-01-15_10-30-45.sql');
if ($result['success']) {
    echo "Database restored successfully";
}
```

### List Backups

```php
use App\Helpers\Backup;

$backups = Backup::list();
foreach ($backups as $backup) {
    echo $backup['filename'] . ' - ' . $backup['created'];
}
```

### Delete Backup

```php
use App\Helpers\Backup;

$result = Backup::delete('backup_simpel_2024-01-15_10-30-45.sql');
```

## Best Practices

### 1. Always Validate Input

```php
$validator = new Validator($_POST);
$validator->validate([
    'name' => 'required|min:3|max:100',
    'email' => 'required|email|unique:users,email',
    'phone' => 'required|numeric'
]);

if ($validator->fails()) {
    return $this->sendError($validator->errors());
}
```

### 2. Log Important Actions

```php
try {
    // Do something
    Logger::log($userId, 'ACTION', 'module', 'Description');
} catch (Exception $e) {
    Logger::log($userId, 'ERROR', 'module', $e->getMessage());
}
```

### 3. Use Filters for Complex Queries

```php
$filter = new Filter('schools');
$results = $filter->where('status', '=', 'aktif')
                  ->where('district_id', '=', $districtId)
                  ->search($searchTerm, ['name', 'address'])
                  ->orderBy('created_at', 'DESC')
                  ->paginate($page, 25)
                  ->get();
```

### 4. Regular Backup Schedule

```php
// Backup setiap hari
Backup::create();
```

## Performance Tips

1. **Use pagination** untuk large datasets
2. **Index frequently searched columns**
3. **Use filter conditions** instead of loading all data
4. **Archive old logs** secara berkala
5. **Test with realistic data** sebelum production
