<?php
namespace Fefas\SPTrans\API\OlhoVivo;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function initiate()
    {
        $token = json_decode(file_get_contents(__DIR__ .'/token.json'));
        $this->client = new Client($token);
    }

    public function testGetLineAndGetPosition()
    {
        $apiClient = $this->initiate();

        $line = $this->client->getBusLine(8012);
        var_dump($line);

        $this->assertSame(2, count($line));

        $lineCode = $line[0]->CodigoLinha;

        $positions = $this->client->getBusPositionByLineCode($lineCode);

        foreach ($positions->vs as $pos)
            $this->assertSame(
                ['p', 'a', 'py', 'px'],
                array_keys((array) $pos)
            );
    }

    public function testGetStops()
    {
        $apiClient = $this->initiate();

        $stops = $this->client->getStopsByLineCode(8012);

        foreach ($stops as $stop) {
            $this->assertSame(
                ['CodigoParada', 'Nome', 'Endereco', 'Latitude', 'Longitude'],
                array_keys((array) $stop)
            );
        }
    }
}
