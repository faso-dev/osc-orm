<?php


namespace FSDV\Manager;


use FSDV\Builder\Syntax\DeleteWriter;
use FSDV\Builder\Syntax\InsertInToWriter;
use FSDV\Builder\Syntax\UpdateWriter;
use FSDV\Extractor\Extractor;
use PDO;

class Manager implements ManagerInterface
{
    /**
     * @var array Liste des objets à persister
     */
    private $saveInstances = [];
    /**
     * @var array Liste des objets à supprimer
     */
    private $removeInstances = [];

    /**
     * @var array Liste des objets à supprimer
     */
    private $updateInstances = [];
    /**
     * @var PDO
     */
    private $connection;

    /**
     * Manager constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function save(EntityInterface $class)
    {
        $this->saveInstances[] = $class;
    }


    /**
     * @inheritDoc
     */
    public function remove(EntityInterface $class)
    {
        $this->removeInstances[] = $class;
    }

    /**
     * @inheritDoc
     */
    public function update(EntityInterface $class)
    {
        $this->updateInstances[] = $class;
    }
    /**
     * @inheritDoc
     */
    public function commit()
    {
        if ($this->saveInstances){
            $this->commitSave();
        }
        if ($this->updateInstances){
            $this->commitUpdate();
        }
        if ($this->removeInstances){
            $this->commitRemove();
        }

    }

    /**
     * Commite les requêtes d'insertion
     */
    private function commitSave()
    {
        array_map(function ($instance) {
            (new InsertInToWriter($this->connection))
                ->write(Extractor::extractClassName($instance),
                    Extractor::hidenArrayField(Extractor::extractClassProperties($instance),'id'),
                    Extractor::hidenArrayField(Extractor::extractClassPropertiesValues($instance), 'id'));
        },$this->saveInstances);
    }

    /**
     * Commite les données des entitées à supprimer
     */
    private function commitRemove()
    {
        array_map(function (EntityInterface $instance) {
            (new DeleteWriter($this->connection))
                ->write(Extractor::extractClassName($instance),
                    ['id'], ['id' => $instance->getId()]);
        }, $this->removeInstances);
        $this->removeInstances = [];
    }

    /**
     * Commite les données des entitées à modifier
     */
    private function commitUpdate()
    {
        array_map(function (EntityInterface $entity){
            (new UpdateWriter($this->connection))
                ->write(Extractor::extractClassName($entity),
                    Extractor::hidenArrayField(Extractor::extractClassProperties($entity),'id'),
                    Extractor::hidenArrayField(Extractor::extractClassPropertiesValues($entity), 'id'),
                    $entity->getId());
        }, $this->updateInstances);
        $this->saveInstances = [];
    }

}
