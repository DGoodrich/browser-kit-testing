<?php

namespace Laravel\BrowserKitTesting\Tests\Unit;

use Illuminate\Contracts\Console\Kernel;
use Laravel\BrowserKitTesting\Tests\TestCase;
use Laravel\BrowserKitTesting\Concerns\InteractsWithConsole;

class InteractsWithConsoleTest extends TestCase
{
    use InteractsWithConsole;

    /**
     * @test
     */
    public function call_artisan_command_return_code()
    {
        $this->app[Kernel::class] = new class {
            public function call($command, $parameters)
            {
                return 'User was created.';
            }
        };
        $command = 'app:user';
        $parameters = ['name' => 'john'];

        $this->assertEquals(
            'User was created.',
            $this->artisan($command, $parameters)
        );

        $this->assertEquals(
            $this->code,
            $this->app[Kernel::class]->call($command, $parameters)
        );
    }
}
