<?php

use Homeful\Common\Tests\Fixtures\Notifications\SendUnspecifiedNotification;
use Homeful\Common\Tests\Fixtures\Notifications\SendDefaultNotification;
use Homeful\Common\Tests\Fixtures\Notifications\SendLimitedNotification;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('notifications.channels', [
        'default' => ['database'],
        'allowed' => ['database', 'slack', 'mail', 'sms'],
        SendDefaultNotification::class => ['mail'],
        SendLimitedNotification::class => ['sms', 'discord'], // discord is not allowed
    ]);
});

/**
 * ✅ Test that notifications without specific channels use default channels.
 */
test('Notifications without specific channels use default', function () {
    $notification = new SendDefaultNotification();

    $channels = $notification->getNotificationChannelsVia(new stdClass());

    expect($channels)->toBe(['database', 'mail']); // Default + specified in config
});

/**
 * ✅ Test that notifications with limited channels only use allowed ones.
 */
test('Notifications only use allowed channels', function () {
    $notification = new SendLimitedNotification();

    $channels = $notification->getNotificationChannelsVia(new stdClass());

    expect($channels)->toBe(['database', 'sms']); // 'discord' is not in allowed, so ignored
});

/**
 * ✅ Test that notifications without any specific channels fall back to defaults.
 */
test('Notifications without defined channels fallback to default', function () {
    $notification = new SendUnspecifiedNotification();

    $channels = $notification->getNotificationChannelsVia(new stdClass());

    expect($channels)->toBe(['database']); // Only default is applied
});

/**
 * ✅ Test that an empty allowed list results in an empty output.
 */
test('Empty allowed channels result in no output', function () {
    Config::set('notifications.channels.allowed', []);

    $notification = new SendDefaultNotification();

    $channels = $notification->getNotificationChannelsVia(new stdClass());

    expect($channels)->toBe([]); // No allowed channels, so nothing should be returned
});
