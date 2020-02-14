<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace Tests\src\FSDV\Builder;


use FSDV\DB\DB;
use FSDV\Query\UpdateQueryExecutor;
use PHPUnit\Framework\TestCase;

class UpdateBuilderTestCase extends TestCase
{
    /**
     * @var UpdateQueryExecutor
     */
    protected $qu;

    public function setUp(): void
    {
        $this->qu = DB::update('user as u')
            ->setCulums('mail')
            ->values('test@mail.ch')
            ->where('u.id = :id AND u.username = :username')
            ->setParameters([
                'id' => 1,
                'username' => 'faso-dev'
            ])
            ->getQuery();
    }

    public function testIfTheDeleteBuilderReturnAGoodQuery()
    {
        $expected = 'UPDATE user as u SET mail = :mail WHERE u.id = :id AND u.username = :username';
        $this->assertEqualsIgnoringCase($expected, trim($this->qu->getSQLQuery()));
    }

    public function testIfTheDeleteBuilderSetTheParamsCorrectlyQuery()
    {
        $this->assertCount(3, $this->qu->getQueryParams());
    }
}
