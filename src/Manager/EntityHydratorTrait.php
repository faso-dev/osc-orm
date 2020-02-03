<?php


namespace FSDV\Manager;


trait EntityHydratorTrait
{
    /**
     * @param array|null $datas
     * @return mixed|void
     */
    public function hydrate(array $datas = null)
    {
        if (null === $datas) return;
        foreach ($datas as $key => $value){
            $method = 'set'.ucwords(str_replace('_', '', $key));
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
}
