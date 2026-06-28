<?php

namespace App\Tests;

class TestCase
{
    protected $passed = 0;
    protected $failed = 0;
    protected $tests = [];
    
    public function assertEquals($expected, $actual, $message = '')
    {
        if ($expected === $actual) {
            $this->passed++;
            $this->tests[] = "✓ PASS: " . ($message ?: "Expected {$expected} equals {$actual}");
        } else {
            $this->failed++;
            $this->tests[] = "✗ FAIL: " . ($message ?: "Expected {$expected} but got {$actual}");
        }
    }
    
    public function assertTrue($condition, $message = '')
    {
        if ($condition === true) {
            $this->passed++;
            $this->tests[] = "✓ PASS: " . ($message ?: "Condition is true");
        } else {
            $this->failed++;
            $this->tests[] = "✗ FAIL: " . ($message ?: "Condition is not true");
        }
    }
    
    public function assertFalse($condition, $message = '')
    {
        if ($condition === false) {
            $this->passed++;
            $this->tests[] = "✓ PASS: " . ($message ?: "Condition is false");
        } else {
            $this->failed++;
            $this->tests[] = "✗ FAIL: " . ($message ?: "Condition is not false");
        }
    }
    
    public function assertNotNull($value, $message = '')
    {
        if ($value !== null) {
            $this->passed++;
            $this->tests[] = "✓ PASS: " . ($message ?: "Value is not null");
        } else {
            $this->failed++;
            $this->tests[] = "✗ FAIL: " . ($message ?: "Value is null");
        }
    }
    
    public function assertIsArray($value, $message = '')
    {
        if (is_array($value)) {
            $this->passed++;
            $this->tests[] = "✓ PASS: " . ($message ?: "Value is array");
        } else {
            $this->failed++;
            $this->tests[] = "✗ FAIL: " . ($message ?: "Value is not array");
        }
    }
    
    public function getResults()
    {
        return [
            'passed' => $this->passed,
            'failed' => $this->failed,
            'total' => $this->passed + $this->failed,
            'tests' => $this->tests
        ];
    }
}
