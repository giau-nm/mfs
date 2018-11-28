<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\CustomQueryBuilder;
use App\Models\LogTable;

abstract class AbstractModel extends Model
{
    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 10000;
    protected $revisionCreationsEnabled = true;
    protected $listDeleteRelationsAfterRemove = [];
    protected $listDetachRelationsAfterRemove = [];

    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();

        $grammar = $conn->getQueryGrammar();

        return new CustomQueryBuilder($conn, $grammar, $conn->getPostProcessor());
    }

    public function linkedDelete()
    {
        // Retrieve all needed data before delete current model
        $listDeleteRelations = $this->getRelationList($this->listDeleteRelationsAfterRemove);
        $listDetachRelations = $this->getRelationList($this->listDetachRelationsAfterRemove);

        // Delete current model
        $this->delete();

        // Delete continuously in delete list
        $this->deleteRelationAndData($listDeleteRelations);

        // set foreign key to null for all child model in detach list
        $this->deleteRelationOnly($listDetachRelations);
    }

    private function getRelationList($relationNameList)
    {
        $listRelation = [];
        foreach ($relationNameList as $relationName) {
            $listRelation[$relationName]['relation'] = $this->$relationName();
            if ($this->$relationName() instanceof BelongsToMany) {
                $listRelation[$relationName]['objects'] = $this->$relationName()->withPivot('id')->get();
            } else {
                $listRelation[$relationName]['objects'] = $this->$relationName()->get();
            }

        }

        return $listRelation;
    }

    private function deleteRelationAndData($listDeleteRelations)
    {
        foreach ($listDeleteRelations as $key => $relation) {
            if ($relation['relation'] instanceof HasMany) {
                $objects = $relation['objects'];
                foreach ($objects as $object) {
                    $object->linkedDelete();
                }
            } elseif ($relation['relation'] instanceof HasOne || $relation['relation'] instanceof BelongsTo) {
                if (!is_null($relation['objects']->first())) {
                    $relation['objects']->first()->linkedDelete();
                }
            }
        }
    }

    private function deleteRelationOnly($listDetachRelations)
    {
        $foreignKey = $this->getForeignKey();
        foreach ($listDetachRelations as $key => $relation) {
            if ($relation['relation'] instanceof HasMany) {
                $objects = $relation['objects'];
                foreach ($objects as $object) {
                    $object->$foreignKey = null;
                    $object->save();
                }
            } elseif ($relation['relation'] instanceof HasOne || $relation['relation'] instanceof BelongsTo) {
                if (!is_null($relation['objects']->first())) {
                    $object = $relation['objects']->first();
                    $object->$foreignKey = null;
                    $object->save();
                }
            } elseif ($relation['relation'] instanceof BelongsToMany) {
                $objects = $relation['objects'];
                foreach ($objects as $object) {
                    LogTable::log(
                        $object->pivot->toArray(),
                        $object->pivot->getTable(),
                        $object->pivot->getConnection()->getName()
                    );
                }
                $result = $relation['relation']->detach();
            }
        }
    }

    public function fetchDataById($datas) {
        $result = array();
        if(!empty($datas))
        foreach($datas as $data){
            $result[$data->id] = $data;
        }
        return $result;
    }

    public function fetchDataByKey($datas, $key) {
        $result = array();
        if(!empty($datas))
        foreach($datas as $data){
            if(!isset($result[$data->$key])){
                $result[$data->$key] = array();
            }
            $result[$data->$key][] = $data;
        }
        return $result;
    }
}
