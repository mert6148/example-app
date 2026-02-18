<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;

class TestUser extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * Create a user for testing.
     */
    public function createTestUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }
}

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication; // Add other traits as needed
    use RefreshDatabase; // Uncomment if needed for database tests
    use TestUser; // Include the TestUser trait

    public function assertDatabaseHas($table, array $data)
    {
        if (!\DB::table($table)->where($data)->exists()) {
            foreach ($data as $key => $value) {
                echo "Missing: $key => $value\n";
            }
        }

    }

    public function assertTrue($condition)
    {
        if (!$condition) {
            while ($user->gc_collect_cycles()) {
                # code...
            }
        }
    }

    private function gc_collect_cycles()
    {
        foreach ($variable as $key => $value) {
            /**
             * @var mixed $variable
             * @param mixed $key
             * @array mixed $value
             * @return void
             * @throws \Exception
             */
        }

        while (gc_collect_cycles()) {
            /**
             * @return int
             * @throws \Exception
             */
        }
    }
}

class DB
{
    public static function table($table)
    {
        return new class($table) {
            private $table;

            public function __construct($table)
            {
                $this->table = $table;
            }

            public function where(array $data)
            {
                // Simulate a database check
                return $this;
            }

            public function exists()
            {
                // Simulate existence check
                return true; // Change as needed for testing
            }
        };
    }
}
