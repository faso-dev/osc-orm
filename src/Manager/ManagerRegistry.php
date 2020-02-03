<?php


namespace FSDV\Manager;


use FSDV\Builder\QueryBuilder;
use FSDV\Extractor\Extractor;
use PDO;
use ReflectionException;

abstract class ManagerRegistry
{
    /**
     * @var PDO
     */
    protected $connection;
    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * ManagerRegistry constructor.
     * @param PDO $connection
     * @param string $entity
     */
    public function __construct(PDO $connection, string $entity) {

        if (!(new \ReflectionClass($entity))->implementsInterface(EntityInterface::class)){
            die(sprintf('L\'entité %s doit implémenter la EntityInterface', $entity));
        }
        $this->connection = $connection;
        $this->entity = $entity;
    }

    public function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->connection);
    }

    /**
     * @inheritDoc
     * @return EntityInterface [] | null
     * @throws ReflectionException
     */
    public function findAll(): ?array
    {
        return $this->createQueryBuilder()
            ->select('*')
            ->from(Extractor::extractClassName($this->entity))
            ->getQuery()
            ->getMappedResultWith($this->entity);
    }

    /**
     * @inheritDoc
     * @return EntityInterface | null
     * @throws ReflectionException
     */
    public function findOneBy(array $criterias): ?EntityInterface
    {
        $builder =  $this->createQueryBuilder()
            ->select('*')
            ->from(Extractor::extractClassName($this->entity));
        $prepareParams = array_keys($criterias);
        foreach ($prepareParams as $key){
            $builder = $builder->Where(Extractor::extractClassName($this->entity)."${key}=:${key}");
        }
        return $builder->setParameters($criterias)
            ->getQuery()->getOneMappedWith($this->entity);

    }

    /**
     * @inheritDoc
     * @param int $id
     * @return EntityInterface | null
     * @throws ReflectionException
     */
    public function findById(int $id): ?EntityInterface
    {
        $entity =  $this->createQueryBuilder()
            ->select('*')
            ->from(Extractor::extractClassName($this->entity))
            ->where(Extractor::extractClassName($this->entity).'.id=:id')
            ->setParameters([':id' => $id])
            ->getQuery()
            ->getOneMappedWith($this->entity);
        if (!null == $entity->getId()){
            return $entity;
        }
        return null;
    }

    /**
     * @inheritDoc
     * @param array $criterias
     * @return EntityInterface [] | null
     * @throws ReflectionException
     */
    public function findBy(array $criterias): ?array
    {
        $builder =  $this->createQueryBuilder()
            ->select('*')
            ->from(Extractor::extractClassName($this->entity));
        foreach (array_keys($criterias) as $key){
            $builder = $builder->Where(Extractor::extractClassName($this->entity).".${key}=:${key}");
        }
        return $builder
            ->setParameters($criterias)
            ->getQuery()
            ->getMappedResultWith($this->entity);
    }
}
