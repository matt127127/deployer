<?php

namespace REBELinBLUE\Deployer\Tests\Unit\Notifications\System;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Mockery as m;
use REBELinBLUE\Deployer\Notifications\System\ResetPassword;
use REBELinBLUE\Deployer\Tests\TestCase;
use REBELinBLUE\Deployer\User;

/**
 * @coversDefaultClass \REBELinBLUE\Deployer\Notifications\System\ResetPassword
 */
class ResetPasswordTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::via
     */
    public function testSendViaEmail()
    {
        $notification = new ResetPassword('a-new-password');

        $this->assertSame(['mail'], $notification->via());
    }

    /**
     * @covers ::toMail
     */
    public function testToMail()
    {
        $expectedToken = 'a-test-token';
        $expectedName  = 'Bob Smith';
        $subject       = 'expected subject';
        $actionUrl     = 'action button url';
        $actionText    = 'the button text';
        $introLine1    = 'in line 1 of text';
        $introLine2    = 'in line 2 of text';
        $outroLine1    = 'out line 1 of text';

        $user = m::mock(User::class);
        $user->shouldReceive('getAttribute')->atLeast()->once()->with('name')->andReturn($expectedName);

        Lang::shouldReceive('get')->with('emails.reset_subject')->andReturn($subject);
        Lang::shouldReceive('get')->with('emails.reset_header')->andReturn($introLine1);
        Lang::shouldReceive('get')->with('emails.reset_below')->andReturn($introLine2);
        Lang::shouldReceive('get')->with('emails.reset')->andReturn($actionText);
        Lang::shouldReceive('get')->with('emails.reset_footer')->andReturn($outroLine1);

        // Replace the URL generator so that we can get a known URL
        $mock = m::mock(UrlGenerator::class);
        $mock->shouldReceive('route')
             ->with('auth.reset-confirm', ['token' => $expectedToken], true)
             ->andReturn($actionUrl);

        App::instance('url', $mock);

        $notification = new ResetPassword($expectedToken);
        $mail         = $notification->toMail($user);
        $actual       = $mail->toArray();

        $this->assertSame($subject, $actual['subject']);
        $this->assertSame($actionUrl, $actual['actionUrl']);
        $this->assertSame($actionText, $actual['actionText']);

        $this->assertSame(2, count($actual['introLines']));
        $this->assertSame($introLine1, $actual['introLines'][0]);
        $this->assertSame($introLine2, $actual['introLines'][1]);

        $this->assertSame(1, count($actual['outroLines']));
        $this->assertSame($outroLine1, $actual['outroLines'][0]);

        $this->assertArrayHasKey('name', $mail->viewData);
        $this->assertSame($expectedName, $mail->viewData['name']);
    }
}
