<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\CastMemberEntity;

/**
 * Contrato para persistência e consulta de membros do elenco.
 */
interface CastMemberRepositoryInterface
{
    /**
     * Persiste um novo membro do elenco.
     *
     * @return CastMemberEntity Entidade persistida.
     */
    public function insert(CastMemberEntity $castMember): CastMemberEntity;

    /**
     * Busca um membro do elenco pelo ID.
     *
     * @return CastMemberEntity|null Entidade encontrada ou null.
     */
    public function findById(string $id): ?CastMemberEntity;

    /**
     * Lista membros do elenco com filtro e ordenação opcionais.
     *
     * @param  string  $filter  Filtro opcional, como nome.
     * @param  string  $order  Direção da ordenação: ASC ou DESC.
     * @return CastMemberEntity[]
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array;

    /**
     * Lista membros do elenco paginados.
     *
     * @param  string  $filter  Filtro opcional.
     * @param  string  $order  Direção da ordenação: ASC ou DESC.
     * @param  int  $page  Página atual.
     * @param  int  $perPage  Quantidade de itens por página.
     */
    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface;

    /**
     * Atualiza um membro do elenco existente.
     *
     * @return CastMemberEntity Entidade atualizada.
     */
    public function update(CastMemberEntity $castMember): CastMemberEntity;

    /**
     * Remove um membro do elenco pelo ID.
     */
    public function delete(string $id): void;
}
