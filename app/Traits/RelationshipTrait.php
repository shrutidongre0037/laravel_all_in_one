<?php

namespace App\Traits;

trait RelationshipTrait
{
    /**
     * Boot the trait and register model relationships
     */
    public static function bootRelationshipTrait()
    {
        static::registerModelRelationships();
    }

    /**
     * Register all relationships defined in the configuration
     */
    protected static function registerModelRelationships()
    {
        $modelName = class_basename(static::class);
        $relationships = config("relationship.modules.{$modelName}.relations", []);

        foreach ($relationships as $relationName => $config) {
            static::addDynamicRelationship($relationName, $config);
        }
    }

    /**
     * Add a dynamic relationship to the model
     */
    protected static function addDynamicRelationship(string $name, array $config)
    {
        // Define the relationship as a dynamic method
        static::macro($name, function () use ($config) {
            return $this->buildRelationship($config);
        });
    }

    /**
     * Build the relationship instance
     */
    protected function buildRelationship(array $config)
    {
        $relatedModel = 'App\\Models\\' . $config['model'];

        return match ($config['type']) {
            'hasOne' => $this->hasOne($relatedModel, $config['foreignKey'], $config['localKey']),
            'hasMany' => $this->hasMany($relatedModel, $config['foreignKey'], $config['localKey']),
            'belongsTo' => $this->belongsTo($relatedModel, $config['foreignKey'], $config['ownerKey']),
            'belongsToMany' => $this->belongsToMany(
                $relatedModel,
                $config['table'],
                $config['foreignPivotKey'],
                $config['relatedPivotKey']
            ),
            'hasManyThrough' => $this->hasManyThrough(
                'App\\Models\\' . $config['model'],
                'App\\Models\\' . $config['through'],
                $config['secondKey'],
                $config['localKey'],
                $config['firstKey'],
                $config['secondLocalKey']
            ),
            default => throw new \InvalidArgumentException("Unsupported relationship type: {$config['type']}"),
        };
    }


    /**
     * Handle dynamic method calls for relationships
     */
    public function __call($method, $parameters)
    {
        $modelName = class_basename(static::class);
        $relationships = config("relationship.modules.{$modelName}.relations", []);

        if (array_key_exists($method, $relationships)) {
            return $this->buildRelationship($relationships[$method]);
        }

        return parent::__call($method, $parameters);
    }
}
