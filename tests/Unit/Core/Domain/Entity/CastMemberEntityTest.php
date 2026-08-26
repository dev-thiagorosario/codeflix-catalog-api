<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Entity;

use App\Core\Domain\Entity\CastMemberEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Enum\CastMemberTypeEnum;
use App\Core\Exception\EntityValidationException;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class CastMemberEntityTest extends TestCase
{
    public function test_it_exposes_attributes(): void
    {
        $uuid = (string) UuidResolver::random();
        $createdAt = new DateTime('2026-08-25 10:30:00');

        $castMember = new CastMemberEntity(
            id: new UuidResolver($uuid),
            name: 'Christopher Nolan',
            type: CastMemberTypeEnum::DIRECTOR,
            createdAt: $createdAt,
        );

        $this->assertSame($uuid, $castMember->id());
        $this->assertSame('Christopher Nolan', $castMember->name);
        $this->assertSame(CastMemberTypeEnum::DIRECTOR, $castMember->type);
        $this->assertSame($createdAt, $castMember->createdAt);
        $this->assertSame('2026-08-25 10:30:00', $castMember->createdAt());
    }

    public function test_it_generates_default_id_and_created_at(): void
    {
        $castMember = new CastMemberEntity(
            name: 'Scarlett Johansson',
            type: CastMemberTypeEnum::ACTOR,
        );

        $this->assertTrue(RamseyUuid::isValid($castMember->id()));
        $this->assertInstanceOf(DateTime::class, $castMember->createdAt);
    }

    public function test_it_accepts_string_id_and_created_at(): void
    {
        $uuid = (string) UuidResolver::random();

        $castMember = new CastMemberEntity(
            id: $uuid,
            name: 'Viola Davis',
            type: CastMemberTypeEnum::ACTOR,
            createdAt: '2026-08-24 15:45:00',
        );

        $this->assertSame($uuid, $castMember->id());
        $this->assertSame('2026-08-24 15:45:00', $castMember->createdAt());
    }

    public function test_it_updates_name_and_type(): void
    {
        $castMember = new CastMemberEntity(
            name: 'Greta Gerwig',
            type: CastMemberTypeEnum::ACTOR,
        );

        $castMember->update(
            name: 'Greta Gerwig Updated',
            type: CastMemberTypeEnum::DIRECTOR,
        );

        $this->assertSame('Greta Gerwig Updated', $castMember->name);
        $this->assertSame(CastMemberTypeEnum::DIRECTOR, $castMember->type);
    }

    public function test_it_rejects_blank_names(): void
    {
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage('Should not be empty or null');

        new CastMemberEntity(
            name: '   ',
            type: CastMemberTypeEnum::ACTOR,
        );
    }

    public function test_it_rejects_names_shorter_than_three_characters(): void
    {
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage('The value must be at least 3 characters');

        new CastMemberEntity(
            name: 'Al',
            type: CastMemberTypeEnum::ACTOR,
        );
    }

    public function test_it_rejects_names_longer_than_255_characters(): void
    {
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage('The value must not be greater than 255 characters');

        new CastMemberEntity(
            name: str_repeat('a', 256),
            type: CastMemberTypeEnum::ACTOR,
        );
    }

    public function test_it_does_not_change_attributes_when_an_update_is_invalid(): void
    {
        $castMember = new CastMemberEntity(
            name: 'Jordan Peele',
            type: CastMemberTypeEnum::DIRECTOR,
        );

        try {
            $castMember->update(
                name: 'JP',
                type: CastMemberTypeEnum::ACTOR,
            );

            $this->fail('An invalid name should throw an exception.');
        } catch (EntityValidationException) {
            $this->assertSame('Jordan Peele', $castMember->name);
            $this->assertSame(CastMemberTypeEnum::DIRECTOR, $castMember->type);
        }
    }
}
