<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\CategoryEntity;

interface CategoryRepositoryInterface
{
    /**
     * Persiste uma nova Category.
     *
     * @return CategoryEntity Retorna a entidade persistida (com ID, por exemplo).
     */
    public function insert(CategoryEntity $category): CategoryEntity;

    /**
     * Busca uma Category pelo seu ID.
     *
     * @return CategoryEntity|null Retorna a entidade ou null se não encontrada.
     */
    public function findById(string $id): ?CategoryEntity;

    /**
     * Retorna uma lista de categorias com possibilidade de filtro e ordenação.
     *
     * @param  string  $filter  Filtro opcional (ex: nome).
     * @param  string  $order  Direção da ordenação (ASC ou DESC).
     * @return CategoryEntity[] Lista de entidades.
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array;

    /**
     * Retorna categorias paginadas.
     *
     * @param  string  $filter  Filtro opcional.
     * @param  string  $order  Direção da ordenação.
     * @param  int  $page  Página atual.
     * @param  int  $perPage  Quantidade de itens por página.
     */
    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface;

    /**
     * Atualiza uma Category existente.
     *
     * @return CategoryEntity Retorna a entidade atualizada.
     */
    public function update(CategoryEntity $category): CategoryEntity;

    /**
     * Remove uma Category pelo ID.
     *
     * @return bool True em caso de sucesso.
     */
    public function delete(string $id): bool;

    /**
     * Converte um objeto genérico (ex: Model, stdClass) em CategoryEntity.
     */
    public function toCategoryEntity(object $data): ?CategoryEntity;
}
