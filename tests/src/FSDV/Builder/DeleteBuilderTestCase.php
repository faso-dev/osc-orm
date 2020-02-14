<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace Tests\src\FSDV\Builder;


use FSDV\DB\DB;
use FSDV\Query\DeleteQueryExecutor;
use PHPUnit\Framework\TestCase;

class DeleteBuilderTestCase extends TestCase
{
    /**
     * @var DeleteQueryExecutor
     */
    protected $qd;

    public function setUp(): void
    {
        $this->qd = DB::deleteFrom('user as u')
            ->where('u.id = :id AND u.username = :username')
            ->setParameters([
                'id' => 1,
                'username' => 'faso-dev'
            ])
            ->getQuery();
    }

    public function testIfTheDeleteBuilderReturnAGoodQuery()
    {
        $expected = 'DELETE FROM user as u  WHERE u.id = :id AND u.username = :username';
        $this->assertEqualsIgnoringCase($expected, trim($this->qd->getSQLQuery()));
    }

    public function testIfTheDeleteBuilderSetTheParamsCorrectlyQuery()
    {
        $this->assertCount(2, $this->qd->getQueryParams());
    }
}
