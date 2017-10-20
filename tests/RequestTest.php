<?php

namespace Rnr\JsonSchemaRequest\Tests;

use Illuminate\Validation\ValidationException;
use Rnr\JsonSchemaRequest\Tests\Mocks\RequestMock;

class RequestTest extends TestCase
{
    /**
     * @expectedException \Illuminate\Validation\ValidationException
     */
    public function testFailed() {
        try {
            $this->createRequest((object)[
                'id' => 1
            ]);
        } catch (ValidationException $e) {
            $this->assertEquals([
                '/' => [
                    'The object must contain the properties ["name"].'
                ]
            ], $e->validator->getMessageBag()->messages());

            throw $e;
        }
    }

    public function testSuccess() {
        /** @var RequestMock $request */
        $this->createRequest((object)[
            'id' => 1,
            'name' => 'test'
        ]);

        $this->assertEquals('test', 'test');
    }


    protected function createRequest($data): RequestMock {
        $this->app->resolving(RequestMock::class, function (RequestMock $request) use ($data) {
            $request->setSchema([
                'type' => 'object',
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'name' => ['type' => 'string']
                ],
                'required' => ['id', 'name']
            ])
            ->setData($data);
        });

        /** @var RequestMock $request */
        return $this->app->make(RequestMock::class);
    }


}