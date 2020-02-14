<?php

namespace Tests\src\FSDV\DB;

use FSDV\Builder\QueryDeleteBuilder;
use FSDV\Builder\QueryInsertBuilder;
use FSDV\Builder\QueryUpdateBuilder;
use FSDV\Builder\SelectBuilder;
use FSDV\DB\DB;
use PHPUnit\Framework\TestCase;

class DBTestCase extends TestCase
{

    public function testIfTheReturnDeleteBuilder()
    {
        $this->assertInstanceOf(QueryDeleteBuilder::class, DB::delete());
    }

    public function testIfTheReturnSelectBuilder()
    {
        $this->assertInstanceOf(SelectBuilder::class, DB::select());
    }

    public function testIfTheReturnInsertBuilder()
    {
        $this->assertInstanceOf(QueryInsertBuilder::class, DB::insert());
    }

    public function testIfTheReturnUpdateBuilder()
    {
        $this->assertInstanceOf(QueryUpdateBuilder::class, DB::update());
    }
}
