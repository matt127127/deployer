<?php

namespace REBELinBLUE\Deployer\Tests\Unit\Notifications\Configurable;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Mockery as m;
use REBELinBLUE\Deployer\Heartbeat;
use REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatRecovered;
use REBELinBLUE\Deployer\Notifications\Notification;

/**
 * @coversDefaultClass \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatRecovered
 */
class HeartbeatRecoveredTest extends HeartbeatChangedTestCase
{
    /**
     * @covers ::__construct
     */
    public function testExtendsNotification()
    {
        $heartbeat = m::mock(Heartbeat::class);

        $notification = new HeartbeatRecovered($heartbeat);

        $this->assertInstanceOf(Notification::class, $notification);
    }

    /**
     * @covers ::toTwilio
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildTwilioMessage
     */
    public function testToTwilio()
    {
        $expectedDateString = 'no-date';

        Lang::shouldReceive('get')->once()->with('app.never')->andReturn($expectedDateString);

        $this->toTwilio(HeartbeatRecovered::class, 'heartbeats.recovered_sms_message', null, $expectedDateString);
    }

    /**
     * @covers ::toTwilio
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildTwilioMessage
     */
    public function testToTwilioWithLastSeenDate()
    {
        $date = Carbon::create(2015, 1, 1, 12, 00, 00, 'Europe/London');
        Carbon::setTestNow(Carbon::create(2015, 1, 1, 12, 15, 00, 'Europe/London'));

        $this->toTwilio(HeartbeatRecovered::class, 'heartbeats.recovered_sms_message', $date, '15 minutes ago');
    }

    /**
     * @covers ::toWebhook
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildWebhookMessage
     */
    public function testToWebhook()
    {
        $this->toWebhook(HeartbeatRecovered::class, 'healthy', 'heartbeat_recovered', 0);
    }

    /**
     * @covers ::toMail
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildMailMessage
     */
    public function testToMail()
    {
        $expectedDateString = 'no-date';

        Lang::shouldReceive('get')->once()->with('app.never')->andReturn($expectedDateString);

        $this->toMail(
            HeartbeatRecovered::class,
            'heartbeats.recovered_subject',
            'heartbeats.recovered_message',
            'success',
            null,
            $expectedDateString
        );
    }

    /**
     * @covers ::toMail
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildMailMessage
     */
    public function testToMailWithLastSeenDate()
    {
        $date = Carbon::create(2015, 1, 1, 12, 00, 00, 'Europe/London');
        Carbon::setTestNow(Carbon::create(2015, 1, 1, 12, 15, 00, 'Europe/London'));

        $this->toMail(
            HeartbeatRecovered::class,
            'heartbeats.recovered_subject',
            'heartbeats.recovered_message',
            'success',
            $date,
            '15 minutes ago'
        );
    }

    /**
     * @covers ::toSlack
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildSlackMessage
     */
    public function testToSlack()
    {
        $expectedDateString = 'no-date';

        Lang::shouldReceive('get')->once()->with('app.never')->andReturn($expectedDateString);

        $this->toSlack(
            HeartbeatRecovered::class,
            'heartbeats.recovered_message',
            'success',
            null,
            $expectedDateString
        );
    }

    /**
     * @covers ::toSlack
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildSlackMessage
     */
    public function testToSlackWithLastSeenDate()
    {
        $date = Carbon::create(2015, 1, 1, 12, 00, 00, 'Europe/London');
        Carbon::setTestNow(Carbon::create(2015, 1, 1, 12, 15, 00, 'Europe/London'));

        $this->toSlack(
            HeartbeatRecovered::class,
            'heartbeats.recovered_message',
            'success',
            $date,
            '15 minutes ago'
        );
    }

    /**
     * @covers ::toHipchat
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildHipchatMessage
     */
    public function testToHipchat()
    {
        $expectedDateString = 'no-date';

        Lang::shouldReceive('get')->once()->with('app.never')->andReturn($expectedDateString);

        $this->toHipchat(
            HeartbeatRecovered::class,
            'heartbeats.recovered_message',
            'success',
            null,
            $expectedDateString
        );
    }

    /**
     * @covers ::toHipchat
     * @covers \REBELinBLUE\Deployer\Notifications\Configurable\HeartbeatChanged::buildHipchatMessage
     */
    public function testToHipchatWithLastSeenDate()
    {
        $date = Carbon::create(2015, 1, 1, 12, 00, 00, 'Europe/London');
        Carbon::setTestNow(Carbon::create(2015, 1, 1, 12, 15, 00, 'Europe/London'));

        $this->toHipchat(
            HeartbeatRecovered::class,
            'heartbeats.recovered_message',
            'success',
            $date,
            '15 minutes ago'
        );
    }
}
