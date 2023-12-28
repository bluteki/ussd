<?php

namespace Bluteki\Ussd\Tests\Future\Testing\Mock\TruTeq;

use Bluteki\Ussd\Testing\Mock\TruTeq\Request;
use Bluteki\Ussd\Tests\TestCase;
use Illuminate\Support\Str;
use SimpleXMLElement;

class RequestTest extends TestCase
{
    public function test_tru_teq_xml_with_out_cost(): void
    {
        $request = new Request(
            $sessionID = (string) $this->faker->randomNumber(5),
            $msisdn = $this->faker->e164PhoneNumber(),
            $type = 1,
            $msg = "*120*180#"
        );

        $data = collect((array)(new SimpleXMLElement($request->xml())));

        $this->assertEquals($msisdn, $data->get('msisdn'));
        $this->assertEquals($sessionID, $data->get('sessionid'));
        $this->assertEquals($type, $data->get('type'));
        $this->assertEquals($msg, $data->get('msg'));
    }
}