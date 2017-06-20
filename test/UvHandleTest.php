<?php

namespace Amp\File\Test;

use Amp\Loop;

class UvHandleTest extends AsyncHandleTest {
    protected function execute(callable $cb) {
        if (\extension_loaded("uv")) {
            $loop = new Loop\UvDriver;
            Loop::set($loop);
            Loop::run(function () use ($cb, $loop) {
                \Amp\File\filesystem(new \Amp\File\UvDriver($loop));
                \Amp\Promise\rethrow(new \Amp\Coroutine($cb()));
            });
        } else {
            $this->markTestSkipped(
                "php-uv extension not loaded"
            );
        }
    }
}
