<?php

namespace Rnr\JsonSchemaRequest;

use Illuminate\Foundation\Http\FormRequest;
use Rnr\Resolvers\Interfaces\ContainerAwareInterface;
use Rnr\Resolvers\Traits\ContainerAwareTrait;

abstract class Request extends FormRequest implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @return JsonSchemaValidator
     */
    protected function getValidatorInstance()
    {
        /** @var JsonSchemaValidator $validator */
        $validator = $this->container->make(JsonSchemaValidator::class);

        /** @var DataPreparator $preparator */
        $preparator = $this->container->make(DataPreparator::class);

        $validator
            ->setSchema($this->getJsonSchema())
            ->setData(
                $preparator->prepare($this->validationData())
            );

        return $validator;
    }

    abstract protected function getJsonSchema();

}