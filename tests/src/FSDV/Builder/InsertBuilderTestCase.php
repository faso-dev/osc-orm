<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace Tests\src\FSDV\Builder;


use FSDV\DB\DB;
use FSDV\Query\InsertQueryExecutor;
use PHPUnit\Framework\TestCase;

class InsertBuilderTestCase extends TestCase
{
    /**
     * @var InsertQueryExecutor
     */
    protected $qi;

    public function setUp(): void
    {
        $this->qi = DB::insertInto('user')
            ->culums('name','lastname','mail','role', 'username')
            ->values('test','test-insert','test@test.bf','ROLE_SUPER_ADMIN','test')
            ->getQuery();
    }

    public function testIfTheDeleteBuilderReturnAGoodQuery()
    {
        $expected = 'INSERT INTO user(name,lastname,mail,role,username) VALUES(:name,:lastname,:mail,:role,:username)';
        $this->assertEqualsIgnoringCase($expected, trim($this->qi->getSQLQuery()));
    }

    public function testIfTheDeleteBuilderSetTheParamsCorrectlyQuery()
    {
        $this->assertCount(5, $this->qi->getQueryParams());
    }
}
