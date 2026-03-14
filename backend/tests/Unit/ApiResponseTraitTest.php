<?php

namespace Tests\Unit;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;
use Faker\Factory as Faker;

/**
 * Property-based tests for API Response Structure Consistency
 * 
 * Feature: ibms-proper-structure, Property 1: API Response Structure Consistency
 * Validates: Requirements 1.2
 */
class ApiResponseTraitTest extends TestCase
{
    use ApiResponse;

    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
     * @test
     * @dataProvider successResponseDataProvider
     */
    public function success_response_always_contains_required_fields($data, $message, $code): void
    {
        $response = $this->success($data, $message, $code);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        
        $content = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('success', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertArrayHasKey('data', $content);
        $this->assertIsBool($content['success']);
        $this->assertIsString($content['message']);
        $this->assertTrue($content['success']);
        $this->assertEquals($code, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider errorResponseDataProvider
     */
    public function error_response_always_contains_required_fields($message, $code, $errors): void
    {
        $response = $this->error($message, $code, $errors);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        
        $content = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('success', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertIsBool($content['success']);
        $this->assertIsString($content['message']);
        $this->assertFalse($content['success']);
        $this->assertEquals($code, $response->getStatusCode());
        
        if ($errors !== null) {
            $this->assertArrayHasKey('errors', $content);
        }
    }

    /**
     * @test
     * @dataProvider httpStatusCodeDataProvider
     */
    public function http_status_codes_are_correct($method, $expectedCode): void
    {
        $response = match($method) {
            'success' => $this->success(['test' => 'data']),
            'created' => $this->created(['id' => 1]),
            'unauthorized' => $this->unauthorized(),
            'forbidden' => $this->forbidden(),
            'notFound' => $this->notFound(),
            'validationError' => $this->validationError(['field' => 'error']),
            'serverError' => $this->serverError(),
        };
        
        $this->assertEquals($expectedCode, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function paginated_response_contains_meta_and_links(): void
    {
        $items = collect([
            ['id' => 1, 'name' => 'Item 1'],
            ['id' => 2, 'name' => 'Item 2'],
        ]);
        
        $paginator = new LengthAwarePaginator(
            $items,
            10,
            2,
            1,
            ['path' => 'http://localhost/api/items']
        );
        
        $response = $this->paginated($paginator, 'Items retrieved');
        
        $content = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('success', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('meta', $content);
        $this->assertArrayHasKey('links', $content);
        $this->assertTrue($content['success']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public static function successResponseDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];
        
        for ($i = 0; $i < 5; $i++) {
            $data = ['id' => $faker->randomNumber(), 'name' => $faker->name()];
            $message = $faker->sentence();
            $code = $faker->randomElement([200, 201]);
            
            $testCases["case_{$i}"] = [$data, $message, $code];
        }
        
        return $testCases;
    }

    public static function errorResponseDataProvider(): array
    {
        $faker = Faker::create();
        $testCases = [];
        
        for ($i = 0; $i < 5; $i++) {
            $message = $faker->sentence();
            $code = $faker->randomElement([400, 401, 403, 404, 422, 500]);
            $errors = $faker->boolean() ? [$faker->word() => $faker->sentence()] : null;
            
            $testCases["case_{$i}"] = [$message, $code, $errors];
        }
        
        return $testCases;
    }

    public static function httpStatusCodeDataProvider(): array
    {
        return [
            'success returns 200' => ['success', 200],
            'created returns 201' => ['created', 201],
            'unauthorized returns 401' => ['unauthorized', 401],
            'forbidden returns 403' => ['forbidden', 403],
            'notFound returns 404' => ['notFound', 404],
            'validationError returns 422' => ['validationError', 422],
            'serverError returns 500' => ['serverError', 500],
        ];
    }
}
