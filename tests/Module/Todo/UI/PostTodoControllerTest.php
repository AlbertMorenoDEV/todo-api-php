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

        self::assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
