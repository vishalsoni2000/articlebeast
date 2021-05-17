<?php

namespace NF_FU_VENDOR\Aws\Handler\GuzzleV6;

use Exception;
use NF_FU_VENDOR\GuzzleHttp\Exception\ConnectException;
use NF_FU_VENDOR\GuzzleHttp\Exception\RequestException;
use NF_FU_VENDOR\GuzzleHttp\Promise;
use NF_FU_VENDOR\GuzzleHttp\Client;
use NF_FU_VENDOR\GuzzleHttp\ClientInterface;
use NF_FU_VENDOR\GuzzleHttp\TransferStats;
use NF_FU_VENDOR\Psr\Http\Message\RequestInterface as Psr7Request;
/**
 * A request handler that sends PSR-7-compatible requests with Guzzle 6.
 */
class GuzzleHandler
{
    /** @var ClientInterface */
    private $client;
    /**
     * @param ClientInterface $client
     */
    public function __construct(\NF_FU_VENDOR\GuzzleHttp\ClientInterface $client = null)
    {
        $this->client = $client ?: new \NF_FU_VENDOR\GuzzleHttp\Client();
    }
    /**
     * @param Psr7Request $request
     * @param array       $options
     *
     * @return Promise\Promise
     */
    public function __invoke(\NF_FU_VENDOR\Psr\Http\Message\RequestInterface $request, array $options = [])
    {
        $request = $request->withHeader('User-Agent', $request->getHeaderLine('User-Agent') . ' ' . \NF_FU_VENDOR\GuzzleHttp\default_user_agent());
        return $this->client->sendAsync($request, $this->parseOptions($options))->otherwise(static function (\Exception $e) {
            $error = ['exception' => $e, 'connection_error' => $e instanceof \NF_FU_VENDOR\GuzzleHttp\Exception\ConnectException, 'response' => null];
            if ($e instanceof \NF_FU_VENDOR\GuzzleHttp\Exception\RequestException && $e->getResponse()) {
                $error['response'] = $e->getResponse();
            }
            return new \NF_FU_VENDOR\GuzzleHttp\Promise\RejectedPromise($error);
        });
    }
    private function parseOptions(array $options)
    {
        if (isset($options['http_stats_receiver'])) {
            $fn = $options['http_stats_receiver'];
            unset($options['http_stats_receiver']);
            $prev = isset($options['on_stats']) ? $options['on_stats'] : null;
            $options['on_stats'] = static function (\NF_FU_VENDOR\GuzzleHttp\TransferStats $stats) use($fn, $prev) {
                if (\is_callable($prev)) {
                    $prev($stats);
                }
                $transferStats = ['total_time' => $stats->getTransferTime()];
                $transferStats += $stats->getHandlerStats();
                $fn($transferStats);
            };
        }
        return $options;
    }
}
