<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\CategoryEntity;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    /**
     * Persiste uma nova Category.
     *
     * @param CategoryEntity $category
     * @return CategoryEntity Retorna a entidade persistida (com ID, por exemplo).
     */
    public function insert(CategoryEntity $category): CategoryEntity;

    /**
     * Busca uma Category pelo seu ID.
     *
     * @param string $id
     * @return CategoryEntity|null Retorna a entidade ou null se não encontrada.
     */
    public function findById(string $id): ?CategoryEntity;

    /**
     * Retorna uma lista de categorias com possibilidade de filtro e ordenação.
     *
     * @param string $filter Filtro opcional (ex: nome).
     * @param string $order Direção da ordenação (ASC ou DESC).
     * @return CategoryEntity[] Lista de entidades.
     */
    public function findAll(string $filter = '', $order = 'DESC'): array;

    /**
     * Retorna categorias paginadas.
     *
     * @param string $filter Filtro opcional.
     * @param string $order Direção da ordenação.
     * @param int $page Página atual.
     * @param int $perPage Quantidade de itens por página.
     * @return LengthAwarePaginator
     */
    public function paginate( string $filter = '', $order = 'DESC', int $page = 1, int $perPage = 10): LengthAwarePaginator;

    /**
     * Atualiza uma Category existente.
     *
     * @param CategoryEntity $category
     * @return CategoryEntity Retorna a entidade atualizada.
     */
    public function update(CategoryEntity $category): CategoryEntity;

    /**
     * Remove uma Category pelo ID.
     *
     * @param string $id
     * @return bool True em caso de sucesso.
     */
    public function delete(string $id): bool;

    /**
     * Converte um objeto genérico (ex: Model, stdClass) em CategoryEntity.
     *
     * Esse método geralmente é utilizado na implementação (Infra),
     * mas pode ser definido aqui como contrato para padronizar a conversão.
     *
     * @param object $data
     * @return CategoryEntity|null
     */
    public function toCategoryEntity(object $data): ?CategoryEntity;
}
