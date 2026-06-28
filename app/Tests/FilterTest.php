<?php

namespace App\Tests;

use App\Helpers\Filter;

class FilterTest extends TestCase
{
    public function testFilterWhere()
    {
        $filter = new Filter('schools');
        $filter->where('status', '=', 'aktif');
        
        $this->assertIsArray($filter->get(), 'Filter should return array');
    }
    
    public function testFilterSearch()
    {
        $filter = new Filter('schools');
        $filter->search('Alkhairaat', ['name']);
        
        $results = $filter->get();
        $this->assertIsArray($results, 'Search filter should return array');
    }
    
    public function testFilterOrderBy()
    {
        $filter = new Filter('schools');
        $filter->orderBy('name', 'ASC');
        
        $this->assertIsArray($filter->get(), 'OrderBy filter should return array');
    }
    
    public function testFilterPagination()
    {
        $filter = new Filter('schools');
        $filter->paginate(1, 10);
        
        $results = $filter->get();
        $this->assertIsArray($results, 'Paginated filter should return array');
    }
}
