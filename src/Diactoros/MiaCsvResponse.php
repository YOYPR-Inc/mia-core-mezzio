<?php

namespace Mia\Core\Diactoros;

use Psr\Http\Message\StreamInterface;
use Laminas\Diactoros\Exception;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Stream;

use function get_class;
use function gettype;
use function is_object;
use function is_string;
use function sprintf;

/**
 * Description of CsvResponse
 *
 * @author matiascamiletti
 */
class MiaCsvResponse extends \Laminas\Diactoros\Response\TextResponse
{
    /**
     * Create a plain text response.
     *
     * Produces a text response with a Content-Type of text/plain and a default
     * status of 200.
     *
     * @param string|StreamInterface $text String or stream for the message body.
     * @param int $status Integer status code for the response; 200 by default.
     * @param array $headers Array of headers to use at initialization.
     * @throws Exception\InvalidArgumentException if $text is neither a string or stream.
     */
    public function __construct($data)
    {
        parent::__construct(
            $this->createBody($this->convertData($data)),
            200,
            ['Content-Type' => ['text/csv']]
        );
    }
    
    protected function convertData($data)
    {
        return $this->str_putcsv($data);
    }
    
    /**
     * Create the message body.
     *
     * @param string|StreamInterface $text
     * @throws Exception\InvalidArgumentException if $text is neither a string or stream.
     */
    private function createBody($text) : StreamInterface
    {
        if ($text instanceof StreamInterface) {
            return $text;
        }

        if (! is_string($text)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Invalid content (%s) provided to %s',
                (is_object($text) ? get_class($text) : gettype($text)),
                __CLASS__
            ));
        }

        $body = new Stream('php://temp', 'wb+');
        $body->write($text);
        $body->rewind();
        return $body;
    }
    
    /**
     * Convert a multi-dimensional, associative array to CSV data
     * @param  array $data the array of data
     * @return string       CSV text
     */
    protected function str_putcsv($data) {
        # Generate CSV data from array
        $fh = fopen('php://temp', 'rw'); # don't create a file, attempt
        # to use memory instead
        # write out the headers
        fputcsv($fh, array_keys(current($data)));

        # write out the data
        foreach ($data as $row) {
            fputcsv($fh, $row);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $csv;
    }

}