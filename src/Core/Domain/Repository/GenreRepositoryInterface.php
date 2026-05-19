<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\GenreEntity;

interface GenreRepositoryInterface
{
    /**
     * Persiste um novo gênero.
     *
     * @return GenreEntity Entidade persistida.
     */
    public function insert(GenreEntity $genre): GenreEntity;

    /**
     * Busca um gênero pelo ID.
     *
     * @return GenreEntity|null Entidade encontrada ou null.
     */
    public function findById(string $id): ?GenreEntity;

    /**
     * Lista gêneros com filtro e ordenação opcionais.
     *
     * @param  string  $filter  Filtro opcional, como nome.
     * @param  string  $order  Direção da ordenação: ASC ou DESC.
     * @return GenreEntity[]
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array;

    /**
     * Lista gêneros paginados.
     *
     * @param  string  $filter  Filtro opcional.
     * @param  string  $order  Direção da ordenação: ASC ou DESC.
     * @param  int  $page  Página atual.
     * @param  int  $perPage  Quantidade de itens por página.
     */
    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface;

    /**
     * Atualiza um gênero existente.
     *
     * @return GenreEntity Entidade atualizada.
     */
    public function update(GenreEntity $genre): GenreEntity;

    /**
     * Remove um gênero pelo ID.
     *
     * @return bool True quando a remoção for concluída.
     */
    public function delete(string $id): bool;
}
