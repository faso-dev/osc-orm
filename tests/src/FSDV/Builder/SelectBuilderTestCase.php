<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace Tests\src\FSDV\Builder;


use FSDV\DB\DB;
use FSDV\Query\SelectQueryExecutor;
use PHPUnit\Framework\TestCase;

class SelectBuilderTestCase extends TestCase
{
    /**
     * @var SelectQueryExecutor
     */
    protected $qs;

    public function setUp(): void
    {
        $this->qs = DB::select()
            ->from('user as u')
            ->where('u.id = :id AND u.username = :username')
            ->setParameters([
                'id' => 1,
                'username' => 'faso-dev'
            ])
            ->getQuery();
    }

    public function testIfTheSelectBuilderReturnAGoodQuery()
    {
        $expected = 'SELECT * FROM user as u WHERE u.id = :id AND u.username = :username';
        $this->assertEqualsIgnoringCase($expected, trim($this->qs->getSQLQuery()));
    }

    public function testIfTheSelectBuilderSetTheParamsCorrectlyQuery()
    {
        $this->assertCount(2, $this->qs->getQueryParams());
    }
}
