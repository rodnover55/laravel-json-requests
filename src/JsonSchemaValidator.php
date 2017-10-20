<?php

namespace Rnr\JsonSchemaRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;
use League\JsonGuard\Validator as JsonGuardValidator;

class JsonSchemaValidator implements Validator
{
    private $schema;

    private $data;

    /**
     * The message bag instance.
     *
     * @var MessageBag
     */
    protected $messages;


    public function fails()
    {
        return !$this->passes();
    }

    public function passes() {
        $this->messages = new MessageBag();

        $validator = new JsonGuardValidator($this->data, $this->schema);


        foreach ($validator->errors() as $error) {
            $this->messages->add($error->getDataPath(), $error->getMessage());
        }


        return $validator->passes();
    }

    public function getMessageBag()
    {
        return $this->messages;
    }

    public function failed()
    {
        return $this->messages->messages();
    }

    public function sometimes($attribute, $rules, callable $callback)
    {
        throw \Exception('Not implemented');
    }

    public function after($callback)
    {
        throw \Exception('Cannot be executed');
    }

    public function errors()
    {
        return $this->getMessageBag();
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param mixed $schema
     *
     * @return $this
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;

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
        $this->data = $data;

        return $this;
    }
}