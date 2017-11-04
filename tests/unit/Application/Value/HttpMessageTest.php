<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\Value\HttpMessage;
use PHPUnit\Framework\TestCase;

/**
 * Class HttpMessageTest
 * @package Tests\Darrigo\MovieCatalog\Application
 */
final class HttpMessageTest extends TestCase
{
    /**
     * @param int $statusCode
     * @param string $message
     * @dataProvider provideStatusCodeAndMessage
     */
    public function testItIsASimpleValueObjectWithAStatusCodeAndAMessage(int $statusCode, string $message): void
    {
        $httpMessage = new HttpMessage($statusCode, $message);

        $this->assertEquals($statusCode, $httpMessage->getStatusCode());
        $this->assertEquals($message, $httpMessage->getMessage());
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @dataProvider provideStatusCodeAndMessage
     */
    public function testItCanBeRepresentedByAnArray(int $statusCode, string $message): void
    {
        $httpMessage = new HttpMessage($statusCode, $message);

        $this->assertEquals([
            'status_code' => $statusCode,
            'message' => $message
        ], $httpMessage->toArray());
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @dataProvider provideStatusCodeAndMessage
     */
    public function testItCanBePrintedAsAJsonEncodedString(int $statusCode, string $message): void
    {
        $httpMessage = new HttpMessage($statusCode, $message);
        $this->assertEquals(json_encode($httpMessage->toArray()), $httpMessage->__toString());
    }

    /**
     * @return array
     */
    public function provideStatusCodeAndMessage(): array
    {
        return [
            [400, 'Bad Request'],
            [301, 'Moved Outside Galaxy']
        ];
    }
}
