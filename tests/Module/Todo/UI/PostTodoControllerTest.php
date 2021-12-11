<?php

declare(strict_types = 1);

namespace App\Tests\Module\Todo\UI;

use App\Tests\Module\Todo\Domain\DueTimeStub;
use App\Tests\Module\Todo\Domain\IdStub;
use App\Tests\Module\Todo\Domain\TitleStub;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PostTodoControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function itShouldSucceed(): void
    {
        $id      = IdStub::random();
        $title   = TitleStub::random();
        $dueTime = DueTimeStub::future();
        $client  = self::createClient();

        $client->request(
            Request::METHOD_POST,
            '/todos',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
  "data": {
    "type": "todo",
    "id": "' . $id->value() . '",
    "attributes": {
      "title": "' . $title->value() . '",
      "due_time": ' . $dueTime->value() . '
    }
  }
}',
        );

        $response = $client->getResponse();
        self::assertEquals(null, $response->getContent());
        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider wrongRequestCases
     */
    public function itShouldFail(string $requestContent, string $expectedResponse): void
    {
        $client = self::createClient();

        $client->request(
            Request::METHOD_POST,
            '/todos',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $requestContent,
        );

        $response = $client->getResponse();
        self::assertJsonStringEqualsJsonString($expectedResponse, $response->getContent());
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function wrongRequestCases(): array
    {
        $id      = IdStub::random();
        $title   = TitleStub::random();
        $dueTime = DueTimeStub::future();

        return [
            'empty' => [
                'requestContent'   => '{}',
                'expectedResponse' => <<<'EOF'
{
    "errors": [
        {
            "title":"The property data is required",
            "status":400,
            "meta":{"property":"data","pointer":"\/data","message":"The property data is required","constraint":"required","context":1}
        }
    ]
}
EOF,
            ],
            'without type' => [
                'requestContent'   => '{
  "data": {
    "id": "' . $id->value() . '",
    "attributes": {
      "title": "' . $title->value() . '",
      "due_time": ' . $dueTime->value() . '
    }
  }
}',
                'expectedResponse' => <<<'EOF'
{
    "errors": [
        {
            "title": "The property type is required",
            "status":400,
            "meta":{
                "constraint": "required",
                "context": 1,
                "message": "The property type is required",
                "pointer": "/data/type",
                "property": "data.type"
            }
        }
    ]
}
EOF,
            ],
            'without id' => [
                'requestContent'   => '{
  "data": {
    "type": "todo",
    "attributes": {
      "title": "' . $title->value() . '",
      "due_time": ' . $dueTime->value() . '
    }
  }
}',
                'expectedResponse' => <<<'EOF'
{
    "errors": [
        {
            "title":"The property id is required",
            "status":400,
            "meta":{
                "constraint": "required",
                "context": 1,
                "message": "The property id is required",
                "pointer": "/data/id",
                "property": "data.id"
            }
        }
    ]
}
EOF,
            ],
            'without attributes' => [
                'requestContent'   => '{
  "data": {
    "id": "' . $id->value() . '",
    "type": "todo"
  }
}',
                'expectedResponse' => <<<'EOF'
{
    "errors": [
        {
            "title":"The property attributes is required",
            "status":400,
            "meta":{
                "constraint": "required",
                "context": 1,
                "message": "The property attributes is required",
                "pointer": "/data/attributes",
                "property": "data.attributes"
            }
        }
    ]
}
EOF,
            ],
            'without title' => [
                'requestContent'   => '{
  "data": {
    "id": "' . $id->value() . '",
    "type": "todo",
    "attributes": {
      "due_time": ' . $dueTime->value() . '
    }
  }
}',
                'expectedResponse' => <<<'EOF'
{
    "errors": [
        {
            "title":"The property title is required",
            "status":400,
            "meta":{
                "constraint": "required",
                "context": 1,
                "message": "The property title is required",
                "pointer": "/data/attributes/title",
                "property": "data.attributes.title"
            }
        }
    ]
}
EOF,
            ],
            'without due time' => [
                'requestContent'   => '{
  "data": {
    "id": "' . $id->value() . '",
    "type": "todo",
    "attributes": {
      "title": "' . $title->value() . '"
    }
  }
}',
                'expectedResponse' => <<<'EOF'
{
    "errors": [
        {
            "title":"The property due_time is required",
            "status":400,
            "meta":{
                "constraint": "required",
                "context": 1,
                "message": "The property due_time is required",
                "pointer": "/data/attributes/due_time",
                "property": "data.attributes.due_time"
            }
        }
    ]
}
EOF,
            ],
            'wrong type' => [
                'requestContent'   => '{
  "data": {
    "id": "' . $id->value() . '",
    "type": "wrong_type",
    "attributes": {
      "title": "' . $title->value() . '",
      "due_time": ' . $dueTime->value() . '
    }
  }
}',
                'expectedResponse' => <<<'EOF'
{
    "errors": [
        {
            "title":"Does not have a value in the enumeration [\"todo\"]",
            "status":400,
            "meta":{
                "constraint": "enum",
                "context": 1,
                "enum": ["todo"],
                "message": "Does not have a value in the enumeration [\"todo\"]",
                "pointer": "/data/type",
                "property": "data.type"
            }
        }
    ]
}
EOF,
            ],
        ];
    }
}
