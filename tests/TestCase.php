<?php
namespace Tests;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;
use Tests\CreatesApplication;
use Tests\Traits\InteractsWithIoc;
use Tymon\JWTAuth\JWTAuth;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, InteractsWithIoc;
    
    /* @var JWTAuth */
    private $auth;
    public function setUp(): void
    {
        parent::setUp();
        $this->auth = app(JWTAuth::class);
        $this->prepareForTests();
    }
    
    protected function getAsUser($url, $user = null)
    {
        return $this->get($url, [
            'Authorization' => 'Bearer '.$this->generateJwtToken($user),
        ]);
    }

    protected function deleteAsUser($url, $data = [], $user = null)
    {
        return $this->delete($url, $data, [
            'Authorization' => 'Bearer '.$this->generateJwtToken($user),
        ]);
    }

    protected function postAsUser($url, $data, $user = null)
    {
        return $this->post($url, $data, [
            'Authorization' => 'Bearer '.$this->generateJwtToken($user),
        ]);
    }

    protected function putAsUser($url, $data, $user = null)
    {
        return $this->put($url, $data, [
            'Authorization' => 'Bearer '.$this->generateJwtToken($user),
        ]);
    }

    private function generateJwtToken(?User $user): string
    {
        return $this->auth->fromUser($user ?: factory(User::class)->create());
    }
    
    protected function tearDown(): void
    {
        $this->addToAssertionCount(Mockery::getContainer()->mockery_getExpectationCount());
        Mockery::close();
        parent::tearDown();
    }
}