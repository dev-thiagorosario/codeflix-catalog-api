<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

/**
 * Contrato para conjuntos paginados usados pelas implementações de repositório.
 */
interface PaginationInterface
{
    /**
     * Retorna os itens da página atual.
     *
     * @return stdClass[]
     */
    public function items(): array;

    /**
     * Quantidade total de registros disponíveis em todas as páginas.
     */
    public function total(): int;

    /**
     * Número da última página disponível.
     */
    public function lastPage(): int;

    /**
     * Número da página atual.
     */
    public function currentPage(): int;

    /**
     * Número da primeira página disponível.
     */
    public function firstPage(): int;

    /**
     * Quantidade de itens retornados por página.
     */
    public function perPage(): int;

    /**
     * Índice do último item da página atual.
     */
    public function to(): int;

    /**
     * Índice do primeiro item da página atual.
     */
    public function from(): int;
}
