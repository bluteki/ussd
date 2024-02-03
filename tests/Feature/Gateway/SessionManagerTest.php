<?php

namespace Bluteki\Ussd\Tests\Future\Gateway;

use Bluteki\Ussd\Gateway\Flares\Request as FlaresRequest;
use Bluteki\Ussd\Gateway\Handler;
use Bluteki\Ussd\Gateway\SessionManager;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Models\SessionManager as Model;
use Bluteki\Ussd\Testing\Mock\TruTeq\Request as TruTeqRequestMock;
use Bluteki\Ussd\Tests\TestCase;

class SessionManagerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_session_manager_create_new_session_manager_record_in_database(): void
    {
        new SessionManager($this->get_handler(
            $sessionID = $this->faker->randomNumber(5),
            $msisdn = $this->faker->e164PhoneNumber(),
            1,
            "*120*180#"
        ));

        $this->assertDatabaseHas('session_managers', [
            'msisdn' => $msisdn,
            'session_id' => $sessionID
        ]);
    }

    public function test_manager(): void
    {
        $session = new SessionManager($this->get_handler(
            $sessionID = $this->faker->randomNumber(5),
            $msisdn = $this->faker->e164PhoneNumber(),
            1,
            "*120*180#"
        ));

        $this->assertInstanceOf(Model::class, $manager = $session->manager());
        $this->assertEquals($sessionID, $manager->session_id);
        $this->assertEquals($msisdn, $manager->msisdn);
        $this->assertEquals([], $manager->data->toArray());
        $this->assertEquals([], $manager->menus->toArray());
    }

    public function test_value(): void
    {
        $session = new SessionManager($this->get_handler(
            $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            1,
            $msg = "*120*180#"
        ));

        ($manager = $session->manager())->update(['data' => $manager->data->add($msg)]);

        $this->assertEquals($msg, $session->value());
    }

    public function test_set_get_remove_data(): void
    {
        $session = new SessionManager($this->get_handler(
            $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            1,
            "*120*180#"
        ));

        $session->set('referred_phone_number_1', $phoneNumber = $this->faker->e164PhoneNumber());

        $this->assertEquals($phoneNumber, $session->get('referred_phone_number_1'));

        $session->remove('referred_phone_number_1');

        $this->assertNull($session->get('referred_phone_number_1'));
    }

    private function get_handler(string $sessionID, string $msisdn, int $type, string $msg): HandlerInterface
    {
        return Handler::getHandler((new TruTeqRequestMock($sessionID, $msisdn, $type, $msg))->http());
    }
}
