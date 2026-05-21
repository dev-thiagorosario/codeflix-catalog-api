<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\DBTransaction;

use App\Core\Application\Interfaces\TransactionInterface;
use Illuminate\Support\Facades\DB;

final class DBTransaction implements TransactionInterface
{
    public function commit(): void
    {
        DB::commit();
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
