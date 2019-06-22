<?php

namespace SlimAurynTest\Response;

use SlimAuryn\Response\FileResponse;
use SlimAurynTest\BaseTestCase;
use SlimAuryn\Response\ResponseException;

class FileResponseTest extends BaseTestCase
{
    public function testWorksCorrectlyWithDefaults()
    {
        $filenameToServe = __DIR__ . '/fixtures/test.txt';

        $expectedContents = @file_get_contents($filenameToServe);
        if ($expectedContents === false) {
            throw new \Exception('Failed to get contents of ' . $filenameToServe);
        }

        $response = new FileResponse(
            $filenameToServe,
            'John.txt'
        );

        self::assertEquals($expectedContents, $response->getBody());
        self::assertEquals(200, $response->getStatus());

        $expectedHeaders = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="John.txt"'
        ];

        $this->assertSame($expectedHeaders, $response->getHeaders());
        $this->assertSame($expectedContents, $response->getBody());
    }

    public function testInaccessibleFileThrows()
    {
        $filenameToServe = __DIR__ . '/fixtures/does_not_exist.txt';

        $this->expectException(ResponseException::class);
        $this->expectExceptionMessage(
            "Failed to open file [$filenameToServe] for serving."
        );
        new FileResponse(
            $filenameToServe,
            'John.txt'
        );
    }

    public function providesFilenamesAndMimeTypes()
    {
        return [
            ['test.jpg', 'image/jpg'],
            ['test.jpeg', 'image/jpg'],
//            'pdf' => 'application/pdf',
            ['test.png', 'image/png'],
            ['test.txt', 'text/plain'],
        ];
    }

    /**
     * @dataProvider providesFilenamesAndMimeTypes
     */
    public function testFilenamesAndMimeTypes($filename, $expectedContentType)
    {
        $filenameToServe = __DIR__ . '/fixtures/' . $filename;

        $response = new FileResponse(
            $filenameToServe,
            'John.txt'
        );
        $headers = $response->getHeaders();

        $this->assertArrayHasKey('Content-Type', $headers);
        $setContentType = $headers['Content-Type'];
        $this->assertSame($expectedContentType, $setContentType);
    }

    public function testUnknownExtensionThrowsException()
    {
        $this->expectException(ResponseException::class);
        new FileResponse(
            $filenameToServe = 'test.txt.unknown',
            'John.txt'
        );
    }
}
