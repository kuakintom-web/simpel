<?php

namespace App\Tests;

use App\Helpers\Validator;
use App\Helpers\Database;

class ValidationTest extends TestCase
{
    public function testRequiredValidation()
    {
        $validator = new Validator(['name' => '']);
        $validator->validate(['name' => 'required']);
        
        $this->assertTrue($validator->fails(), 'Required validation should fail for empty value');
    }
    
    public function testEmailValidation()
    {
        $validator = new Validator(['email' => 'invalid-email']);
        $validator->validate(['email' => 'email']);
        
        $this->assertTrue($validator->fails(), 'Email validation should fail for invalid email');
    }
    
    public function testNumericValidation()
    {
        $validator = new Validator(['age' => 'not-a-number']);
        $validator->validate(['age' => 'numeric']);
        
        $this->assertTrue($validator->fails(), 'Numeric validation should fail for non-numeric value');
    }
    
    public function testMinLengthValidation()
    {
        $validator = new Validator(['password' => 'abc']);
        $validator->validate(['password' => 'min:8']);
        
        $this->assertTrue($validator->fails(), 'Min length validation should fail');
    }
    
    public function testValidData()
    {
        $validator = new Validator([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'age' => 30
        ]);
        $validator->validate([
            'name' => 'required',
            'email' => 'email',
            'age' => 'numeric'
        ]);
        
        $this->assertTrue($validator->passes(), 'Valid data should pass validation');
    }
}
