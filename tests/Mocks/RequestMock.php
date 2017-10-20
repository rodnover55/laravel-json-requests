<?php

namespace Rnr\JsonSchemaRequest\Tests\Mocks;

use Rnr\JsonSchemaRequest\DataPreparator;
use Rnr\JsonSchemaRequest\Request;

class RequestMock extends Request
{
    private $schema;
    private $data;

    public function authorize() {
        return true;
    }

    protected function getJsonSchema()
    {
        return $this->schema;
    }

    public function setSchema($data) {
        $preparator = new DataPreparator();

        $this->schema = $preparator->prepare($data);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $preparator = new DataPreparator();

        $this->data = $preparator->prepare($data);

        return $this;
    }

    protected function validationData()
    {
        return $this->data;
    }
}